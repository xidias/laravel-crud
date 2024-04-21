<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;

Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/', function () {
    return view('home');
})->name('home');
Route::get('/company/list', [CompanyController::class,'index'])->name('company.list');
Route::get('/company/{id}', [CompanyController::class,'show'])->name('company.show');
Route::get('/company/modal/{action}/{id?}', [CompanyController::class,'modal'])->name('company.modal');
Route::put('/company/update/{id}', [CompanyController::class,'update'])->name('company.update');
Route::post('company/add', [CompanyController::class, 'store'])->name('company.add');
Route::delete('company/delete/{id}', [CompanyController::class, 'destroy'])->name('company.delete');

Route::get('/employee/list', [employeeController::class,'index'])->name('employee.list');
Route::get('/employee/{id}', [employeeController::class,'show'])->name('employee.show');
Route::get('/employee/modal/{action}/{id?}', [employeeController::class,'modal'])->name('employee.modal');
Route::put('/employee/update/{id}', [employeeController::class,'update'])->name('employee.update');
Route::post('employee/add', [employeeController::class, 'store'])->name('employee.add');
Route::delete('employee/delete/{id}', [employeeController::class, 'destroy'])->name('employee.delete');
