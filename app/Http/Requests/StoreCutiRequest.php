<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\LeaveRequest;
use Carbon\Carbon;

class StoreCutiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'supervisor_id'          => ['required', 'exists:supervisors,id'],
            'plt_jabatan'            => 'nullable|string|max:255',
            'jenis_cuti'             => ['required', 'in:Cuti Tahunan,Cuti Besar,Cuti Sakit,Cuti Melahirkan,Cuti Alasan Penting,Cuti Karena Alasan Penting,Cuti Luar Tanggungan,Cuti di Luar Tanggungan Negara,Cuti di luar tanggungan Negara'],
            'alasan'                 => ['required', 'string', 'min:20', 'max:1000'],
            'lama_hari'              => ['required', 'integer', 'min:1', 'max:365'],
            'tanggal_mulai'          => 'required|date|after_or_equal:' . now()->subDays(30)->toDateString(),
            'tanggal_selesai'        => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'alamat_cuti'            => ['required', 'string', 'min:10', 'max:500'],
            'no_telepon'             => ['required', 'string', 'regex:/^[0-9+\-\s]{7,20}$/'],
            'no_telepon_darurat'     => ['required', 'string', 'regex:/^[0-9+\-\s]{7,20}$/'],
            'hubungan_darurat'       => ['required', 'string', 'max:50'],
            'catatan_tambahan'       => ['nullable', 'string', 'max:1000'],
            'dokumen_pendukung'      => [
                'nullable',
                'file',
                'max:5120',  // 5MB
                'mimes:pdf,docx,jpg,jpeg,png',
                function ($attribute, $value, $fail) {
                    $allowedMimes = [
                        'application/pdf',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'image/jpeg',
                        'image/png',
                    ];

                    if (!in_array($value->getMimeType(), $allowedMimes)) {
                        $fail('Tipe file tidak diizinkan. Hanya PDF, DOCX, JPG, dan PNG.');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'supervisor_id.required'      => 'Atasan langsung wajib dipilih.',
            'supervisor_id.exists'        => 'Atasan yang dipilih tidak valid.',
            'jenis_cuti.required'         => 'Jenis cuti wajib dipilih.',
            'jenis_cuti.in'               => 'Jenis cuti tidak valid.',
            'alasan.required'             => 'Alasan cuti wajib diisi.',
            'alasan.min'                  => 'Alasan cuti minimal 20 karakter.',
            'lama_hari.required'          => 'Lama hari cuti wajib diisi.',
            'lama_hari.min'               => 'Lama cuti minimal 1 hari.',
            'tanggal_mulai.after_or_equal'=> 'Tanggal mulai tidak boleh sebelum hari ini.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            'alamat_cuti.required'        => 'Alamat selama cuti wajib diisi.',
            'no_telepon.required'         => 'Nomor telepon wajib diisi.',
            'no_telepon.regex'            => 'Format nomor telepon tidak valid.',
            'no_telepon_darurat.required' => 'Nomor telepon darurat wajib diisi.',
            'no_telepon_darurat.regex'    => 'Format nomor telepon darurat tidak valid.',
            'hubungan_darurat.required'   => 'Hubungan kontak darurat wajib diisi.',
            'dokumen_pendukung.max'       => 'Ukuran file maksimal 5MB.',
            'dokumen_pendukung.mimes'     => 'Format file harus PDF, DOCX, JPG, atau PNG.',
        ];
    }

    public function isCutiTahunan(): bool
    {
        return $this->jenis_cuti === 'Cuti Tahunan';
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->input('jenis_cuti') !== 'Cuti Besar') {
                return;
            }

            $userId = auth()->id();
            $tahunIni = now()->year;

            // Cek apakah sudah ada cuti besar approved dalam 5 tahun terakhir
            $lastApproved = LeaveRequest::where('user_id', $userId)
                ->where('jenis_cuti', 'Cuti Besar')
                ->where('status', LeaveRequest::STATUS_APPROVED)
                ->orderByDesc('start_date')
                ->first();

            if ($lastApproved) {
                $lastYear = Carbon::parse($lastApproved->start_date)->year;
                $diff = $tahunIni - $lastYear;

                if ($diff < 5) {
                    $bolehTahun = $lastYear + 5;
                    $validator->errors()->add(
                        'jenis_cuti',
                        "Anda baru dapat mengajukan Cuti Besar lagi pada tahun {$bolehTahun}. " .
                        "Cuti Besar terakhir diambil tahun {$lastYear}."
                    );
                    return;
                }
            }

            // Cek apakah sudah ada cuti besar pending/approved di tahun ini
            $sudahAda = LeaveRequest::where('user_id', $userId)
                ->where('jenis_cuti', 'Cuti Besar')
                ->whereIn('status', [LeaveRequest::STATUS_APPROVED, LeaveRequest::STATUS_PENDING])
                ->whereYear('start_date', $tahunIni)
                ->exists();

            if ($sudahAda) {
                $validator->errors()->add(
                    'jenis_cuti',
                    'Anda sudah memiliki pengajuan Cuti Besar yang sedang diproses atau telah disetujui tahun ini.'
                );
            }
        });
    }
}