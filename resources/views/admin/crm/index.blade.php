@extends('layouts.app')

@section('content')

    <div class="card-box">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0"><i class="bi bi-table"></i> CRM Records</h6>
            <a href="{{ route('crm.form') }}" class="btn btn-primary btn-sm">
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
                        <th>Email</th>
                        <th>District</th>
                        <th>Child</th>
                        <th>Class</th>
                        <th>Interested For</th>
                        <th>Data Source</th>
                        <th>Assigned To</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($crms as $i => $crm)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $crm->parents_name }}</td>
                            <td>{{ $crm->phone }}</td>
                            <td>{{ $crm->email ?? '—' }}</td>
                            <td>{{ $crm->district->name ?? '—' }}</td>
                            <td>
                                @if($crm->child_name)
                                    {{ $crm->child_name }}
                                    <span class="badge bg-secondary">{{ $crm->child_age }}</span>
                                    <span class="badge {{ $crm->child_gender == 'Male' ? 'bg-primary' : 'bg-danger' }}">
                                        {{ $crm->child_gender }}
                                    </span>
                                @else
                                    —
                                @endif
                            </td>
                            <td>{{ $crm->class ?? '—' }}</td>
                            <td>{{ $crm->interested_for ?? '—' }}</td>
                            <td>
                                <span class="badge bg-info text-dark">{{ $crm->dataSource->name ?? '—' }}</span>
                            </td>
                            <td>{{ $crm->assigned_person ?? '—' }}</td>
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
                order: [[10, 'desc']],
                pageLength: 25,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'csvHtml5',
                        text: '<i class="bi bi-filetype-csv"></i> Export CSV',
                        className: 'btn btn-sm btn-success me-1'
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="bi bi-file-earmark-excel"></i> Export Excel',
                        className: 'btn btn-sm btn-success me-1'
                    },
                    {
                        extend: 'print',
                        text: '<i class="bi bi-printer"></i> Print',
                        className: 'btn btn-sm btn-secondary'
                    }
                ],
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ records"
                }
            });
        });
    </script>
@endpush