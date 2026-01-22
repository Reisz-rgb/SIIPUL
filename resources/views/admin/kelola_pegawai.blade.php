<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pegawai - SIIPUL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root { --primary-red: #A52A2A; --bg-light: #f8f9fa; }
        body { background-color: var(--bg-light); font-family: 'Segoe UI', sans-serif; }
        .navbar-custom { background-color: var(--primary-red); color: white; }
        .navbar-brand { font-weight: bold; font-size: 1.2rem; display: flex; align-items: center; gap: 10px; color: white !important; }
        .navbar-brand:hover { color: #e0e0e0 !important; }
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        .header-left { display: flex; align-items: center; gap: 15px; }
        .btn-back-arrow { font-size: 1.5rem; color: #333; text-decoration: none; }
        .btn-add-custom { background-color: var(--primary-red); color: white; border: none; padding: 8px 20px; border-radius: 6px; font-size: 0.9rem; display: flex; align-items: center; gap: 8px; text-decoration: none; transition: background-color 0.2s; }
        .btn-add-custom:hover { background-color: #8a2323; color: white; }
        .filter-card { border: 1px solid #e0e0e0; border-radius: 8px; padding: 20px; background: white; margin-bottom: 20px; }
        .stat-card-simple { background: white; border: 1px solid #e0e0e0; border-radius: 8px; padding: 20px; height: 100%; }
        .stat-num { font-size: 1.8rem; font-weight: 600; margin-top: 5px; margin-bottom: 0; }
        .table-card { background: white; border: 1px solid #e0e0e0; border-radius: 8px; padding: 0; overflow: hidden; }
        .table thead th { background-color: #f9f9f9; font-weight: 600; color: #555; font-size: 0.9rem; border-bottom: 2px solid #eee; padding: 15px; }
        .table tbody td { padding: 15px; vertical-align: middle; font-size: 0.9rem; color: #333; border-bottom: 1px solid #eee; }
        .badge-active { background-color: #e6f8ef; color: #198754; border: 1px solid #c3e6cb; border-radius: 20px; padding: 5px 12px; font-weight: 500; font-size: 0.8rem; }
        .badge-inactive { background-color: #f8f9fa; color: #6c757d; border: 1px solid #dee2e6; border-radius: 20px; padding: 5px 12px; font-weight: 500; font-size: 0.8rem; }
        
        /* Fix Pagination Style agar rapi */
        .pagination { margin-bottom: 0; }
        .page-item.active .page-link { background-color: var(--primary-red); border-color: var(--primary-red); }
        .page-link { color: #333; }
    </style>
</head>
<body>

    <nav class="navbar navbar-custom py-3">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('logokabupatensemarang.png') }}" alt="Logo" width="40" height="auto" class="d-inline-block align-text-top me-2"> 
                SIIPUL Dashboard
            </a>
        </div>
    </nav>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="container-fluid px-4 mt-4 mb-5">
        
        <div class="page-header">
            <div class="header-left">
                <a href="{{ route('admin.dashboard') }}" class="btn-back-arrow"><i class="bi bi-arrow-left"></i></a>
                <h4 class="mb-0 text-secondary">Kelola Pegawai</h4>
            </div>

            <a href="{{ route('admin.tambah_pegawai') }}" class="btn-add-custom shadow-sm">
                <i class="bi bi-plus-lg"></i> Tambah Pegawai
            </a>
        </div>

        <div class="filter-card shadow-sm">
            <form action="{{ route('admin.kelola_pegawai') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label small text-muted">Cari Pegawai</label>
                        <input type="text" name="search" class="form-control" placeholder="Nama pegawai atau NIP..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Aksi</label><br>
                        <button type="submit" class="btn btn-dark w-100">Cari</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>No</th> <th>Nama & NIP</th>
                            <th>Posisi</th>
                            <th>Unit Kerja</th>
                            <th>Cuti</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pegawai as $p)
                        <tr>
                            <td>{{ $loop->iteration + $pegawai->firstItem() - 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle" style="width: 40px; height: 40px; background-color: #A52A2A; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                        {{ substr($p->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <span class="fw-bold d-block text-dark">{{ $p->name }}</span>
                                        <span class="text-muted small">{{ $p->nip }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $p->jabatan ?? '-' }}</td>
                            <td>{{ $p->bidang_unit ?? '-' }}</td>
                            <td>
                                {{ $p->annual_leave_quota ?? 12 }}/12 <br> 
                                <span class="text-muted" style="font-size: 0.75rem">Sisa/Total</span>
                            </td>
                            <td>
                                @if($p->status == 'nonaktif')
                                    <span class="badge-inactive">Non-aktif</span>
                                @else
                                    <span class="badge-active">Aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.pegawai.edit', $p->id) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    
                                    <form id="delete-form-{{ $p->id }}" action="{{ route('admin.pegawai.destroy', $p->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        
                                        <button type="button" onclick="konfirmasiHapus({{ $p->id }})" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-emoji-frown fs-1 text-muted"></i>
                                <p class="mt-2 text-muted">Belum ada data pegawai.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center p-3 border-top">
                <small class="text-muted">
                    Menampilkan {{ $pegawai->firstItem() }} s/d {{ $pegawai->lastItem() }} dari {{ $pegawai->total() }} pegawai
                </small>
                <div>
                    {{ $pegawai->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function konfirmasiHapus(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33', // Warna merah untuk tombol hapus
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Cari form berdasarkan ID yang dikirim, lalu submit
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#A52A2A'
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ session('error') }}',
        confirmButtonColor: '#A52A2A'
    });
</script>
@endif

</body>
</html>