<?php

namespace App\Http\Requests\Crm;

use Illuminate\Foundation\Http\FormRequest;

class TeachersCrmRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'whatsapp' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'gender' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'district_id' => 'required|exists:districts,id',
            'age' => 'nullable|integer',
            'educational_qualification' => 'nullable|string|max:255',
            'joining_as' => 'required|string|max:255',
            'course' => 'nullable|string|max:255',

            'current_designation' => 'nullable|string|max:255',
            'years_of_experience' => 'nullable|string|max:255',
            'teaching_group' => 'nullable|string|max:255',
            'institution_name' => 'nullable|string|max:255',
            'institution_address' => 'nullable|string|max:255',
            'institution_type' => 'nullable|string|max:255',

            'child_name' => 'nullable|string|max:255',
            'child_gender' => 'nullable|string|max:255',
            'dob' => 'nullable|integer',

            'other_type' => 'nullable|string|max:255',
            'organization' => 'nullable|string|max:255',

            'calling_agent' => 'nullable|string|max:255',
            'calling_purpose' => 'nullable|string|max:255',
            'calling_status' => 'nullable|string|max:255',
            'data_source_id' => 'nullable|exists:data_sources,id',
            'discussion_note' => 'nullable|string',
            'next_follow_up_date' => 'nullable|string|max:255',
            'call_back' => 'nullable|string|max:255',
            'call_back_date' => 'nullable|date',
            'call_back_time' => 'nullable',

            'interested_course' => 'nullable|string|max:255',
            'date_of_purchase' => 'nullable|date',
            'branch' => 'nullable|string|max:255',
            'agent' => 'nullable|string|max:255',
        ];
    }
}
