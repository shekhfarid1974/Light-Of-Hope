<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CRMController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\DataSourceController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // CRM
    Route::get('/crm/form', [CRMController::class, 'create'])->name('crm.form');
    Route::post('/crm/store', [CRMController::class, 'store'])->name('crm.store');
    Route::get('/crm/list', [CRMController::class, 'index'])->name('crm.index');

    // AJAX: Interaction history by phone
    Route::get('/crm/history', [CRMController::class, 'history'])->name('crm.history');

    // FAQ Search API
    Route::get('/light-of-hope/crm/faq/search', [FAQController::class, 'search'])
        ->name('faq.search');

    // Resources
    Route::resource('districts', DistrictController::class);
    Route::resource('data-sources', DataSourceController::class);
    Route::resource('faqs', FAQController::class);
});

require __DIR__.'/auth.php';