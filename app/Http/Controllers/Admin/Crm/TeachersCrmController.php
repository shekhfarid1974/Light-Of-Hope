<?php

namespace App\Http\Controllers\Admin\Crm;

use App\Http\Controllers\Controller;
use App\Http\Requests\Crm\TeachersCrmRequest;
use App\Models\District;
use App\Models\DataSource;
use App\Models\CrmOption;
use App\Services\CrmService;
use Illuminate\Http\Request;

class TeachersCrmController extends Controller
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
        
        $options = CrmOption::where('crm_type', 'teachers_crm')->get()->groupBy('type');
        
        $genderOptions = $options->get('gender', collect());
        $eduQualificationOptions = $options->get('educational_qualification', collect());
        $joiningAsOptions = $options->get('joining_as', collect());
        $courseOptions = $options->get('course', collect());
        
        $currentDesignationOptions = $options->get('current_designation', collect());
        $teachingGroupOptions = $options->get('teaching_group', collect());
        $institutionTypeOptions = $options->get('institution_type', collect());
        
        $childGenderOptions = $options->get('child_gender', collect());
        
        $otherTypeOptions = $options->get('other_type', collect());
        
        $callingAgentOptions = $options->get('calling_agent', collect());
        $callingPurposeOptions = $options->get('calling_purpose', collect());
        $callingStatusOptions = $options->get('calling_status', collect());
        $callBackOptions = $options->get('call_back', collect());
        
        $interestedCourseOptions = $options->get('interested_course', collect());
        $branchOptions = $options->get('branch', collect());

        return view('admin.crm.teachers_crm.form', compact(
            'districts', 
            'dataSources', 
            'genderOptions',
            'eduQualificationOptions',
            'joiningAsOptions',
            'courseOptions',
            'currentDesignationOptions',
            'teachingGroupOptions',
            'institutionTypeOptions',
            'childGenderOptions',
            'otherTypeOptions',
            'callingAgentOptions',
            'callingPurposeOptions',
            'callingStatusOptions',
            'callBackOptions',
            'interestedCourseOptions',
            'branchOptions'
        ));
    }

    public function store(TeachersCrmRequest $request)
    {
        $data = $request->validated();
        $data['crm_type'] = 'teachers_crm';

        $this->crmService->createCrm($data);

        return redirect()->route('crm.teachers_crm.form')
            ->with('success', 'Teachers CRM record saved successfully.');
    }

    public function index()
    {
        $crms = $this->crmService->getAllCrms('teachers_crm');
        return view('admin.crm.teachers_crm.index', compact('crms'));
    }

    public function history(Request $request)
    {
        if (!$request->has('phone')) {
            return response()->json([]);
        }

        return response()->json($this->crmService->getHistoryForAjax($request->phone));
    }
}
