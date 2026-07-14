<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Crm\KidsCrmController;
use App\Http\Controllers\Admin\Crm\TeachersCrmController;
use App\Http\Controllers\Admin\Crm\CallBackController;

use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\DataSourceController;
use App\Http\Controllers\Admin\CrmOptionController;

Route::get('/', function () {
    return redirect()->route('login');
});

use App\Http\Controllers\Admin\DashboardController;

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRM Kids 
    Route::get('/crm/kids-crm/form', [KidsCrmController::class, 'create'])->name('crm.kids_crm.form');
    Route::post('/crm/kids-crm/store', [KidsCrmController::class, 'store'])->name('crm.kids_crm.store');
    Route::get('/crm/kids-crm/list', [KidsCrmController::class, 'index'])->name('crm.kids_crm.index');
    Route::get('/crm/kids-crm/history', [KidsCrmController::class, 'history'])->name('crm.kids_crm.history');

    // CRM Teachers 
    Route::get('/crm/teachers-crm/form', [TeachersCrmController::class, 'create'])->name('crm.teachers_crm.form');
    Route::post('/crm/teachers-crm/store', [TeachersCrmController::class, 'store'])->name('crm.teachers_crm.store');
    Route::get('/crm/teachers-crm/list', [TeachersCrmController::class, 'index'])->name('crm.teachers_crm.index');
    Route::get('/crm/teachers-crm/history', [TeachersCrmController::class, 'history'])->name('crm.teachers_crm.history');

    // Call Back Route
    Route::get('/crm/call-back-report', [CallBackController::class, 'index'])->name('crm.callback.report');

    // FAQ Search API
    Route::get('/light-of-hope/crm/faq/search', [FAQController::class, 'search'])
        ->name('faq.search');

    // Resources
    Route::resource('districts', DistrictController::class);
    Route::resource('data-sources', DataSourceController::class);
    Route::resource('faqs', FAQController::class);
    Route::resource('crm-options', CrmOptionController::class)->except(['create', 'edit', 'show']);
});

require __DIR__.'/auth.php';