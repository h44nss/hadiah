@extends('layouts.app')

@section('title', 'Buat Event Baru - Web Undian')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-plus me-2"></i>Buat Event Baru
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Event <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Event</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="event_date" class="form-label">Tanggal Event <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('event_date') is-invalid @enderror"
                                id="event_date" name="event_date" value="{{ old('event_date') }}" required>
                            @error('event_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="organizer_name" class="form-label">Nama Penyelenggara <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('organizer_name') is-invalid @enderror"
                                        id="organizer_name" name="organizer_name" value="{{ old('organizer_name') }}"
                                        required>
                                    @error('organizer_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="organizer_email" class="form-label">Email Penyelenggara <span
                                            class="text-danger">*</span></label>
                                    <input type="email"
                                        class="form-control @error('organizer_email') is-invalid @enderror"
                                        id="organizer_email" name="organizer_email" value="{{ old('organizer_email') }}"
                                        required>
                                    @error('organizer_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-save me-1"></i><span id="submitText">Simpan Event</span>
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
