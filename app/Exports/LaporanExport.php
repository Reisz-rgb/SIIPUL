<?php

namespace App\Exports;

use App\Models\LeaveRequest;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanExport implements FromQuery, WithHeadings, WithMapping, WithColumnWidths, WithStyles, WithEvents
{
    use Exportable;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    // =========================================================================
    // QUERY (tidak diubah dari versi lama)
    // =========================================================================

    public function query()
    {
        $query = LeaveRequest::query()->with('user');

        $filter = $this->request->input('filter', '1_bulan');

        if ($filter == '1_bulan') {
            $startDate = Carbon::now()->subMonth();
        } elseif ($filter == '3_bulan') {
            $startDate = Carbon::now()->subMonths(3);
        } else {
            $startDate = Carbon::now()->startOfYear();
        }

        $query->where('created_at', '>=', $startDate);

        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            });
        }

        if ($this->request->filled('bidang_unit')) {
            $bidang = $this->request->bidang_unit;
            $query->whereHas('user', function ($q) use ($bidang) {
                $q->where('bidang_unit', $bidang);
            });
        }

        return $query;
    }

    // =========================================================================
    // HEADINGS — baris 4 (setelah 3 baris header instansi)
    // =========================================================================

    public function headings(): array
    {
        // 3 baris pertama = header instansi, diisi manual di AfterSheet
        // Baris ke-4 = heading kolom
        return [
            ['PEMERINTAH KABUPATEN SEMARANG'],                          // baris 1
            ['REKAPITULASI PENGAJUAN CUTI PEGAWAI'],                    // baris 2
            ['Dicetak pada: ' . Carbon::now()->translatedFormat('d F Y, H:i')], // baris 3
            [                                                           // baris 4 = kolom header
                'Nama Pegawai',
                'NIP',
                'Bidang / Unit',
                'Jenis Cuti',
                'Tanggal Mulai',
                'Tanggal Selesai',
                'Jumlah Hari',
                'Alasan',
                'Status',
                'Tanggal Pengajuan',
            ],
        ];
    }

    // =========================================================================
    // MAPPING — format data tiap baris
    // =========================================================================

    public function map($leaveRequest): array
    {
        return [
            $leaveRequest->user->name        ?? '-',
            $leaveRequest->user->nip         ?? '-',
            $leaveRequest->user->bidang_unit ?? '-',
            $leaveRequest->jenis_cuti        ?? '-',
            $leaveRequest->start_date
                ? Carbon::parse($leaveRequest->start_date)->format('d/m/Y') : '-',
            $leaveRequest->end_date
                ? Carbon::parse($leaveRequest->end_date)->format('d/m/Y')   : '-',
            ($leaveRequest->start_date && $leaveRequest->end_date)
                ? Carbon::parse($leaveRequest->start_date)->diffInDays(Carbon::parse($leaveRequest->end_date)) + 1
                : '-',
            $leaveRequest->reason            ?? '-',
            ucfirst($leaveRequest->status)   ?? '-',
            $leaveRequest->created_at->format('d/m/Y H:i'),
        ];
    }

    // =========================================================================
    // COLUMN WIDTHS
    // =========================================================================

    public function columnWidths(): array
    {
        return [
            'A' => 28, // Nama Pegawai
            'B' => 20, // NIP
            'C' => 25, // Bidang / Unit
            'D' => 20, // Jenis Cuti
            'E' => 14, // Tanggal Mulai
            'F' => 14, // Tanggal Selesai
            'G' => 12, // Jumlah Hari
            'H' => 35, // Alasan
            'I' => 12, // Status
            'J' => 18, // Tanggal Pengajuan
        ];
    }

    // =========================================================================
    // STYLES — styling per baris/kolom
    // =========================================================================

    public function styles(Worksheet $sheet)
    {
        // Baris 1: Judul instansi
        $sheet->mergeCells('A1:J1');
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 14, 'name' => 'Arial', 'color' => ['argb' => 'FFA52A2A']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(26);

        // Baris 2: Sub-judul
        $sheet->mergeCells('A2:J2');
        $sheet->getStyle('A2')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 12, 'name' => 'Arial', 'color' => ['argb' => 'FF333333']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(20);

        // Baris 3: Tanggal cetak
        $sheet->mergeCells('A3:J3');
        $sheet->getStyle('A3')->applyFromArray([
            'font'      => ['size' => 9, 'italic' => true, 'name' => 'Arial', 'color' => ['argb' => 'FF555555']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['bottom' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['argb' => 'FF333333']]],
        ]);
        $sheet->getRowDimension(3)->setRowHeight(18);

        // Baris 4: Header kolom
        $sheet->getStyle('A4:J4')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 10, 'name' => 'Arial', 'color' => ['argb' => 'FF000000']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF2F2F2']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'borders'   => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN,   'color' => ['argb' => 'FFCCCCCC']],
                'bottom'     => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['argb' => 'FF333333']],
                'top'        => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['argb' => 'FF333333']],
            ],
        ]);
        $sheet->getRowDimension(4)->setRowHeight(22);

        return [];
    }

    // =========================================================================
    // EVENTS — styling data rows & footer (dijalankan setelah semua data ditulis)
    // =========================================================================

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet    = $event->sheet->getDelegate();
                $lastRow  = $sheet->getHighestRow();

                $statusColor = [
                    'Approved' => ['font' => 'FF1D7A3A', 'bg' => 'FFE6F4EA'],
                    'Rejected' => ['font' => 'FFB91C1C', 'bg' => 'FFFEE2E2'],
                    'Pending'  => ['font' => 'FFB45309', 'bg' => 'FFFEF3C7'],
                ];

                // Data mulai baris 5
                for ($row = 5; $row <= $lastRow; $row++) {
                    $rowBg = ($row % 2 === 0) ? 'FFF9FAFB' : 'FFFFFFFF';

                    // Style seluruh baris
                    $sheet->getStyle("A{$row}:J{$row}")->applyFromArray([
                        'font'      => ['size' => 10, 'name' => 'Arial'],
                        'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $rowBg]],
                        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                        'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFCCCCCC']]],
                    ]);

                    // Kolom Status (I) — warna sesuai nilai
                    $statusVal = $sheet->getCell("I{$row}")->getValue();
                    $st        = $statusColor[$statusVal] ?? ['font' => 'FF333333', 'bg' => $rowBg];

                    $sheet->getStyle("I{$row}")->applyFromArray([
                        'font'      => ['bold' => true, 'size' => 10, 'name' => 'Arial', 'color' => ['argb' => $st['font']]],
                        'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $st['bg']]],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    ]);

                    // Center kolom tanggal, jumlah hari & tanggal pengajuan
                    foreach (['E', 'F', 'G', 'J'] as $col) {
                        $sheet->getStyle("{$col}{$row}")->getAlignment()
                            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    }

                    $sheet->getRowDimension($row)->setRowHeight(22);
                }

                // ── FOOTER TTD ────────────────────────────────────────────
                $footerRow = $lastRow + 4;

                $sheet->mergeCells("H{$footerRow}:J{$footerRow}");
                $sheet->setCellValue("H{$footerRow}", 'Mengetahui,');
                $sheet->getStyle("H{$footerRow}")->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('H' . ($footerRow + 1) . ':J' . ($footerRow + 1));
                $sheet->setCellValue('H' . ($footerRow + 1), 'Kepala Dinas');
                $sheet->getStyle('H' . ($footerRow + 1))->applyFromArray([
                    'font'      => ['bold' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                $sheet->mergeCells('H' . ($footerRow + 5) . ':J' . ($footerRow + 5));
                $sheet->setCellValue('H' . ($footerRow + 5), '__________________________');
                $sheet->getStyle('H' . ($footerRow + 5))->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->freezePane('A5');
                $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getPageSetup()->setFitToWidth(1);
                $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 4);
            },
        ];
    }
}