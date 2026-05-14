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
                    <th>Number</th>
                    <th>Remarks</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($crms as $crm)
                <tr>
                    <td>{{ $crm->phone }}</td>
                    <td>{{ $crm->remarks }}</td>
                    <td>{{ $crm->created_at->format('d M Y') }}</td>
                    <td>{{ $crm->created_at->format('h:i A') }}</td>
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
            order: [[2, 'desc']]
        });
    });
</script>
@endpush
