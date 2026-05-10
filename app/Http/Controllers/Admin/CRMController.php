<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\DataSource;
use App\Models\CrmOption;
use App\Services\CrmService;
use Illuminate\Http\Request;

class CRMController extends Controller
{
    protected $crmService;

    public function __construct(CrmService $crmService)
    {
        $this->crmService = $crmService;
    }

    public function create()
    {
        $districts   = District::orderBy('name')->get();
        $dataSources = DataSource::orderBy('name')->get();
        
        $options = CrmOption::all()->groupBy('type');
        $interestedForOptions = $options->get('interested_for', collect());
        $callingStatusOptions = $options->get('calling_status', collect());
        $querySourceOptions = $options->get('query_source', collect());
        $queryStatusOptions = $options->get('query_status', collect());
        $assignedPersonOptions = $options->get('assigned_person', collect());

        return view('admin.crm.form', compact(
            'districts', 
            'dataSources', 
            'interestedForOptions', 
            'callingStatusOptions', 
            'querySourceOptions', 
            'queryStatusOptions',
            'assignedPersonOptions'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'parents_name'   => 'required|string|max:255',
            'phone'          => 'required|string|max:20',
            'email'          => 'nullable|email|max:255',
            'data_source_id' => 'required|exists:data_sources,id',
            'district_id'    => 'nullable|exists:districts,id',
        ]);

        $this->crmService->createCrm($request->only([
            'parents_name',
            'phone',
            'email',
            'profession',
            'district_id',
            'child_gender',
            'child_age',
            'child_name',
            'class',
            'interested_for',
            'assigned_person',
            'remarks',
            'agent',
            'calling_status',
            'query_source',
            'query_status',
            'data_source_id',
        ]));

        return redirect()->route('crm.form')
            ->with('success', 'CRM record saved successfully.');
    }

    public function index()
    {
        $crms = $this->crmService->getAllCrms();

        return view('admin.crm.index', compact('crms'));
    }

    public function history(Request $request)
    {
        if (!$request->has('phone')) {
            return response()->json([]);
        }

        return response()->json($this->crmService->getHistoryForAjax($request->phone));
    }
}