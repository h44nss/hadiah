@extends('layouts.app')

@section('title', 'Buat Undian Baru - Web Undian')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-gift me-2"></i>Buat Undian Baru: {{ $event->name }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Informasi:</strong> Event ini memiliki {{ $event->participants->count() }} peserta
                        terdaftar.
                    </div>

                    <form action="{{ route('admin.draws.store', $event) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Undian <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}"
                                placeholder="Contoh: Hadiah Utama, Door Prize, Hadiah Hiburan" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Hadiah</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="3" placeholder="Deskripsikan hadiah yang akan diberikan...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Hadiah</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="winner_count" class="form-label">Jumlah Pemenang <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('winner_count') is-invalid @enderror"
                                id="winner_count" name="winner_count" value="{{ old('winner_count', 1) }}" min="1"
                                max="{{ $event->participants->count() }}" required>
                            <div class="form-text">
                                Maksimal {{ $event->participants->count() }} pemenang (sesuai jumlah peserta)
                            </div>
                            @error('winner_count')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.draws.index', $event) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Simpan Undian
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
