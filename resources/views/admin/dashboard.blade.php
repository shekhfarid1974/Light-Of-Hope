@extends('layouts.app')

@section('content')

    <div class="row g-4 mb-4">

        <div class="col-md-4">
            <div class="card-box d-flex align-items-center gap-3">
                <div class="icon-box bg-blue fs-4">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <div class="text-muted small">Total CRM Records</div>
                    <div class="fw-bold fs-4">{{ \App\Models\CRM::count() }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-box d-flex align-items-center gap-3">
                <div class="icon-box bg-purple fs-4">
                    <i class="bi bi-file-earmark-pdf-fill"></i>
                </div>
                <div>
                    <div class="text-muted small">Total FAQs</div>
                    <div class="fw-bold fs-4">{{ \App\Models\FAQ::count() }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-box d-flex align-items-center gap-3">
                <div class="icon-box bg-green fs-4">
                    <i class="bi bi-database-fill"></i>
                </div>
                <div>
                    <div class="text-muted small">Data Sources</div>
                    <div class="fw-bold fs-4">{{ \App\Models\DataSource::count() }}</div>
                </div>
            </div>
        </div>

    </div>

    <div class="card-box">
        <h6 class="fw-bold mb-3">Recent CRM Entries</h6>
        <table class="table table-hover" id="recentTable">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Parent Name</th>
                    <th>Phone</th>
                    <th>District</th>
                    <th>Data Source</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Models\CRM::with(['district', 'dataSource'])->latest()->take(10)->get() as $i => $crm)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $crm->parents_name }}</td>
                        <td>{{ $crm->phone }}</td>
                        <td>{{ $crm->district->name ?? '—' }}</td>
                        <td>{{ $crm->dataSource->name ?? '—' }}</td>
                        <td>{{ $crm->created_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection

@push('scripts')
    <script>
        $('#recentTable').DataTable({ pageLength: 10, order: [] });
    </script>
@endpush