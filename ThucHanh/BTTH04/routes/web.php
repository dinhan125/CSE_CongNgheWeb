<?php

use App\Http\Controllers\IssueController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IssueController::class, 'index']); // Trang chủ trỏ về danh sách
Route::resource('issues', IssueController::class);
