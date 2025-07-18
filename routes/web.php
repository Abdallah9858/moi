<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MoiController;

Route::get('/', [MoiController::class, 'index']);

