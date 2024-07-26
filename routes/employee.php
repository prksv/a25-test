<?php

use App\Http\Controllers\Api\Admin\EmployeeController;
use App\Http\Controllers\Api\Employee;
use App\Http\Controllers\Api\Employee\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix("{employee}")->group(function () {
    Route::post("transactions", [TransactionController::class, "store"]);
});
