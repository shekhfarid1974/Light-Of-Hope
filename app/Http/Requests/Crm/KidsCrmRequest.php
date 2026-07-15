<?php

namespace App\Http\Requests\Crm;

use Illuminate\Foundation\Http\FormRequest;

class KidsCrmRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'father_phone' => 'required|string|max:20',
            'mother_phone' => 'required|string|max:20',
            'whatsapp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'profession' => 'required|string|max:255',
            'district_id' => 'nullable|exists:districts,id',
            'area' => 'nullable|string|max:255',
            'interest_for' => 'nullable|string|max:255',

            'child_name' => 'nullable|string|max:255',
            'child_gender' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'child_age' => 'nullable|integer',
            'class' => 'nullable|string|max:255',
            'school_name' => 'nullable|string|max:255',

            'calling_date' => 'nullable|date',
            'calling_agent' => 'nullable|string|max:255',
            'calling_purpose' => 'nullable|string|max:255',
            'calling_status' => 'nullable|string|max:255',
            'discussion_note' => 'nullable|string',
            'next_follow_up_date' => 'nullable|date',
            'call_back' => 'nullable|string|max:255',
            'call_back_date' => 'nullable|date',
            'call_back_time' => 'nullable',

            'course_name' => 'nullable|string|max:255',
            'date_of_purchase' => 'nullable|date',
            'branch' => 'nullable|string|max:255',
            'data_source_id' => 'nullable|exists:data_sources,id',
            'agent' => 'nullable|string|max:255',
        ];
    }
}
