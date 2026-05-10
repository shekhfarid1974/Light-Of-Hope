<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FAQ;
use App\Models\DataSource;
use App\Services\CrmService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $crmService;

    public function __construct(CrmService $crmService)
    {
        $this->crmService = $crmService;
    }

    public function index()
    {
        $totalCrms = $this->crmService->getTotalCrms();
        $totalFaqs = FAQ::count();
        $totalDataSources = DataSource::count();
        
        $crms = $this->crmService->getDashboardCrms();

        return view('admin.dashboard', compact('totalCrms', 'totalFaqs', 'totalDataSources', 'crms'));
    }
}
