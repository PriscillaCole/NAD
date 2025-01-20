<?php

use App\Admin\Controllers\AccountabilityController;
use App\Admin\Controllers\ProgramController;
use App\Admin\Controllers\RequisitionController as ControllersRequisitionController;
use App\Http\Controllers\AdminBudgetController;
use App\Http\Controllers\customProgram;
use App\Http\Controllers\ProgramsController;
use App\Http\Controllers\RequisitionController;
// use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login_page');
})->name('signin');



Auth::routes();
// download all the requisitions related documents
Route::post('/requisitions/download/{id}', [RequisitionController::class, 'downloadDocuments'])
// ->middleware(['web', 'auth'])
->name('requisition.download');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/upload-staff', [App\Http\Controllers\UploadStaff::class, 'uploadStaff']);
Route::get('/dashboardvs', [App\Http\Controllers\DashboardController::class, 'getLeaveDays']);
Route::get('/dashboardwp', [App\Http\Controllers\DashboardController::class, 'showWeeklyPattern'])->name('weekly-pattern');
Route::post('/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('comments');
Route::get('/program-activities/{id}', [App\Admin\Controllers\RequisitionController::class, 'getProgramActivities'])->name('program-activities');
Route::get('/budgetlines/{id}', [App\Admin\Controllers\RequisitionController::class, 'getActivitiesbudgetlines'])->name('budgetlines');
Route::get('/requisition/{id}', [App\Admin\Controllers\AccountabilityController::class, 'getRequisitionItems'])->name('requisition');

Route::post('/programs/create', [ProgramsController::class, 'store'])->name('programsCreate');
Route::put('/programs/{program}/edit', [ProgramsController::class, 'update'])->name('programsEdit');
// Route::get('/adminprogram-budgetlines/{id}', [App\Admin\Controllers\RequisitionController::class, 'getAdminbudgetlines'])->name('adminbudgetlines');

// In routes/web.php
Route::get('/get-activities/{projectId}', [App\Http\Controllers\ReportController::class, 'getActivities']);
Route::get('/get-staff/{activityId}',  [App\Http\Controllers\ReportController::class, 'getStaff']);
Route::get('/get-requisitions/{activityId}/{staffId?}',  [App\Http\Controllers\ReportController::class, 'getRequisitions']);
Route::get('/generate-report', [App\Http\Controllers\ReportController::class, 'generateReport'])->name('generateReport');
Route::get('accountabilities/{id}', [App\Admin\Controllers\AccountabilityController::class, 'detail'])->name('accountabilities.show');
Route::get('/fetch-activities/{id}', [App\Http\Controllers\BudgetController::class, 'fetchActivities'])->name('fetch.activities');
Route::get('/download-activities/{id}', [App\Http\Controllers\BudgetController::class, 'downloadExcel'])->name('download.activities');
// Route::get('/requisition-items/{id}', [App\Admin\Controllers\AccountabilityController::class, 'downloadExcel'])->name('download.activities');

// save admin programs
Route::post('adminBudget/create', [AdminBudgetController::class, 'store']);
Route::put('/adminBudget/{program}/edit', [AdminBudgetController::class, 'update']);

Route::get('/admin-activities/{id}', [App\Admin\Controllers\RequisitionController::class, 'getAdminActivities']);
Route::get('/adminprogram-budgetlines/{id}', [App\Admin\Controllers\RequisitionController::class, 'getAdminbudgetlines'])->name('adminbudgetlines');

Route::get('/budget', [App\Http\Controllers\BudgetController::class, 'index'])->name('budget.index');
// download all the requisitions related documents
// Route::get('requisitions/download/{id}', [RequisitionController::class, 'downloadDocuments'])
// ->middleware(['web', 'auth'])
// ->name('requisition.download');

Route::post('/approve/edit', [AccountabilityController::class, 'status'])->name('edit');

