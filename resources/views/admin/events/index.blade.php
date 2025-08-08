@extends('layouts.app')

@section('title', 'Kelola Event - Web Undian')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-dark">Kelola Event</h1>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>Buat Event Baru
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            @if ($events->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama Event</th>
                                <th>Penyelenggara</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Peserta</th>
                                <th>Undian</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                                <tr>
                                    <td>
                                        <strong>{{ $event->name }}</strong><br>
                                        <small class="text-muted">{{ Str::limit($event->description, 50) }}</small>
                                    </td>
                                    <td>
                                        {{ $event->organizer_name }}<br>
                                        <small class="text-muted">{{ $event->organizer_email }}</small>
                                    </td>
                                    <td>{{ $event->event_date->format('d/m/Y') }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $event->status == 'active' ? 'success' : ($event->status == 'completed' ? 'secondary' : 'warning') }}">
                                            {{ ucfirst($event->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $event->participants_count }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $event->draws_count }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.events.show', $event) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.events.edit', $event) }}"
                                                class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.events.destroy', $event) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus event ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $events->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada event yang dibuat</p>
                    <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Buat Event Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
