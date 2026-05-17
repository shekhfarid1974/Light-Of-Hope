<?php

namespace App\Http\Controllers\Admin\Crm\Outbound;

use App\Http\Controllers\Controller;
use App\Http\Requests\Crm\TeachersTrainingRequest;
use App\Models\District;
use App\Models\DataSource;
use App\Models\CrmOption;
use App\Services\CrmService;
use Illuminate\Http\Request;

class TeachersTrainingController extends Controller
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
        $callBackOptions = $options->get('call_back', collect());

        return view('admin.crm.outbound.teachers_training.form', compact(
            'districts', 
            'dataSources', 
            'interestedForOptions', 
            'callingStatusOptions', 
            'querySourceOptions', 
            'queryStatusOptions',
            'assignedPersonOptions',
            'callBackOptions'
        ));
    }

    public function store(TeachersTrainingRequest $request)
    {
        $data = $request->validated();
        $data['crm_type'] = 'teachers_training';

        $this->crmService->createCrm($data);

        return redirect()->route('crm.teachers_training.form')
            ->with('success', 'Teachers Training CRM record saved successfully.');
    }

    public function index()
    {
        $crms = $this->crmService->getAllCrms('teachers_training');
        return view('admin.crm.outbound.teachers_training.index', compact('crms'));
    }

    public function history(Request $request)
    {
        if (!$request->has('phone')) {
            return response()->json([]);
        }

        return response()->json($this->crmService->getHistoryForAjax($request->phone));
    }
}
