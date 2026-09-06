@extends('layouts.admin')
@section('title', 'Training Inquiries')
@section('page-title', 'Training Inquiries')

@section('content')

<div class="admin-card">
    <div class="admin-card__header">
        <h3><i class="fas fa-graduation-cap"></i> Enrollment Inquiries ({{ $inquiries->count() }})</h3>
        <span style="font-size:13px;color:#888">Submitted via the public Training page.</span>
    </div>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Applicant</th>
                    <th>Interested Phase</th>
                    <th>Submitted</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inquiries as $i)
                <tr>
                    <td><strong>{{ $i->reference_number }}</strong></td>
                    <td>
                        {{ $i->name }}
                        <div class="admin-table__sub">{{ $i->email }}</div>
                    </td>
                    <td>{{ $i->phase_interest ?: '—' }}</td>
                    <td>{{ $i->created_at->format('M j, Y') }}</td>
                    <td>{!! $i->status_badge !!}</td>
                    <td class="admin-table__actions">
                        <a href="{{ route('admin.training-inquiries.show', $i) }}" class="btn btn-xs btn-outline">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.training-inquiries.destroy', $i) }}" style="display:inline"
                              onsubmit="return confirm('Remove this inquiry from {{ addslashes($i->name) }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-red"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if($inquiries->isEmpty())
                <tr><td colspan="6"><div class="admin-empty"><i class="fas fa-graduation-cap"></i> No training inquiries yet.</div></td></tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection
