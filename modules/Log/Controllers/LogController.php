<?php

namespace Modules\Log\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Modules\File\Services\FileService;

class LogController extends BaseController
{

    public function index(FileService $fileService)
    {
        dd($fileService->readLines(storage_path('logs/laravel.log'), 4, 0));
    }
}
