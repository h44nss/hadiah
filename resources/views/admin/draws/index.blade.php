@extends('layouts.app')

@section('title', 'Undian ' . $event->name . ' - Web Undian')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-dark">Undian: {{ $event->name }}</h1>
            <p class="text-muted mb-0">Total: {{ $draws->count() }} undian</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.draws.create', $event) }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Buat Undian Baru
            </a>
            <a href="{{ route('admin.events.show', $event) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        @if ($draws->count() > 0)
            @foreach ($draws as $draw)
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">{{ $draw->name }}</h6>
                            <span class="badge bg-{{ $draw->status == 'completed' ? 'success' : 'warning' }}">
                                {{ $draw->status == 'completed' ? 'Selesai' : 'Belum Dijalankan' }}
                            </span>
                        </div>
                        <div class="card-body">
                            @if ($draw->description)
                                <p class="text-muted">{{ $draw->description }}</p>
                            @endif

                            <div class="row text-center mb-3">
                                <div class="col-6">
                                    <div class="border-end">
                                        <h4 class="text-primary mb-0">{{ $draw->winner_count }}</h4>
                                        <small class="text-muted">Target Pemenang</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h4 class="text-success mb-0">{{ $draw->winners_count }}</h4>
                                    <small class="text-muted">Sudah Terpilih</small>
                                </div>
                            </div>

                            @if ($draw->status == 'pending')
                                <div class="d-grid gap-2">
                                    <form action="{{ route('admin.draws.execute', [$event, $draw]) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menjalankan undian ini? Proses tidak dapat dibatalkan.')">
                                        @csrf
                                        <button type="submit" class="btn btn-success draw-animation">
                                            <i class="fas fa-play me-1"></i>Jalankan Undian
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.draws.show', [$event, $draw]) }}"
                                        class="btn btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i>Lihat Detail
                                    </a>
                                </div>
                            @else
                                <div class="d-grid">
                                    <a href="{{ route('admin.draws.show', [$event, $draw]) }}" class="btn btn-primary">
                                        <i class="fas fa-trophy me-1"></i>Lihat Pemenang
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer text-muted">
                            <small>
                                <i class="fas fa-clock me-1"></i>
                                Dibuat: {{ $draw->created_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-gift fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada undian dibuat</h5>
                        <p class="text-muted">Buat undian pertama untuk event ini</p>
                        <a href="{{ route('admin.draws.create', $event) }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Buat Undian Pertama
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
