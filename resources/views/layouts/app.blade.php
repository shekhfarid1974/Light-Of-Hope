<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- DataTables Buttons -->
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: #0f172a;
            padding: 20px;
            overflow-y: auto;
        }

        .sidebar h3 {
            color: #fff;
            margin-bottom: 25px;
        }

        .sidebar a {
            display: block;
            color: #cbd5e1;
            padding: 10px 12px;
            border-radius: 8px;
            text-decoration: none;
            margin-bottom: 4px;
            transition: background .15s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #1e293b;
            color: #fff;
        }

        .sidebar .nav-section {
            color: #475569;
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            padding: 10px 12px 4px;
            margin-top: 6px;
        }

        /* MAIN */
        .main {
            margin-left: 260px;
            padding: 20px;
        }

        /* TOPBAR */
        .topbar {
            background: #fff;
            padding: 12px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
        }

        .agent-badge {
            background: #f1f5f9;
            border-radius: 20px;
            padding: 6px 14px;
            font-size: .85rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* CARDS */
        .card-box {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
        }

        .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.4rem;
        }

        .bg-purple {
            background: #7c3aed;
        }

        .bg-blue {
            background: #2563eb;
        }

        .bg-green {
            background: #16a34a;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h3>Light of Hope</h3>

        <div class="nav-section">Main</div>
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>

        <div class="nav-section">Kids CRM</div>
        <a href="{{ route('crm.kids_crm.form') }}?phone_number=&agent=" target="_blank"
            class="{{ request()->routeIs('crm.kids_crm.form') ? 'active' : '' }}">
            <i class="bi bi-plus-circle me-2"></i> Kids Form
            <i class="bi bi-box-arrow-up-right ms-1" style="font-size:.7rem;opacity:.6;"></i>
        </a>
        <a href="{{ route('crm.kids_crm.index') }}"
            class="{{ request()->routeIs('crm.kids_crm.index') ? 'active' : '' }}">
            <i class="bi bi-table me-2"></i> Kids Report
        </a>

        <div class="nav-section">Teachers CRM</div>
        <a href="{{ route('crm.teachers_crm.form') }}?phone_number=&agent=" target="_blank"
            class="{{ request()->routeIs('crm.teachers_crm.form') ? 'active' : '' }}">
            <i class="bi bi-plus-circle me-2"></i> Teachers Form
            <i class="bi bi-box-arrow-up-right ms-1" style="font-size:.7rem;opacity:.6;"></i>
        </a>
        <a href="{{ route('crm.teachers_crm.index') }}"
            class="{{ request()->routeIs('crm.teachers_crm.index') ? 'active' : '' }}">
            <i class="bi bi-table me-2"></i> Teachers Report
        </a>

        <div class="nav-section">Combined Report</div>
        <a href="{{ route('crm.callback.report') }}"
            class="{{ request()->routeIs('crm.callback.report') ? 'active' : '' }}">
            <i class="bi bi-telephone-inbound me-2"></i> Call Back Report
        </a>

        <div class="nav-section">Settings</div>
        <a href="{{ route('data-sources.index') }}" class="{{ request()->routeIs('data-sources.*') ? 'active' : '' }}">
            <i class="bi bi-database me-2"></i> Data Sources
        </a>
        <a href="{{ route('districts.index') }}" class="{{ request()->routeIs('districts.*') ? 'active' : '' }}">
            <i class="bi bi-geo-alt me-2"></i> Districts
        </a>
        <a href="{{ route('faqs.index') }}" class="{{ request()->routeIs('faqs.*') ? 'active' : '' }}">
            <i class="bi bi-question-circle me-2"></i> FAQs
        </a>
        <a href="{{ route('crm-options.index') }}" class="{{ request()->routeIs('crm-options.*') ? 'active' : '' }}">
            <i class="bi bi-ui-radios me-2"></i> CRM Options
        </a>

        <hr style="border-color:#334155; margin-top:16px;">
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>

    <!-- MAIN -->
    <div class="main">

        <!-- TOPBAR -->
        <div class="topbar">
            <h5 class="mb-0 fw-semibold">
                @yield('page-title', 'Dashboard')
            </h5>
            <div class="d-flex align-items-center gap-3">
                <div class="agent-badge">
                    <i class="bi bi-person-circle text-primary"></i>
                    <strong>{{ auth()->user()->name }}</strong>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- CONTENT -->
        @yield('content')

    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Buttons + Export -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    @stack('scripts')
</body>

</html>