<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CrmOption;
use Illuminate\Http\Request;

class CrmOptionController extends Controller
{
    public function index(Request $request)
    {
        $types = [
            'interested_for' => 'Interested For',
            'calling_status' => 'Calling Status',
            'query_source' => 'Query Source',
            'query_status' => 'Query Status',
            'assigned_person' => 'Assigned Person',
            'call_back' => 'Call Back',
        ];

        $currentType = $request->get('type', 'interested_for');

        if (!array_key_exists($currentType, $types)) {
            $currentType = 'interested_for';
        }

        $options = CrmOption::where('type', $currentType)->latest()->get();

        return view('admin.crm_options.index', compact('options', 'types', 'currentType'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'name' => 'required|string|max:255',
        ]);

        CrmOption::create($request->only('type', 'name'));

        return redirect()->route('crm-options.index', ['type' => $request->type])
            ->with('success', 'Option added successfully.');
    }

    public function update(Request $request, CrmOption $crmOption)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $crmOption->update(['name' => $request->name]);

        return redirect()->route('crm-options.index', ['type' => $crmOption->type])
            ->with('success', 'Option updated successfully.');
    }

    public function destroy(CrmOption $crmOption)
    {
        $type = $crmOption->type;
        $crmOption->delete();

        return redirect()->route('crm-options.index', ['type' => $type])
            ->with('success', 'Option deleted successfully.');
    }
}
