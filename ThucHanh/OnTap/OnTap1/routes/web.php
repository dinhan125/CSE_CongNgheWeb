<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

// Định nghĩa Resource Route cho CRUD đầy đủ
Route::resource('employees', EmployeeController::class);
