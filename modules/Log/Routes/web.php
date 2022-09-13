<?php

use Illuminate\Support\Facades\Route;
use Modules\Log\Controllers\LogController;

Route::get('/log', [LogController::class, 'index']);