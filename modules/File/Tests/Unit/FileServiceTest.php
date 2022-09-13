<?php

namespace Modules\File\Tests\Unit;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\File\Services\FileService;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Tests\TestCase;


class FileServiceTest extends TestCase
{
    use WithFaker;

    private FileService $fileService;
    private string $filePath;
    private array $fileLines;

    public function setUp(): void
    {
        parent::setUp();

        $this->fileService = app()->make(FileService::class);

        $this->createFakeLogFile();
    }

    public function test_it_returns_10_lines_from_files()
    {
        $lines = $this->fileService->readLines($this->filePath, 10);

        $this->assertCount(10, $lines);
    }

    public function test_it_should_skip_the_first_line()
    {
        $lines = $this->fileService->readLines($this->filePath, 10, 1);

        $this->assertEquals($this->fileLines[1], $lines[0]);
    }

    public function test_returns_the_last_line_only()
    {
        $lines = $this->fileService->readLines($this->filePath, 10, count($this->fileLines) - 1);

        $this->assertEquals(end($this->fileLines), $lines[0]);
    }

    public function test_it_throw_exception_if_file_not_exists()
    {
        $this->expectException(FileNotFoundException::class);

        $this->fileService->readLines('/test.txt', 1);
    }

    public function test_it_throw_exception_if_directory_path_was_send()
    {
        $this->expectException(FileNotFoundException::class);

        $this->fileService->readLines('/', 1);
    }

    private function createFakeLogFile()
    {
        $this->fileLines = explode(',', $this->faker->realText(2000));

        $content = implode("\n", $this->fileLines);

        Storage::fake('local');

        UploadedFile::fake()->createWithContent('laravel.log', $content)->storeAs('', 'laravel.log');

        $this->filePath = storage_path('framework/testing/disks/local/laravel.log');
    }

}
