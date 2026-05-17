<?php

namespace App\Http\Controllers\Admin\Crm;

use App\Http\Controllers\Controller;
use App\Models\CallBack;
use Illuminate\Http\Request;

class CallBackController extends Controller
{
    public function index()
    {
        $callBacks = CallBack::with('crm')->latest()->get();
        return view('admin.crm.call_back_report', compact('callBacks'));
    }
}
