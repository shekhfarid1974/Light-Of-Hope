@extends('layouts.app')

@section('page-title', 'Call Back Report')

@section('content')
    <div class="card-box">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">Call Back List</h5>
        </div>

        <div class="row mb-3">
            <div class="col-md-3"><input type="text" id="filterPhone" class="form-control" placeholder="Filter by Phone">
            </div>
            <div class="col-md-3"><input type="text" id="filterSource" class="form-control" placeholder="Filter by Source">
            </div>
            <div class="col-md-3"><input type="date" id="filterDateFrom" class="form-control" placeholder="From Date"></div>
            <div class="col-md-3"><input type="date" id="filterDateTo" class="form-control" placeholder="To Date"></div>
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
                            $crmTypeFormatted = match ($crmType) {
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
        $(document).ready(function () {
            var table = $('#callbackTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                order: [[5, 'desc']]
            });
            // Filters
            $('#filterPhone').on('keyup change', function () { table.column(2).search(this.value).draw(); });
            $('#filterSource').on('keyup change', function () { table.column(0).search(this.value).draw(); });
            // Date range filter
            $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                var min = $('#filterDateFrom').val();
                var max = $('#filterDateTo').val();
                var dateStr = data[5]; // Expected format 'd M Y'
                if (dateStr && dateStr !== '—') {
                    var dateParts = dateStr.split(' ');
                    var months = { Jan: 0, Feb: 1, Mar: 2, Apr: 3, May: 4, Jun: 5, Jul: 6, Aug: 7, Sep: 8, Oct: 9, Nov: 10, Dec: 11 };
                    var parsed = new Date(dateParts[2], months[dateParts[1]], dateParts[0]);
                    if (min && parsed < new Date(min)) return false;
                    if (max && parsed > new Date(max)) return false;
                }
                return true;
            });
            $('#filterDateFrom, #filterDateTo').on('change', function () { table.draw(); });
        });
    </script>
@endpush