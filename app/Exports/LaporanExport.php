<?php

namespace App\Exports;

use App\Models\LeaveRequest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        // Query sesuai filter dari dashboard
        $query = LeaveRequest::with('user');

        if ($this->request->start_date && $this->request->end_date) {
            $query->whereBetween('start_date', [$this->request->start_date, $this->request->end_date]);
        }
        
        if ($this->request->status) {
            $query->where('status', $this->request->status);
        }

        return $query->get()->map(function($item) {
            return [
                'Nama' => $item->user->name,
                'Jenis Cuti' => $item->jenis_cuti,
                'Mulai' => $item->start_date,
                'Selesai' => $item->end_date,
                'Status' => $item->status,
            ];
        });
    }

    public function headings(): array
    {
        return ['Nama Pegawai', 'Jenis Cuti', 'Tanggal Mulai', 'Tanggal Selesai', 'Status'];
    }
}