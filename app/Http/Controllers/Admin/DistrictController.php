<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::orderBy('name')->get();

        return view('admin.district.index', compact('districts'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:districts,name']);

        District::create(['name' => $request->name]);

        return redirect()->route('districts.index')
            ->with('success', 'District added.');
    }

    public function update(Request $request, District $district)
    {
        $request->validate(['name' => 'required|string|max:255|unique:districts,name,' . $district->id]);

        $district->update(['name' => $request->name]);

        return redirect()->route('districts.index')
            ->with('success', 'District updated.');
    }

    public function destroy(District $district)
    {
        $district->delete();

        return redirect()->route('districts.index')
            ->with('success', 'District deleted.');
    }
}