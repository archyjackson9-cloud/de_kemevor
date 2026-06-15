@extends('layouts.admin')
@section('title', 'E-Consultations')
@section('page-title', 'E-Consultations')

@section('content')

<div class="admin-card">
    <div class="admin-card__header">
        <h3><i class="fas fa-stethoscope"></i> Consultation Requests ({{ $consultations->count() }})</h3>
        <span style="font-size:13px;color:#888">Submitted via the public E-Consultation form.</span>
    </div>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Client</th>
                    <th>Concern Area</th>
                    <th>Images</th>
                    <th>Submitted</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($consultations as $c)
                <tr>
                    <td><strong>{{ $c->reference_number }}</strong></td>
                    <td>
                        {{ $c->name }}
                        <div class="admin-table__sub">{{ $c->email }}</div>
                    </td>
                    <td>{{ $c->concern_area_label }}</td>
                    <td>{{ $c->images_count }}</td>
                    <td>{{ $c->created_at->format('M j, Y') }}</td>
                    <td>{!! $c->status_badge !!}</td>
                    <td class="admin-table__actions">
                        <a href="{{ route('admin.consultations.show', $c) }}" class="btn btn-xs btn-outline">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.consultations.destroy', $c) }}" style="display:inline"
                              onsubmit="return confirm('Remove this consultation request from {{ addslashes($c->name) }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-red"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if($consultations->isEmpty())
                <tr><td colspan="7"><div class="admin-empty"><i class="fas fa-stethoscope"></i> No e-consultation requests yet.</div></td></tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection
