<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;

Route::get('/', [StudentController::class, 'create'])->name('students.create');
Route::post('/', [StudentController::class, 'store'])->name('students.store');

Route::get('/admitted-students', [StudentController::class, 'showAdmittedStudents'])->name('admitted.students');
// Route::post('/', [AdmissionController::class, 'store'])->name('admission.store');

Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::patch('/students/{id}/updateStatus', [StudentController::class, 'updateStatus'])->name('updateStatus');




Route::get('admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('admin/logout', [AdminController::class, 'logout'])->name('admin.logout');


Route::middleware([])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::patch('admin/updateAdmittedStatus/{id}', [AdminController::class, 'updateAdmittedStatus'])->name('admin.updateAdmittedStatus');
});



Route::get('/welcome', function () {
    return view('welcome');
});
