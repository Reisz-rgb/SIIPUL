<?php

namespace App\Helpers;

/**
 * MergeFieldReplacer
 *
 * Replace Word MERGEFIELD values di dalam DOCX via manipulasi XML langsung.
 * MERGEFIELD tersimpan sebagai <w:instrText> MERGEFIELD FieldName </w:instrText>
 * dan tidak bisa dihandle oleh PhpWord TemplateProcessor.
 */
class MergeFieldReplacer
{
    private string $sourcePath;

    /** @var array<string, string> */
    private array $replacements = [];

    public function __construct(string $sourcePath)
    {
        if (!file_exists($sourcePath)) {
            throw new \RuntimeException(
                "MergeFieldReplacer: source file tidak ditemukan: {$sourcePath}"
            );
        }

        $this->sourcePath = $sourcePath;
    }

    public function setValue(string $fieldName, string $value): self
    {
        $this->replacements[$fieldName] = $value;
        return $this;
    }

    /**
     * Proses MERGEFIELD dan timpa file source langsung (in-place).
     * Gunakan ini bila source sudah merupakan file temp yang aman untuk diubah.
     */
    public function saveInPlace(): string
    {
        // Baca konten, proses, tulis balik langsung tanpa copy
        $zip = new \ZipArchive();
        $result = $zip->open($this->sourcePath);

        if ($result !== true) {
            throw new \RuntimeException(
                "MergeFieldReplacer: gagal membuka ZIP ({$result}): {$this->sourcePath}"
            );
        }

        foreach (['word/document.xml', 'word/header1.xml', 'word/footer1.xml'] as $part) {
            $content = $zip->getFromName($part);
            if ($content === false) {
                continue;
            }

            $processed = $this->replaceMergeFields($content);
            $zip->addFromString($part, $processed);
        }

        $zip->close();

        return $this->sourcePath;
    }

    /**
     * Proses MERGEFIELD dan simpan ke $destPath (berbeda dari source).
     */
    public function save(string $destPath): string
    {
        if (!copy($this->sourcePath, $destPath)) {
            throw new \RuntimeException(
                "MergeFieldReplacer: gagal menyalin [{$this->sourcePath}] ke [{$destPath}]"
            );
        }

        $zip = new \ZipArchive();
        $result = $zip->open($destPath);

        if ($result !== true) {
            throw new \RuntimeException(
                "MergeFieldReplacer: gagal membuka ZIP ({$result}): {$destPath}"
            );
        }

        foreach (['word/document.xml', 'word/header1.xml', 'word/footer1.xml'] as $part) {
            $content = $zip->getFromName($part);
            if ($content === false) {
                continue;
            }

            $processed = $this->replaceMergeFields($content);
            $zip->addFromString($part, $processed);
        }

        $zip->close();

        return $destPath;
    }

    // -------------------------------------------------------------------------

    private function replaceMergeFields(string $xml): string
    {
        if (empty($this->replacements)) {
            return $xml;
        }

        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = true;
        $dom->formatOutput       = false;

        if (!$dom->loadXML($xml, LIBXML_NOERROR | LIBXML_NOWARNING)) {
            return $xml;
        }

        $xpath = new \DOMXPath($dom);
        $xpath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');

        // Cari semua instrText yang mengandung MERGEFIELD
        $instrNodes = $xpath->query('//w:instrText[contains(., "MERGEFIELD")]');

        foreach ($instrNodes as $instrNode) {
            $fieldName = $this->extractFieldName(trim($instrNode->textContent));

            if ($fieldName === null || !array_key_exists($fieldName, $this->replacements)) {
                continue;
            }

            $newValue = htmlspecialchars(
                $this->replacements[$fieldName],
                ENT_XML1 | ENT_QUOTES,
                'UTF-8'
            );

            // Naik ke parent <w:r>, lalu ke container (<w:p> atau <w:tc>)
            $instrRun  = $instrNode->parentNode;  // <w:r>
            $container = $instrRun->parentNode;   // <w:p>

            // Kumpulkan semua child nodes dari container sebagai array
            $children = [];
            foreach ($container->childNodes as $child) {
                $children[] = $child;
            }

            // Cari index dari run yang mengandung instrText ini
            $instrRunIndex = null;
            foreach ($children as $idx => $child) {
                if ($child->isSameNode($instrRun)) {
                    $instrRunIndex = $idx;
                    break;
                }
            }

            if ($instrRunIndex === null) {
                continue;
            }

            // Iterasi maju dari instrRun, cari fase: separate → end
            $phase = 'before_separate'; // before_separate | after_separate
            $replaced = false;

            for ($i = $instrRunIndex + 1; $i < count($children); $i++) {
                $child = $children[$i];

                // Lewati node yang bukan <w:r>
                if (!($child instanceof \DOMElement) || $child->localName !== 'r') {
                    continue;
                }

                // Cek apakah run ini mengandung fldChar
                $fldChars = $xpath->query('w:fldChar', $child);
                foreach ($fldChars as $fldChar) {
                    $type = $fldChar->getAttributeNS(
                        'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
                        'fldCharType'
                    );

                    if ($type === 'separate') {
                        $phase = 'after_separate';
                        continue 2; // lanjut ke run berikutnya
                    }

                    if ($type === 'end') {
                        // Selesai untuk field ini, lanjut ke instrNode berikutnya
                        continue 3; // ← hanya keluar dari for($i), bukan dari foreach($instrNodes)
                    }
                }

                // Jika sudah melewati separate, cari <w:t> di run ini untuk diganti
                if ($phase === 'after_separate' && !$replaced) {
                    $tNodes = $xpath->query('w:t', $child);
                    if ($tNodes->length > 0) {
                        $tNodes->item(0)->textContent = html_entity_decode(
                            $newValue, ENT_XML1 | ENT_QUOTES, 'UTF-8'
                        );
                        $replaced = true;
                        // Lanjut terus sampai ketemu 'end' untuk bersihkan sisa run display
                    }
                }
            }
        }

        $result = $dom->saveXML();
        return $result !== false ? $result : $xml;
    }

    private function extractFieldName(string $instrText): ?string
    {
        if (preg_match('/MERGEFIELD\s+"?([^"\s\\\\]+)"?/i', $instrText, $matches)) {
            return trim($matches[1]);
        }
        return null;
    }
}