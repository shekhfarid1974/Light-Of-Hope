<?php

namespace App\Http\Requests\Crm;

use Illuminate\Foundation\Http\FormRequest;

class CourseOutboundRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'parents_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'data_source_id' => 'required|exists:data_sources,id',
            'district_id' => 'nullable|exists:districts,id',

            'profession' => 'nullable|string|max:255',
            'child_gender' => 'nullable|string|max:255',
            'child_age' => 'nullable|string|max:255',
            'child_name' => 'nullable|string|max:255',
            'class' => 'nullable|string|max:255',
            'interested_for' => 'nullable|string|max:255',
            'assigned_person' => 'nullable|string|max:255',
            'remarks' => 'required|string',
            'agent' => 'nullable|string|max:255',
            'calling_status' => 'nullable|string|max:255',
            'query_source' => 'nullable|string|max:255',
            'query_status' => 'nullable|string|max:255',
            'call_back' => 'nullable|string|max:255',
            'call_back_date' => 'nullable|date',
            'call_back_time' => 'nullable',
        ];
    }
}
