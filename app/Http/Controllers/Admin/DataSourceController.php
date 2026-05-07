<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataSource;
use Illuminate\Http\Request;

class DataSourceController extends Controller
{
    public function index()
    {
        $dataSources = DataSource::latest()->get();

        return view('admin.datasource.index', compact('dataSources'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:data_sources,name']);

        DataSource::create(['name' => $request->name]);

        return redirect()->route('data-sources.index')
            ->with('success', 'Data source added.');
    }

    public function update(Request $request, DataSource $dataSource)
    {
        $request->validate(['name' => 'required|string|max:255|unique:data_sources,name,' . $dataSource->id]);

        $dataSource->update(['name' => $request->name]);

        return redirect()->route('data-sources.index')
            ->with('success', 'Data source updated.');
    }

    public function destroy(DataSource $dataSource)
    {
        $dataSource->delete();

        return redirect()->route('data-sources.index')
            ->with('success', 'Data source deleted.');
    }
}