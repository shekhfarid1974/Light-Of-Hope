@extends('layouts.app')

@section('page-title', 'CRM Records')

@section('content')

    <div class="card-box">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0"><i class="bi bi-table"></i> Teachers Training CRM Records</h6>
            <a href="{{ route('crm.form', ['type' => $type]) }}?phone_number=&agent={{ urlencode(auth()->user()->name) }}&campaign="
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
                        <th>Trainee Name</th>
                        <th>Phone</th>
                        <th>District</th>
                        <th>Age</th>
                        <th>Experience</th>
                        <th>Course Title</th>
                        <th>Query Status</th>
                        <th>Assigned Person</th>
                        <th>Agent</th>
                        <th>Data Source</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($crms as $i => $crm)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>
                                <strong>{{ $crm->trainee_name }}</strong>
                                @if($crm->email)
                                    <br><small class="text-muted">{{ $crm->email }}</small>
                                @endif
                            </td>
                            <td>{{ $crm->phone }}</td>
                            <td>{{ $crm->district->name ?? '—' }}</td>
                            <td>{{ $crm->trainee_age ?? '—' }}</td>
                            <td>{{ $crm->experience ?? '—' }}</td>
                            <td>
                                @if($crm->course_title)
                                    <span class="badge bg-primary">{{ $crm->course_title }}</span>
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
                            <td>{{ $crm->assigned_person ?? '—' }}</td>
                            <td>{{ $crm->agent ?? '—' }}</td>
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