<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class ImportDataTest extends TestCase
{
    public function testDataIsImportedFromXMLFile(): void
    {
    }

    public function testImportDataWithoutAFile(): void
    {
        $this->expectExceptionMessage('Not enough arguments (missing: "file").');
        $this->artisan('import:data');
    }

}
