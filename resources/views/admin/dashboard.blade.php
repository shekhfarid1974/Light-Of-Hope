@extends('layouts.app')

@section('content')

<style>
    .kpi-card {
        border: none;
        border-radius: 12px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08) !important;
    }
    .kpi-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .chart-card {
        border: none;
        border-radius: 12px;
        background: #ffffff;
    }
</style>

<div class="container-fluid px-0">

    <!-- Header Banner -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">CRM Analytics & Control Panel</h4>
            <p class="text-muted small mb-0">Real-time performance metrics for Kids and Teachers CRM</p>
        </div>
        <div>
            <button class="btn btn-sm btn-outline-primary shadow-sm me-2" onclick="window.location.reload();">
                <i class="bi bi-arrow-clockwise"></i> Refresh Data
            </button>
        </div>
    </div>

    <!-- Executive KPI Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card kpi-card shadow-sm p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Total Leads</div>
                        <h3 class="fw-bold my-1 text-dark">{{ number_format($totalCrms) }}</h3>
                        <span class="badge bg-light-primary text-primary border me-1">
                            Kids: {{ $totalKids }}
                        </span>
                        <span class="badge bg-light-info text-info border">
                            Teachers: {{ $totalTeachers }}
                        </span>
                    </div>
                    <div class="kpi-icon bg-primary text-white fs-4">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card kpi-card shadow-sm p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Total Enrolled</div>
                        <h3 class="fw-bold my-1 text-success">{{ number_format($totalEnrolled) }}</h3>
                        <span class="text-muted small">
                            <i class="bi bi-graph-up-arrow text-success"></i> {{ $conversionRate }}% Conversion Rate
                        </span>
                    </div>
                    <div class="kpi-icon bg-success text-white fs-4">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card kpi-card shadow-sm p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Call Back Requests</div>
                        <h3 class="fw-bold my-1 text-warning">{{ number_format($totalCallBacks) }}</h3>
                        <span class="text-muted small">Action Required</span>
                    </div>
                    <div class="kpi-icon bg-warning text-dark fs-4">
                        <i class="bi bi-telephone-outbound-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card kpi-card shadow-sm p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Active Data Sources</div>
                        <h3 class="fw-bold my-1 text-info">{{ count($dataSourceLabels) }}</h3>
                        <span class="text-muted small">Marketing Channels</span>
                    </div>
                    <div class="kpi-icon bg-info text-white fs-4">
                        <i class="bi bi-diagram-3-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 1: Lead Trend + Status Funnel -->
    <div class="row g-3 mb-4">
        <!-- Monthly Growth Line Chart -->
        <div class="col-lg-7">
            <div class="card chart-card shadow-sm p-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-graph-up text-primary me-2"></i>Lead Acquisition Trend (Last 6 Months)</h6>
                </div>
                <div style="height: 280px; position: relative;">
                    <canvas id="acquisitionTrendChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Calling Status Breakdown -->
        <div class="col-lg-5">
            <div class="card chart-card shadow-sm p-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-funnel-fill text-purple me-2" style="color: #6f42c1;"></i>Calling Status Funnel</h6>
                </div>
                <div style="height: 280px; position: relative;">
                    <canvas id="statusFunnelChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 2: Data Sources + Regional Distribution -->
    <div class="row g-3 mb-4">
        <!-- Data Sources Donut -->
        <div class="col-lg-5">
            <div class="card chart-card shadow-sm p-3 h-100">
                <h6 class="fw-bold mb-3"><i class="bi bi-pie-chart-fill text-success me-2"></i>Lead Sources Distribution</h6>
                <div style="height: 250px; position: relative;" class="d-flex align-items-center justify-content-center">
                    <canvas id="dataSourceChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Districts Bar Chart -->
        <div class="col-lg-7">
            <div class="card chart-card shadow-sm p-3 h-100">
                <h6 class="fw-bold mb-3"><i class="bi bi-geo-alt-fill text-danger me-2"></i>Top Districts Volume</h6>
                <div style="height: 250px; position: relative;">
                    <canvas id="districtChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Records Table -->
    <div class="card chart-card shadow-sm p-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0"><i class="bi bi-clock-history me-2"></i>Recent CRM Entries</h6>
            <a href="{{ route('crm.kids_crm.index') }}" class="btn btn-sm btn-light border">View All Kids CRM</a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle text-nowrap" id="recentTable">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Parent / Trainee Name</th>
                        <th>Phone</th>
                        <th>District</th>
                        <th>Data Source</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($crms->take(10) as $i => $crm)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td><strong>{{ $crm->parents_name ?? $crm->customer_name ?? $crm->father_name ?? '—' }}</strong></td>
                            <td>{{ $crm->phone ?? $crm->father_phone ?? '—' }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $crm->district->name ?? '—' }}</span></td>
                            <td><span class="badge bg-info text-dark">{{ $crm->dataSource->name ?? '—' }}</span></td>
                            <td>{{ optional($crm->created_at)->format('d M Y') ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(document).ready(function () {

    // 1. Lead Acquisition Trend (Smooth Line Chart)
    var ctxTrend = document.getElementById('acquisitionTrendChart').getContext('2d');
    new Chart(ctxTrend, {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [
                {
                    label: 'Kids CRM',
                    data: @json($kidsMonthly),
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.08)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 4
                },
                {
                    label: 'Teachers CRM',
                    data: @json($teachersMonthly),
                    borderColor: '#20c997',
                    backgroundColor: 'rgba(32, 201, 151, 0.08)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [4, 4] } },
                x: { grid: { display: false } }
            }
        }
    });

    // 2. Calling Status Funnel (Stacked/Grouped Bar Chart)
    var ctxFunnel = document.getElementById('statusFunnelChart').getContext('2d');
    new Chart(ctxFunnel, {
        type: 'bar',
        data: {
            labels: @json($allStatuses),
            datasets: [
                {
                    label: 'Kids CRM',
                    data: @json($kidsStatusCounts),
                    backgroundColor: '#0d6efd',
                    borderRadius: 6
                },
                {
                    label: 'Teachers CRM',
                    data: @json($teachersStatusCounts),
                    backgroundColor: '#6f42c1',
                    borderRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                x: { grid: { display: false } },
                y: { beginAtZero: true, grid: { borderDash: [4, 4] } }
            }
        }
    });

    // 3. Lead Sources (Doughnut Chart with Custom Colors)
    var ctxSource = document.getElementById('dataSourceChart').getContext('2d');
    new Chart(ctxSource, {
        type: 'doughnut',
        data: {
            labels: @json($dataSourceLabels),
            datasets: [{
                data: @json($dataSourceCounts),
                backgroundColor: ['#0d6efd', '#20c997', '#ffc107', '#dc3545', '#6f42c1', '#17a2b8', '#fd7e14'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'right' }
            },
            cutout: '65%'
        }
    });

    // 4. Top Districts (Horizontal Bar Chart)
    var topDistrictsData = @json($topDistricts);
    var ctxDistrict = document.getElementById('districtChart').getContext('2d');
    new Chart(ctxDistrict, {
        type: 'bar',
        data: {
            labels: Object.keys(topDistrictsData),
            datasets: [{
                label: 'Lead Volume',
                data: Object.values(topDistrictsData),
                backgroundColor: '#17a2b8',
                borderRadius: 6
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { beginAtZero: true, grid: { borderDash: [4, 4] } },
                y: { grid: { display: false } }
            }
        }
    });

    $('#recentTable').DataTable({ pageLength: 5, searching: false, lengthChange: false, order: [] });
});
</script>
@endpush