<?php

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
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/upload-staff', [App\Http\Controllers\UploadStaff::class, 'uploadStaff']);
Route::get('/dashboardvs', [App\Http\Controllers\DashboardController::class, 'getLeaveDays']);
Route::get('/dashboardwp', [App\Http\Controllers\DashboardController::class, 'showWeeklyPattern'])->name('weekly-pattern');
Route::post('/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('comments');
Route::get('/program-activities/{id}', [App\Admin\Controllers\RequisitionController::class, 'getProgramActivities'])->name('program-activities');
Route::get('/requisition/{id}', [App\Admin\Controllers\AccountabilityController::class, 'Requisition'])->name('requisition');

