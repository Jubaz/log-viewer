<?php

namespace Modules\File\Services;

use SplFileObject;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class FileService
{
    public function readLines(string $filePath, int $limit, int $offset = 0): array
    {
        $lines = [];

        if (!is_file($filePath)) {
            throw new FileNotFoundException($filePath);
        }

        $file = new SplFileObject($filePath);

        while ($limit > 0) {
            $file->seek($offset);
            $line = $file->current();
            if ($line == false) {
                break;
            }
            $lines[] = str_replace("\n", "", $file->current());
            $offset++;
            $limit--;
        }

        $file = null;

        return $lines;
    }

}