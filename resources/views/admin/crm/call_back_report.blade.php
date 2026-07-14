@extends('layouts.app')

@section('page-title', 'Call Back Report')

@section('content')
<div class="card-box">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">Call Back List</h5>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle" id="callbackTable">
            <thead class="table-light">
                <tr>
                    <th>Source (CRM)</th>
                    <th>Name</th>
                    <th>Number</th>
                    <th>Remarks / Query</th>
                    <th>Call Back Status</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($callBacks as $cb)
                @php
                    $crmType = $cb->crm_type;
                    $crmTypeFormatted = match($crmType) {
                        \App\Models\TeachersCrm::class => 'Teachers CRM',
                        \App\Models\KidsCrm::class => 'Kids CRM',
                        default => 'Unknown',
                    };
                @endphp
                <tr>
                    <td><span class="badge bg-secondary">{{ $crmTypeFormatted }}</span></td>
                    <td>{{ $cb->name }}</td>
                    <td>{{ $cb->crm->phone ?? '—' }}</td>
                    <td>{{ $cb->remarks }}</td>
                    <td>
                        @if($cb->crm && $cb->crm->call_back)
                            <span class="badge bg-info text-dark">{{ $cb->crm->call_back }}</span>
                        @else
                            —
                        @endif
                    </td>
                    <td>{{ $cb->date ? \Carbon\Carbon::parse($cb->date)->format('d M Y') : '—' }}</td>
                    <td>{{ $cb->time ? \Carbon\Carbon::parse($cb->time)->format('h:i A') : '—' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#callbackTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            order: [[3, 'desc']]
        });
    });
</script>
@endpush
