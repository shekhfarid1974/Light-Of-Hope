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
                    <th>Calling Status</th>
                    <th>Query Status</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($callBacks as $cb)
                @php
                    $crmType = $cb->crm_type;
                    $crmTypeFormatted = match($crmType) {
                        \App\Models\TeachersTrainingCrm::class => 'Teachers Training',
                        \App\Models\InboundCrm::class => 'Inbound',
                        \App\Models\CourseOutboundCrm::class => 'Course Outbound',
                        default => 'Unknown',
                    };
                @endphp
                <tr>
                    <td><span class="badge bg-secondary">{{ $crmTypeFormatted }}</span></td>
                    <td>{{ $cb->name }}</td>
                    <td>{{ $cb->crm->phone ?? '—' }}</td>
                    <td>{{ $cb->remarks }}</td>
                    <td>
                        @if($cb->crm && $cb->crm->calling_status)
                            @php
                                $statusColor = [
                                    'Enrolled' => 'success',
                                    'Trial Class' => 'info',
                                    'Pending' => 'warning',
                                    'Cancel' => 'danger',
                                    'No Interaction' => 'secondary',
                                    'No Communication' => 'dark'
                                ][$cb->crm->calling_status] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $statusColor }}">{{ $cb->crm->calling_status }}</span>
                        @else
                            —
                        @endif
                    </td>
                    <td>
                        @if($cb->crm && $cb->crm->query_status)
                            @php
                                $qColor = [
                                    'Done' => 'success',
                                    'Pending' => 'warning',
                                    'Cancel' => 'danger',
                                    'No Interaction' => 'secondary'
                                ][$cb->crm->query_status] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $qColor }}">{{ $cb->crm->query_status }}</span>
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
