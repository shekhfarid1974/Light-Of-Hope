<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Crm\Outbound\CourseOutboundController;
use App\Http\Controllers\Admin\Crm\Outbound\TeachersTrainingController;
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

    // CRM Course Outbound
    Route::get('/crm/outbound/course/form', [CourseOutboundController::class, 'create'])->name('crm.course_outbound.form');
    Route::post('/crm/outbound/course/store', [CourseOutboundController::class, 'store'])->name('crm.course_outbound.store');
    Route::get('/crm/outbound/course/list', [CourseOutboundController::class, 'index'])->name('crm.course_outbound.index');
    Route::get('/crm/outbound/course/history', [CourseOutboundController::class, 'history'])->name('crm.course_outbound.history');

    // CRM Teachers Training Outbound
    Route::get('/crm/outbound/teachers-training/form', [TeachersTrainingController::class, 'create'])->name('crm.teachers_training.form');
    Route::post('/crm/outbound/teachers-training/store', [TeachersTrainingController::class, 'store'])->name('crm.teachers_training.store');
    Route::get('/crm/outbound/teachers-training/list', [TeachersTrainingController::class, 'index'])->name('crm.teachers_training.index');
    Route::get('/crm/outbound/teachers-training/history', [TeachersTrainingController::class, 'history'])->name('crm.teachers_training.history');

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