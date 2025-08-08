<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard - Web Undian')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-dark">Dashboard</h1>
        <div class="text-muted">
            <i class="fas fa-calendar me-1"></i>{{ date('d F Y') }}
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card stats-card">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-alt fa-2x mb-2"></i>
                    <h2 class="mb-1">{{ $stats['total_events'] }}</h2>
                    <p class="mb-0">Total Event</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stats-card">
                <div class="card-body text-center">
                    <i class="fas fa-play fa-2x mb-2"></i>
                    <h2 class="mb-1">{{ $stats['active_events'] }}</h2>
                    <p class="mb-0">Event Aktif</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stats-card">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-2x mb-2"></i>
                    <h2 class="mb-1">{{ $stats['total_participants'] }}</h2>
                    <p class="mb-0">Total Peserta</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stats-card">
                <div class="card-body text-center">
                    <i class="fas fa-gift fa-2x mb-2"></i>
                    <h2 class="mb-1">{{ $stats['completed_draws'] }}</h2>
                    <p class="mb-0">Undian Selesai</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Events -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Event Terbaru</h5>
            <a href="{{ route('admin.events.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i>Buat Event
            </a>
        </div>
        <div class="card-body">
            @if ($recent_events->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama Event</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Peserta</th>
                                <th>Undian</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recent_events as $event)
                                <tr>
                                    <td>
                                        <strong>{{ $event->name }}</strong><br>
                                        <small class="text-muted">{{ $event->organizer_name }}</small>
                                    </td>
                                    <td>{{ $event->event_date->format('d/m/Y') }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $event->status == 'active' ? 'success' : ($event->status == 'completed' ? 'secondary' : 'warning') }}">
                                            {{ ucfirst($event->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $event->participants_count }}</td>
                                    <td>{{ $event->draws_count }}</td>
                                    <td>
                                        <a href="{{ route('admin.events.show', $event) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
