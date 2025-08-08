@extends('layouts.app')

@section('title', $event->name . ' - Web Undian')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-dark">{{ $event->name }}</h1>
            <p class="text-muted mb-0">{{ $event->description }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Event Info -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-calendar-alt fa-2x text-primary mb-2"></i>
                    <h6>Tanggal Event</h6>
                    <p class="mb-0">{{ $event->event_date->format('d F Y') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-user fa-2x text-info mb-2"></i>
                    <h6>Penyelenggara</h6>
                    <p class="mb-0">{{ $event->organizer_name }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-users fa-2x text-success mb-2"></i>
                    <h6>Total Peserta</h6>
                    <p class="mb-0">{{ $event->participants->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-gift fa-2x text-warning mb-2"></i>
                    <h6>Total Undian</h6>
                    <p class="mb-0">{{ $event->draws->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="fas fa-users me-2"></i>Kelola Peserta</h6>
                    <a href="{{ route('admin.participants.index', $event) }}" class="btn btn-sm btn-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.participants.create', $event) }}" class="btn btn-outline-primary">
                            <i class="fas fa-user-plus me-1"></i>Tambah Peserta Manual
                        </a>
                        <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="fas fa-file-excel me-1"></i>Import dari Excel
                        </button>
                        <a href="{{ route('admin.participants.export', $event) }}" class="btn btn-outline-info">
                            <i class="fas fa-download me-1"></i>Export ke Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="fas fa-gift me-2"></i>Kelola Undian</h6>
                    <a href="{{ route('admin.draws.index', $event) }}" class="btn btn-sm btn-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.draws.create', $event) }}" class="btn btn-outline-primary">
                            <i class="fas fa-plus me-1"></i>Buat Undian Baru
                        </a>
                        @if ($event->draws->where('status', 'pending')->count() > 0)
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-info-circle me-1"></i>
                                Ada {{ $event->draws->where('status', 'pending')->count() }} undian yang belum dijalankan
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Public Draws List -->
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0"><i class="fas fa-gift me-2"></i>Daftar Undian</h6>
        </div>
        <div class="card-body">
            @if ($event->draws->count() > 0)
                <div class="row">
                    @foreach ($event->draws as $draw)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $draw->name }}</h5>
                                    <p class="card-text">{{ Str::limit($draw->description, 100) }}</p>
                                    <a href="{{ route('public.draw', ['eventSlug' => $event->slug, 'drawSlug' => $draw->slug]) }}"
                                        class="btn btn-primary">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-3">
                    <i class="fas fa-gift fa-2x text-muted mb-2"></i>
                    <p class="text-muted mb-0">Belum ada undian dibuat</p>
                </div>
            @endif
        </div>
    </div>

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#participants-table').DataTable({
                lengthMenu: [5, 10, 25, 50],
                pageLength: 5,
                language: {
                    paginate: {
                        previous: '<i class="fas fa-angle-left small"></i>',
                        next: '<i class="fas fa-angle-right small"></i>'
                    },
                    lengthMenu: 'Tampilkan _MENU_ entri per halaman',
                    zeroRecords: 'Tidak ada data ditemukan',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ entri',
                    infoEmpty: 'Tidak ada data tersedia',
                    search: 'Cari:'
                }
            });
        });
    </script>
@endsection

<!-- Recent Participants -->
<div class="card mb-4 shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><i class="fas fa-users me-2"></i>Peserta Terbaru</h6>
    </div>
    <div class="card-body">
        @if ($event->participants->count() > 0)
            <div class="table-responsive">
                <table id="participants-table" class="table table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Perusahaan</th>
                            <th>Terdaftar</th>
                            <th>Aksi</th> {{-- Kolom tambahan --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($event->participants as $participant)
                            <tr>
                                <td>{{ $participant->name }}</td>
                                <td>{{ $participant->email }}</td>
                                <td>{{ $participant->company }}</td>
                                <td>{{ $participant->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <form action="{{ route('admin.participants.destroy', [$event, $participant]) }}"
                                        method="POST" onsubmit="return confirm('Yakin ingin menghapus peserta ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <i class="fas fa-user-times fa-2x text-muted mb-2"></i>
                <p class="text-muted mb-0">Belum ada peserta terdaftar</p>
            </div>
        @endif
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Peserta dari Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.participants.import', $event) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file" class="form-label">Pilih File Excel</label>
                        <input type="file" class="form-control" id="file" name="file"
                            accept=".xlsx,.xls,.csv" required>
                        <div class="form-text">
                            Format: .xlsx, .xls, atau .csv<br>
                            Kolom yang dibutuhkan: name/nama, email, phone/telepon, company/perusahaan, notes/keterangan
                        </div>
                    </div>
                    <div class="alert alert-info">
                        <strong>Contoh format Excel:</strong><br>
                        <code>Nama | Email | Telepon | Perusahaan | Keterangan</code>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-1"></i>Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
