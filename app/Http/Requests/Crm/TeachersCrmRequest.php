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
            'trainee_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'data_source_id' => 'required|exists:data_sources,id',
            'district_id' => 'nullable|exists:districts,id',

            'profession' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'trainee_age' => 'nullable|string|max:255',
            'course_title' => 'nullable|string|max:255',

            'assigned_person' => 'nullable|string|max:255',
            'query_complaint' => 'required|string',
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
