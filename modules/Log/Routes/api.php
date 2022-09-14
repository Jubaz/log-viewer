<?php

use Illuminate\Support\Facades\Route;
use Modules\Log\Controllers\API\V1\LogController;

$APIPrefix = ApiV1Prefix();

Route::get($APIPrefix.'/log', [LogController::class, 'index'])->name('api.logs.index');
Route::get($APIPrefix.'/log/lines/count', [LogController::class, 'getLinesCount'])->name('api.log.lines.count');
