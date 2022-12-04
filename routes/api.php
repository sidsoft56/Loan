<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'customer/'], function(){
    Route::post('register', [App\Http\Controllers\RegisterController::class,'register'])->name('customer.register');

    Route::post('login', [App\Http\Controllers\RegisterController::class,'login'])->name('customer.login');
});

Route::middleware([
    'auth:api'
])->group(function(){
    Route::post('customer/apply-loan', [App\Http\Controllers\LoanController::class,'ApplyLoan'])->name('customer.ApplyLoan');
    
    Route::post('admin/approve-loan', [App\Http\Controllers\LoanController::class,'ApproveLoan'])->name('customer.ApproveLoan');
    
    Route::post('customer/loan-detail', [App\Http\Controllers\LoanController::class,'LoanDetail'])->name('customer.LoanDetail');
    
    Route::post('customer/pay-installment', [App\Http\Controllers\LoanController::class,'PayInstallment'])->name('customer.PayInstallment');
});


