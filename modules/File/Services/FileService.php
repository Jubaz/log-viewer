<?php

namespace Modules\File\Services;

use SplFileObject;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class FileService
{
    public function readLines(string $filePath, int $limit, int $offset = 0): array
    {
        $lines = [];

        $this->fileExists($filePath);

        $file = new SplFileObject($filePath);

        while ($limit > 0) {
            $file->seek($offset);
            $line = $file->current();
            if ($line == false) {
                break;
            }
            $lines[$offset + 1] = str_replace("\n", "", $file->current());
            $offset++;
            $limit--;
        }

        $file = null;

        return $lines;
    }

    public function getCountOfLines(string $filePath): int
    {
        $this->fileExists($filePath);

        $file = fopen($filePath, 'rb');

        $lines = 0;

        while (!feof($file)) {
            $lines += substr_count(fread($file, 8192), "\n");
        }

        fclose($file);

        return $lines;
    }


    private function fileExists(string $filePath)
    {
        if (!is_file($filePath)) {
            throw new FileNotFoundException($filePath);
        }
    }

}