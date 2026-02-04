@extends('layouts.admin')
@section('title', 'Laporan Rekapitulasi Cuti')

@push('styles')
<style>
    /* --- CONFIGURATION --- */
    :root {
        --primary: #9E2A2B;
        --secondary: #64748B;
        --dark: #334155;
        --border: #E2E8F0;
    }

    body {
        font-family: 'Plus Jakarta Sans', Arial, sans-serif;
        font-size: 12px;
        color: var(--dark);
        background: white; /* Putih untuk kertas */
    }

    /* --- HEADER --- */
    .header {
        text-align: center;
        margin-bottom: 30px;
        border-bottom: 3px double var(--primary);
        padding-bottom: 20px;
    }
    .header h2 {
        margin: 0;
        font-size: 18px;
        font-weight: 800;
        text-transform: uppercase;
        color: var(--dark);
    }
    .header h3 {
        margin: 5px 0;
        font-size: 14px;
        font-weight: 700;
        color: var(--primary); /* Merah Tema */
        text-transform: uppercase;
    }
    .header p {
        margin: 5px 0;
        font-size: 10px;
        color: var(--secondary);
    }

    /* --- TABLE STYLING (SAMA DENGAN DASHBOARD) --- */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    
    thead th {
        background-color: #F8FAFC;
        color: var(--secondary);
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 12px 10px;
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        text-align: left;
    }

    tbody td {
        padding: 12px 10px;
        border-bottom: 1px solid #F1F5F9;
        vertical-align: middle;
        font-size: 11px;
    }

    /* Striped Rows untuk keterbacaan cetak */
    tbody tr:nth-child(even) {
        background-color: #FCFCFD;
    }

    /* --- BADGES (PILL SHAPE) --- */
    .badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 50px;
        font-size: 10px;
        font-weight: 700;
        text-transform: capitalize;
    }
    
    .badge-approved {
        background-color: #F0FDF4;
        color: #15803D;
        border: 1px solid #DCFCE7;
    }
    
    .badge-pending {
        background-color: #FFF7ED;
        color: #C2410C;
        border: 1px solid #FFEDD5;
    }
    
    .badge-rejected {
        background-color: #FEF2F2;
        color: #B91C1C;
        border: 1px solid #FECACA;
    }

    /* --- FOOTER / TTD --- */
    .footer {
        width: 100%;
        margin-top: 50px;
    }
    .ttd-container {
        float: right;
        width: 200px;
        text-align: center;
    }
    .ttd-date {
        font-size: 11px;
        color: var(--secondary);
        margin-bottom: 5px;
    }
    .ttd-jabatan {
        font-weight: bold;
        margin-bottom: 60px; /* Ruang untuk tanda tangan */
    }
    .ttd-nama {
        font-weight: bold;
        text-decoration: underline;
    }
</style>
@endpush

@section('content')
    <div class="header">
        <h2>Pemerintah Kabupaten Semarang</h2>
        <h3>Rekapitulasi Pengajuan Cuti Pegawai</h3>
        <p>Laporan digenerate otomatis pada: {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 25%">Pegawai</th>
                <th style="width: 15%">Unit Kerja</th>
                <th style="width: 15%">Jenis Cuti</th>
                <th style="width: 20%; text-align: center;">Tanggal Cuti</th>
                <th style="width: 10%; text-align: center;">Durasi</th>
                <th style="width: 10%; text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $item)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>
                    <div style="font-weight: bold; color: #334155;">{{ $item->user->name ?? '-' }}</div>
                    <div style="font-size: 10px; color: #64748B;">NIP. {{ $item->user->nip ?? '-' }}</div>
                </td>
                <td>{{ $item->user->bidang_unit ?? '-' }}</td>
                <td style="font-weight: 500;">{{ $item->jenis_cuti }}</td>
                <td style="text-align: center;">
                    {{ \Carbon\Carbon::parse($item->start_date)->format('d/m/y') }} - {{ \Carbon\Carbon::parse($item->end_date)->format('d/m/y') }}
                </td>
                <td style="text-align: center;">
                    {{ \Carbon\Carbon::parse($item->start_date)->diffInDays(\Carbon\Carbon::parse($item->end_date)) + 1 }} Hari
                </td>
                <td style="text-align: center;">
                    @if($item->status == 'approved' || $item->status == 'disetujui')
                        <span class="badge badge-approved">Disetujui</span>
                    @elseif($item->status == 'rejected' || $item->status == 'ditolak')
                        <span class="badge badge-rejected">Ditolak</span>
                    @else
                        <span class="badge badge-pending">Menunggu</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 30px; color: #64748B;">
                    <i>Tidak ada data pengajuan cuti yang ditemukan untuk periode ini.</i>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="ttd-container">
            <div class="ttd-date">Semarang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
            <div class="ttd-jabatan">Kepala Dinas</div>
            <div class="ttd-nama">( Nama Kepala Dinas )</div>
            <div style="font-size: 10px;">NIP. 19xxxxxxxxxxxxxx</div>
        </div>
    </div>
@endsection