<?php
use App\Http\Controllers\Api\LoanController;
use Illuminate\Support\Facades\Route;


Route::post('/loans', [LoanController::class, 'store']); // Create new loan
