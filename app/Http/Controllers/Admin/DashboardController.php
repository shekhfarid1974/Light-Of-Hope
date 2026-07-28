<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FAQ;
use App\Models\DataSource;
use App\Models\KidsCrm;
use App\Models\TeachersCrm;
use App\Models\CallBack;
use App\Services\CrmService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    protected $crmService;

    public function __construct(CrmService $crmService)
    {
        $this->crmService = $crmService;
    }

    public function index()
    {
        // 1. Executive Summary Cards
        $totalKids = KidsCrm::count();
        $totalTeachers = TeachersCrm::count();
        $totalCallBacks = CallBack::count();
        $totalCrms = $totalKids + $totalTeachers;

        // Conversion / Enrolled counts
        $enrolledKids = KidsCrm::where('calling_status', 'Enrolled')->count();
        $enrolledTeachers = TeachersCrm::where('calling_status', 'Enrolled')->count();
        $totalEnrolled = $enrolledKids + $enrolledTeachers;
        $conversionRate = $totalCrms > 0 ? round(($totalEnrolled / $totalCrms) * 100, 1) : 0;

        // 2. Chart A: 6-Month Lead Acquisition Trend (Kids vs Teachers)
        $months = [];
        $kidsMonthly = [];
        $teachersMonthly = [];

        for ($i = 5; $i >= 0; $i--) {
            $monthDate = Carbon::now()->subMonths($i);
            $monthLabel = $monthDate->format('M Y');
            $months[] = $monthLabel;

            $kidsMonthly[] = KidsCrm::whereYear('created_at', $monthDate->year)
                ->whereMonth('created_at', $monthDate->month)
                ->count();

            $teachersMonthly[] = TeachersCrm::whereYear('created_at', $monthDate->year)
                ->whereMonth('created_at', $monthDate->month)
                ->count();
        }

        // 3. Chart B: Calling Status Pipeline Breakdown
        $allStatuses = ['Enrolled', 'Trial Class', 'Pending', 'Cancel', 'No Interaction', 'No Communication'];
        $kidsStatusData = KidsCrm::select('calling_status', DB::raw('count(*) as total'))
            ->groupBy('calling_status')
            ->pluck('total', 'calling_status');

        $teachersStatusData = TeachersCrm::select('calling_status', DB::raw('count(*) as total'))
            ->groupBy('calling_status')
            ->pluck('total', 'calling_status');

        $kidsStatusCounts = [];
        $teachersStatusCounts = [];
        foreach ($allStatuses as $status) {
            $kidsStatusCounts[] = $kidsStatusData->get($status, 0);
            $teachersStatusCounts[] = $teachersStatusData->get($status, 0);
        }

        // 4. Chart C: Data Sources Distribution (Combined)
        $kidsDataSources = KidsCrm::select('data_source_id', DB::raw('count(*) as count'))
            ->groupBy('data_source_id')
            ->pluck('count', 'data_source_id');

        $dataSources = DataSource::pluck('name', 'id');
        $dataSourceLabels = [];
        $dataSourceCounts = [];

        foreach ($dataSources as $id => $name) {
            $kidsCount = KidsCrm::where('data_source_id', $id)->count();
            $teacherCount = TeachersCrm::where('data_source_id', $id)->count();
            $sum = $kidsCount + $teacherCount;
            if ($sum > 0) {
                $dataSourceLabels[] = $name;
                $dataSourceCounts[] = $sum;
            }
        }

        // 5. Chart D: Top 5 Districts
        $topDistrictsKids = KidsCrm::select('district_id', DB::raw('count(*) as total'))
            ->whereNotNull('district_id')
            ->groupBy('district_id')
            ->with('district')
            ->get();

        $districtTotals = [];
        foreach ($topDistrictsKids as $item) {
            $name = $item->district->name ?? 'Unknown';
            $districtTotals[$name] = ($districtTotals[$name] ?? 0) + $item->total;
        }
        arsort($districtTotals);
        $topDistricts = array_slice($districtTotals, 0, 5, true);

        // Recent Entries
        $crms = $this->crmService->getDashboardCrms();

        return view('admin.dashboard', compact(
            'totalCrms',
            'totalKids',
            'totalTeachers',
            'totalCallBacks',
            'totalEnrolled',
            'conversionRate',
            'months',
            'kidsMonthly',
            'teachersMonthly',
            'allStatuses',
            'kidsStatusCounts',
            'teachersStatusCounts',
            'dataSourceLabels',
            'dataSourceCounts',
            'topDistricts',
            'crms'
        ));
    }
}