@extends('layouts.app')

@section('title', $draw->name . ' - Web Undian')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-dark">{{ $draw->name }}</h1>
            <p class="text-muted mb-0">{{ $event->name }}</p>
        </div>
        <div class="d-flex gap-2">
            @if ($draw->status == 'pending')
                <form action="{{ route('admin.draws.execute', [$event, $draw]) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Yakin ingin menjalankan undian ini? Proses tidak dapat dibatalkan.')">
                    @csrf
                    <button type="submit" class="btn btn-success draw-animation">
                        <i class="fas fa-play me-1"></i>Jalankan Undian
                    </button>
                </form>
            @endif
            <a href="{{ route('admin.draws.index', $event) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Draw Info -->
    <div class="row mb-4">
        <!-- info cards tetap sama -->
        {{-- ... Tidak ada perubahan --}}
    </div>

    @if ($draw->description)
        <div class="card mb-4">
            <div class="card-body">
                <h6><i class="fas fa-info-circle me-2"></i>Deskripsi Hadiah</h6>
                <p class="mb-0">{{ $draw->description }}</p>
            </div>
        </div>
    @endif

    <!-- Winners -->
    <div id="draw-area">
        @if ($draw->winners->count() > 0)
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="fas fa-crown me-2"></i>Daftar Pemenang</h6>
                    <span class="badge bg-success">{{ $draw->winners->count() }} dari {{ $draw->winner_count }}
                        pemenang</span>
                </div>
                @if ($draw->image)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $draw->image) }}" alt="Gambar Hadiah" class="img-fluid rounded">
                    </div>
                @endif

                <div class="card-body">
                    <div class="row">
                        @foreach ($draw->winners->sortBy('position') as $winner)
                            <div class="col-md-6 mb-3">
                                <div class="card border-warning">
                                    <div class="card-body text-center">
                                        <div class="position-relative">
                                            @if ($winner->position == 1)
                                                <i class="fas fa-crown fa-3x text-warning mb-2"></i>
                                            @elseif($winner->position == 2)
                                                <i class="fas fa-medal fa-3x text-secondary mb-2"></i>
                                            @elseif($winner->position == 3)
                                                <i class="fas fa-award fa-3x mb-2" style="color: #CD7F32 !important;"></i>
                                            @else
                                                <i class="fas fa-trophy fa-3x text-success mb-2"></i>
                                            @endif
                                            <div class="position-absolute top-0 start-0">
                                                <span class="badge bg-primary rounded-pill">{{ $winner->position }}</span>
                                            </div>
                                        </div>
                                        <h5 class="card-title">{{ $winner->participant->name }}</h5>
                                        @if ($winner->participant->company)
                                            <p class="text-muted mb-1">{{ $winner->participant->company }}</p>
                                        @endif
                                        @if ($winner->participant->email)
                                            <p class="text-muted mb-1">{{ $winner->participant->email }}</p>
                                        @endif
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            Terpilih: {{ $winner->drawn_at->format('d/m/Y H:i:s') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-body text-center py-5">
                    @if ($draw->status == 'pending')
                        <i class="fas fa-hourglass-half fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Undian Belum Dijalankan</h5>
                        <p class="text-muted">Klik tombol "Jalankan Undian" untuk memilih pemenang secara acak</p>
                        @if ($event->participants->count() < $draw->winner_count)
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Peringatan:</strong> Jumlah peserta ({{ $event->participants->count() }})
                                kurang dari target pemenang ({{ $draw->winner_count }})
                            </div>
                        @endif
                    @else
                        <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak Ada Pemenang</h5>
                        <p class="text-muted">Terjadi masalah saat pemilihan pemenang</p>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/real-time-draw.js') }}"></script>
    <script>
        const draw = new RealTimeDraw({{ $draw->id }}, {
            apiUrl: '{{ route('api.draw.winners', $draw->id) }}',
            containerId: 'draw-area',
            interval: 5000
        });

        draw.startDrawing();
    </script>
@endsection
