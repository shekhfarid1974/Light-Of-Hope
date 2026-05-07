<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FAQ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FAQController extends Controller
{
    public function index()
    {
        $faqs = FAQ::latest()->get();

        return view('admin.faq.index', compact('faqs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $path = null;
        if ($request->hasFile('pdf_file')) {
            $path = $request->file('pdf_file')->store('faqs', 'public');
        }

        FAQ::create([
            'title'       => $request->title,
            'description' => $request->description,
            'tags'        => $request->tags,
            'pdf_path'    => $path,
        ]);

        return redirect()->route('faqs.index')
            ->with('success', 'FAQ created successfully.');
    }

    public function update(Request $request, FAQ $faq)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $path = $faq->pdf_path;
        if ($request->hasFile('pdf_file')) {
            // Delete old file
            if ($path) Storage::disk('public')->delete($path);
            $path = $request->file('pdf_file')->store('faqs', 'public');
        }

        $faq->update([
            'title'       => $request->title,
            'description' => $request->description,
            'tags'        => $request->tags,
            'pdf_path'    => $path,
        ]);

        return redirect()->route('faqs.index')
            ->with('success', 'FAQ updated successfully.');
    }

    public function destroy(FAQ $faq)
    {
        if ($faq->pdf_path) {
            Storage::disk('public')->delete($faq->pdf_path);
        }
        $faq->delete();

        return redirect()->route('faqs.index')
            ->with('success', 'FAQ deleted.');
    }

    public function search(Request $request)
    {
        $search = $request->search;

        $faqs = FAQ::where('title', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->orWhere('tags', 'LIKE', "%{$search}%")
            ->limit(10)
            ->get();

        return response()->json($faqs);
    }
}