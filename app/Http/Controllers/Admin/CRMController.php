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

    public function create($type = 'course_outbound')
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

        $view = 'admin.crm.form';
        if ($type === 'teachers_training') {
            $view = 'admin.crm.teachers_training_form';
        } elseif ($type === 'inbound') {
            $view = 'admin.crm.inbound_form';
        }

        return view($view, compact(
            'type',
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

    public function store(Request $request, $type = 'course_outbound')
    {
        $rules = [
            'phone'          => 'required|string|max:20',
            'email'          => 'nullable|email|max:255',
            'data_source_id' => 'required|exists:data_sources,id',
            'district_id'    => 'nullable|exists:districts,id',
        ];

        if ($type === 'teachers_training') {
            $rules['trainee_name'] = 'required|string|max:255';
        } else {
            $rules['parents_name'] = 'required|string|max:255';
        }

        $request->validate($rules);

        $data = $request->only([
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
            'call_back',
            'data_source_id',
            'trainee_name',
            'trainee_age',
            'experience',
            'course_title',
            'query_complaint',
        ]);
        
        $data['crm_type'] = $type;

        $this->crmService->createCrm($data);

        return redirect()->route('crm.form', ['type' => $type])
            ->with('success', 'CRM record saved successfully.');
    }

    public function index($type = 'course_outbound')
    {
        $crms = $this->crmService->getAllCrms($type);

        $view = 'admin.crm.index';
        if ($type === 'teachers_training') {
            $view = 'admin.crm.teachers_training_index';
        } elseif ($type === 'inbound') {
            $view = 'admin.crm.inbound_index';
        }

        return view($view, compact('crms', 'type'));
    }

    public function history(Request $request)
    {
        if (!$request->has('phone')) {
            return response()->json([]);
        }

        return response()->json($this->crmService->getHistoryForAjax($request->phone));
    }

    public function callBackReport()
    {
        $crms = $this->crmService->getCallBackCrms();
        return view('admin.crm.call_back_report', compact('crms'));
    }
}