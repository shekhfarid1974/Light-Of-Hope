<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CrmOption;
use Illuminate\Http\Request;

class CrmOptionController extends Controller
{
    public function index(Request $request)
    {
        $crmTypes = [
            'teachers_crm' => 'Teachers CRM',
            'kids_crm' => 'Kids CRM',
        ];

        $teachersOptionTypes = [
            'gender' => 'Gender',
            'educational_qualification' => 'Educational Qualification',
            'joining_as' => 'Joining As',
            'course' => 'Course/Product Name (Section 1)',
            'current_designation' => 'Current Designation',
            'teaching_group' => 'Teaching Group',
            'institution_type' => 'Institution Type',
            'child_gender' => 'Child Gender',
            'other_type' => 'Other (Type)',
            'calling_agent' => 'Calling Agent',
            'calling_purpose' => 'Calling Purpose',
            'calling_status' => 'Calling Status',
            'call_back' => 'Call Back Status',
            'interested_course' => 'Interested Course/Product Name',
            'branch' => 'Branch',
        ];

        $kidsOptionTypes = [
            'interest_for' => 'Interest For',
            'child_gender' => 'Child Gender',
            'calling_agent' => 'Calling Agent',
            'calling_purpose' => 'Calling Purpose',
            'calling_status' => 'Calling Status',
            'call_back' => 'Call Back Status',
            'course_name' => 'Course/Product Name',
            'branch' => 'Branch',
        ];

        $currentCrmType = $request->get('crm_type', 'teachers_crm');
        if (!array_key_exists($currentCrmType, $crmTypes)) {
            $currentCrmType = 'teachers_crm';
        }

        $types = ($currentCrmType === 'kids_crm') ? $kidsOptionTypes : $teachersOptionTypes;

        $currentType = $request->get('type', array_key_first($types));
        if (!array_key_exists($currentType, $types)) {
            $currentType = array_key_first($types);
        }

        $options = CrmOption::where('crm_type', $currentCrmType)
            ->where('type', $currentType)
            ->latest()
            ->get();

        return view('admin.crm_options.index', compact('options', 'types', 'currentType', 'crmTypes', 'currentCrmType'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'crm_type' => 'required|string',
            'type' => 'required|string',
            'name' => 'required|string|max:255',
        ]);

        CrmOption::create($request->only('crm_type', 'type', 'name'));

        return redirect()->route('crm-options.index', ['crm_type' => $request->crm_type, 'type' => $request->type])
            ->with('success', 'Option added successfully.');
    }

    public function update(Request $request, CrmOption $crmOption)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $crmOption->update(['name' => $request->name]);

        return redirect()->route('crm-options.index', ['crm_type' => $crmOption->crm_type, 'type' => $crmOption->type])
            ->with('success', 'Option updated successfully.');
    }

    public function destroy(CrmOption $crmOption)
    {
        $crm_type = $crmOption->crm_type;
        $type = $crmOption->type;
        $crmOption->delete();

        return redirect()->route('crm-options.index', ['crm_type' => $crm_type, 'type' => $type])
            ->with('success', 'Option deleted successfully.');
    }
}
