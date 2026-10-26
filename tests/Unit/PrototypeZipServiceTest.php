<?php

namespace Tests\Unit;

use App\Services\PrototypeZipService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;
use ZipArchive;

class PrototypeZipServiceTest extends TestCase
{
    private string $workingDirectory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->workingDirectory = sys_get_temp_dir().'/talentgroup-zip-test-'.bin2hex(random_bytes(8));
        File::makeDirectory($this->workingDirectory, 0755, true);
    }

    protected function tearDown(): void
    {
        if (isset($this->workingDirectory) && File::isDirectory($this->workingDirectory)) {
            File::deleteDirectory($this->workingDirectory);
        }

        parent::tearDown();
    }

    public function test_it_promotes_a_nested_static_site_to_the_hosting_root(): void
    {
        $uploadedZip = $this->makeZip([
            'my-project/package.json' => '{"scripts":{"start":"node server.js"}}',
            'my-project/server.js' => 'console.log("backend is not executed");',
            'my-project/public/index.html' => '<html><head></head><body><script src="assets/app.js"></script></body></html>',
            'my-project/public/assets/style.css' => 'body { color: rgb(1, 2, 3); }',
            'my-project/public/assets/app.js' => 'window.prototypeReady = true;',
        ]);
        $destination = $this->workingDirectory.'/extracted';

        $result = app(PrototypeZipService::class)->extractZip($uploadedZip, $destination);

        $this->assertTrue($result['success'], $result['error'] ?? 'ZIP extraction failed.');
        $this->assertFileExists($destination.'/index.html');
        $this->assertFileExists($destination.'/assets/style.css');
        $this->assertFileExists($destination.'/assets/app.js');
        $this->assertStringContainsString('rgb(1, 2, 3)', $result['css_code']);
        $this->assertStringContainsString('window.prototypeReady', $result['js_code']);
    }

    public function test_it_unwraps_multiple_single_folder_levels(): void
    {
        $uploadedZip = $this->makeZip([
            'export/final-site/index.html' => '<!doctype html><title>Nested prototype</title>',
            'export/final-site/styles/site.css' => 'body { background: white; }',
        ]);
        $destination = $this->workingDirectory.'/deeply-nested';

        $result = app(PrototypeZipService::class)->extractZip($uploadedZip, $destination);

        $this->assertTrue($result['success'], $result['error'] ?? 'ZIP extraction failed.');
        $this->assertFileExists($destination.'/index.html');
        $this->assertFileExists($destination.'/styles/site.css');
    }

    public function test_it_rejects_a_zip_without_an_index_file(): void
    {
        $uploadedZip = $this->makeZip([
            'project/home.html' => '<!doctype html><title>No index</title>',
        ]);

        $result = app(PrototypeZipService::class)->extractZip(
            $uploadedZip,
            $this->workingDirectory.'/missing-index'
        );

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('index.html tidak ditemukan', $result['error']);
    }

    /**
     * @param  array<string, string>  $entries
     */
    private function makeZip(array $entries): UploadedFile
    {
        $zipPath = $this->workingDirectory.'/prototype-'.bin2hex(random_bytes(4)).'.zip';
        $zip = new ZipArchive;
        $this->assertTrue($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE));

        foreach ($entries as $path => $content) {
            $this->assertTrue($zip->addFromString($path, $content));
        }

        $this->assertTrue($zip->close());

        return new UploadedFile($zipPath, basename($zipPath), 'application/zip', null, true);
    }
}
