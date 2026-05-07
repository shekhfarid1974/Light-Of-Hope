@extends('layouts.app')

@section('page-title', 'CRM Records')

@section('content')

    <div class="card-box">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0"><i class="bi bi-table"></i> CRM Records</h6>
            <a href="{{ route('crm.form') }}?phone_number=&agent={{ urlencode(auth()->user()->name) }}&campaign="
                target="_blank" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Add New
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table id="crmTable" class="table table-hover table-bordered align-middle" style="width:100%">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Parent Name</th>
                        <th>Phone</th>
                        <th>District</th>
                        <th>Child</th>
                        <th>Class</th>
                        <th>Interested For</th>
                        <th>Calling Status</th>
                        <th>Query Source</th>
                        <th>Query Status</th>
                        <th>Assigned Person</th>
                        <th>Data Source</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($crms as $i => $crm)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>
                                <strong>{{ $crm->parents_name }}</strong>
                                @if($crm->email)
                                    <br><small class="text-muted">{{ $crm->email }}</small>
                                @endif
                            </td>
                            <td>{{ $crm->phone }}</td>
                            <td>{{ $crm->district->name ?? '—' }}</td>
                            <td>
                                @if($crm->child_name)
                                    {{ $crm->child_name }}
                                    @if($crm->child_age)
                                        <span class="badge bg-secondary">{{ $crm->child_age }}</span>
                                    @endif
                                @else
                                    —
                                @endif
                            </td>
                            <td>{{ $crm->class ?? '—' }}</td>
                            <td>
                                @if($crm->interested_for)
                                    <span class="badge bg-primary">{{ $crm->interested_for }}</span>
                                @else —
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusColor = [
                                        'Enrolled' => 'success',
                                        'Trial Class' => 'info',
                                        'Pending' => 'warning',
                                        'Cancel' => 'danger',
                                        'No Interaction' => 'secondary',
                                        'No Communication' => 'dark',
                                    ][$crm->calling_status] ?? 'secondary';
                                @endphp
                                @if($crm->calling_status)
                                    <span class="badge bg-{{ $statusColor }}">{{ $crm->calling_status }}</span>
                                @else —
                                @endif
                            </td>
                            <td>
                                @if($crm->query_source)
                                    <span class="badge bg-info text-dark">{{ $crm->query_source }}</span>
                                @else —
                                @endif
                            </td>
                            <td>
                                @php
                                    $qColor = ['Done' => 'success', 'Pending' => 'warning', 'Cancel' => 'danger', 'No Interaction' => 'secondary'][$crm->query_status] ?? 'secondary';
                                @endphp
                                @if($crm->query_status)
                                    <span class="badge bg-{{ $qColor }}">{{ $crm->query_status }}</span>
                                @else —
                                @endif
                            </td>
                            <td>{{ $crm->agent->name ?? '—' }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $crm->dataSource->name ?? '—' }}</span></td>
                            <td>{{ $crm->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(function () {
            $('#crmTable').DataTable({
                order: [[12, 'desc']],
                pageLength: 25,
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'csvHtml5', text: '<i class="bi bi-filetype-csv"></i> CSV', className: 'btn btn-sm btn-success me-1' },
                    { extend: 'excelHtml5', text: '<i class="bi bi-file-earmark-excel"></i> Excel', className: 'btn btn-sm btn-success me-1' },
                    { extend: 'print', text: '<i class="bi bi-printer"></i> Print', className: 'btn btn-sm btn-secondary' }
                ]
            });
        });
    </script>
@endpush