<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoanController;

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

Route::post('register', [AuthController::class, 'register'])->name('auth.register');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');

Route::post('loan/request', [LoanController::class, 'loanRequest'])->name('loan.loanRequest');
Route::post('loan/approve', [LoanController::class, 'approve'])->name('loan.approve');
Route::get('loan/{loan_id}/show', [LoanController::class, 'show'])->name('loan.show');

Route::post('loan/pay', [LoanController::class, 'pay'])->name('loan.pay');
