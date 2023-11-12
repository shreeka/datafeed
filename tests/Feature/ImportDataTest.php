<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class ImportDataTest extends TestCase
{
    use RefreshDatabase;
    public function testDataIsImportedFromXMLFileAndInsertedToDB(): void
    {
        $filePath = base_path('tests/testfiles/data.xml');
        $this->artisan('import:data', ['file' => $filePath])
            ->expectsOutput('Data from XML file imported to DB successfully.')
            ->assertExitCode(0);
        $this->assertDatabaseCount('items',2);


    }

    public function testFileNotSupported(): void
    {
        $filePath = base_path('tests/testfiles/mockfile.csv');
        $this->artisan('import:data', ['file' => $filePath])
            ->expectsOutput('File not supported.')
            ->assertExitCode(0);
    }

    public function testImportDataWithoutAFile(): void
    {
        $this->expectExceptionMessage('Not enough arguments (missing: "file").');
        $this->artisan('import:data');
    }

}
