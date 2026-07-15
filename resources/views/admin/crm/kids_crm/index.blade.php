@extends('layouts.app')

@section('page-title', 'CRM Records')

@section('content')

    <div class="card-box">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0"><i class="bi bi-table"></i> Kids CRM Records</h6>
            <a href="{{ route('crm.kids_crm.form') }}?phone_number=&agent={{ urlencode(auth()->user()->name) }}&campaign="
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

        <div class="row mb-3">
            <div class="col-md-3"><input type="text" id="filterPhone" class="form-control" placeholder="Filter by Phone">
            </div>
            <div class="col-md-3"><input type="text" id="filterQuerySource" class="form-control"
                    placeholder="Filter by Query Source"></div>
            <div class="col-md-3"><input type="text" id="filterAssignedPerson" class="form-control"
                    placeholder="Filter by Assigned Person"></div>
            <div class="col-md-3"><input type="date" id="filterDateFrom" class="form-control" placeholder="From Date"></div>
            <div class="col-md-3"><input type="date" id="filterDateTo" class="form-control" placeholder="To Date"></div>
        </div>
        <div class="table-responsive">
            <table id="crmTable" class="table table-hover table-bordered align-middle" style="width:100%">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Parent Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Profession</th>
                        <th>District</th>
                        <th>Child Name</th>
                        <th>Child Age</th>
                        <th>Child Gender</th>
                        <th>Class</th>
                        <th>Interested For</th>
                        <th>Calling Status</th>
                        <th>Query Source</th>
                        <th>Query Status</th>
                        <th>Call Back</th>
                        <th>Assigned Person</th>
                        <th>Remarks</th>
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
                                <strong>{{ $crm->parents_name }}</strong>
                            </td>
                            <td>{{ $crm->phone }}</td>
                            <td>{{ $crm->email ?? '—' }}</td>
                            <td>{{ $crm->profession ?? '—' }}</td>
                            <td>{{ $crm->district->name ?? '—' }}</td>
                            <td>{{ $crm->child_name ?? '—' }}</td>
                            <td>{{ $crm->child_age ?? '—' }}</td>
                            <td>{{ $crm->child_gender ?? '—' }}</td>
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
                            <td>{{ $crm->call_back ?? '—' }}</td>
                            <td>{{ $crm->assigned_person ?? '—' }}</td>
                            <td>{{ $crm->remarks ?? '—' }}</td>
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
            var table = $('#crmTable').DataTable({
                order: [[19, 'desc']],
                pageLength: 25,
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'csvHtml5', text: '<i class="bi bi-filetype-csv"></i> CSV', className: 'btn btn-sm btn-success me-1' },
                    { extend: 'excelHtml5', text: '<i class="bi bi-file-earmark-excel"></i> Excel', className: 'btn btn-sm btn-success me-1' },
                    { extend: 'print', text: '<i class="bi bi-printer"></i> Print', className: 'btn btn-sm btn-secondary' }
                ]
            });
            // Filters
            $('#filterPhone').on('keyup change', function () { table.column(2).search(this.value).draw(); });
            $('#filterQuerySource').on('keyup change', function () { table.column(12).search(this.value).draw(); });
            $('#filterAssignedPerson').on('keyup change', function () { table.column(15).search(this.value).draw(); });

            // Date range filter
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var min = $('#filterDateFrom').val();
                    var max = $('#filterDateTo').val();
                    var dateStr = data[19]; // Expected format 'd M Y'
                    if (dateStr) {
                        var parts = dateStr.split(' ');
                        var parsed = new Date(parts[2] + '-' + (new Date(Date.parse(parts[1] + " 1, 2020")).getMonth() + 1).toString().padStart(2, '0') + '-' + parts[0].padStart(2, '0'));
                        if (min && parsed < new Date(min)) { return false; }
                        if (max && parsed > new Date(max)) { return false; }
                    }
                    return true;
                }
            );
            $('#filterDateFrom, #filterDateTo').on('change', function () { table.draw(); });
        });
    </script>
@endpush