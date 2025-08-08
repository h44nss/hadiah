@extends('layouts.app')

@section('title', 'Edit Event - Web Undian')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Edit Event
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Event <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $event->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="3">{{ old('description', $event->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror"
                                required>
                                <option value="active" {{ old('status', $event->status) === 'active' ? 'selected' : '' }}>
                                    Aktif</option>
                                <option value="inactive"
                                    {{ old('status', $event->status) === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                                <option value="completed"
                                    {{ old('status', $event->status) === 'completed' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="event_date" class="form-label">Tanggal Event <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('event_date') is-invalid @enderror"
                                id="event_date" name="event_date"
                                value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}" required>
                            @error('event_date')
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

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="organizer_name" class="form-label">Nama Penyelenggara <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('organizer_name') is-invalid @enderror"
                                        id="organizer_name" name="organizer_name"
                                        value="{{ old('organizer_name', $event->organizer_name) }}" required>
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
                                        id="organizer_email" name="organizer_email"
                                        value="{{ old('organizer_email', $event->organizer_email) }}" required>
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
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Update Event
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
