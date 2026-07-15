<?php

namespace App\Http\Controllers\Admin\Crm;

use App\Http\Controllers\Controller;
use App\Http\Requests\Crm\KidsCrmRequest;
use App\Models\District;
use App\Models\DataSource;
use App\Models\CrmOption;
use App\Services\CrmService;
use Illuminate\Http\Request;

class KidsCrmController extends Controller
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
        
        $options = CrmOption::where('crm_type', 'kids_crm')->get()->groupBy('type');
        
        $interestForOptions = $options->get('interest_for', collect());
        $childGenderOptions = $options->get('child_gender', collect());
        
        $callingAgentOptions = $options->get('calling_agent', collect());
        $callingPurposeOptions = $options->get('calling_purpose', collect());
        $callingStatusOptions = $options->get('calling_status', collect());
        $callBackOptions = $options->get('call_back', collect());
        
        $courseNameOptions = $options->get('course_name', collect());
        $branchOptions = $options->get('branch', collect());

        return view('admin.crm.kids_crm.form', compact(
            'districts', 
            'dataSources', 
            'interestForOptions',
            'childGenderOptions',
            'callingAgentOptions',
            'callingPurposeOptions',
            'callingStatusOptions',
            'callBackOptions',
            'courseNameOptions',
            'branchOptions'
        ));
    }

    public function store(KidsCrmRequest $request)
    {
        $data = $request->validated();
        $data['crm_type'] = 'kids_crm';

        $this->crmService->createCrm($data);

        return redirect()->route('crm.kids_crm.form')
            ->with('success', 'Kids CRM record saved successfully.');
    }

    public function index()
    {
        $crms = $this->crmService->getAllCrms('kids_crm');
        return view('admin.crm.kids_crm.index', compact('crms'));
    }

    public function history(Request $request)
    {
        if (!$request->has('phone')) {
            return response()->json([]);
        }

        return response()->json($this->crmService->getHistoryForAjax($request->phone));
    }
}
