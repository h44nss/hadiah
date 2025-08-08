@extends('layouts.app')

@section('title', 'Peserta ' . $event->name . ' - Web Undian')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-dark">Peserta: {{ $event->name }}</h1>
            <p class="text-muted mb-0">Total: {{ $participants->total() }} peserta</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="fas fa-file-excel me-1"></i>Import Excel
            </button>
            <a href="{{ route('admin.participants.create', $event) }}" class="btn btn-primary">
                <i class="fas fa-user-plus me-1"></i>Tambah Peserta
            </a>
            <a href="{{ route('admin.events.show', $event) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#participants-table').DataTable({
                lengthMenu: [5, 10, 25, 50],
                pageLength: 25,
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

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Daftar Peserta</h6>
        @if ($participants->count() > 0)
            <a href="{{ route('admin.participants.export', $event) }}" class="btn btn-sm btn-outline-info">
                <i class="fas fa-download me-1"></i>Export Excel
            </a>
        @endif
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
    </div>
@else
    <div class="text-center py-4">
        <i class="fas fa-user-times fa-3x text-muted mb-3"></i>
        <p class="text-muted">Belum ada peserta terdaftar</p>
        <div class="d-flex gap-2 justify-content-center">
            <a href="{{ route('admin.participants.create', $event) }}" class="btn btn-primary">
                <i class="fas fa-user-plus me-1"></i>Tambah Peserta Manual
            </a>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="fas fa-file-excel me-1"></i>Import dari Excel
            </button>
        </div>
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
                            Format: .xlsx, .xls, atau .csv
                        </div>
                    </div>
                    <div class="alert alert-info">
                        <strong>Format yang dibutuhkan:</strong><br>
                        <table class="table table-sm table-bordered mt-2">
                            <thead>
                                <tr>
                                    <th>Kolom Excel</th>
                                    <th>Alternatif</th>
                                    <th>Wajib</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>name</td>
                                    <td>nama</td>
                                    <td>Ya</td>
                                </tr>
                                <tr>
                                    <td>email</td>
                                    <td>-</td>
                                    <td>Tidak</td>
                                </tr>
                                <tr>
                                    <td>phone</td>
                                    <td>telepon</td>
                                    <td>Tidak</td>
                                </tr>
                                <tr>
                                    <td>company</td>
                                    <td>perusahaan</td>
                                    <td>Tidak</td>
                                </tr>
                                <tr>
                                    <td>notes</td>
                                    <td>keterangan</td>
                                    <td>Tidak</td>
                                </tr>
                            </tbody>
                        </table>
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
