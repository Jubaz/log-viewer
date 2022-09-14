<?php

namespace Modules\Log\Controllers\API\V1;

use App\Http\Controllers\BaseAPIController;
use Illuminate\Http\Request;
use Modules\File\Services\FileService;


class LogController extends BaseAPIController
{
    public function __construct(private FileService $fileService)
    {
    }

    public function index(Request $request)
    {
        $logPath = $request->get('logPath');

        if (!$logPath) {
            return $this->complain('LogPath is required');
        }

        $lines = $this->fileService->readLines($logPath, 10, $request->get('offset'));

        return $this->respond($lines);
    }


    public function getLinesCount(Request $request)
    {
        $logPath = $request->get('logPath');

        if (!$logPath) {
            return $this->complain('LogPath is required');
        }

        return $this->respond([
            'count' => $this->fileService->getCountOfLines($logPath),
        ]);
    }
}
