<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\DataSource;
use App\Models\CRM;
use Illuminate\Http\Request;

class CRMController extends Controller
{
    public function create()
    {
        $districts   = District::orderBy('name')->get();
        $dataSources = DataSource::orderBy('name')->get();

        return view('admin.crm.form', compact('districts', 'dataSources'));
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

        CRM::create($request->only([
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
            'data_source_id',
        ]));

        return redirect()->route('crm.form')
            ->with('success', 'CRM record saved successfully.');
    }

    public function index()
    {
        $crms = CRM::with(['district', 'dataSource'])->latest()->get();

        return view('admin.crm.index', compact('crms'));
    }
}