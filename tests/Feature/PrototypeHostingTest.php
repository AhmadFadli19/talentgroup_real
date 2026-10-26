<?php

namespace Tests\Feature;

use App\Models\Prototype;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PrototypeHostingTest extends TestCase
{
    private string $prototypeDirectory;

    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('prototypes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('project_name');
            $table->string('slug')->unique();
            $table->string('upload_type')->default('zip_archive');
            $table->string('storage_path');
            $table->string('ai_provider_used')->default('gemini');
            $table->integer('ai_score')->default(100);
            $table->json('ai_report_json')->nullable();
            $table->boolean('is_approved')->default(true);
            $table->boolean('is_hosted')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $this->prototypeDirectory = sys_get_temp_dir().'/talentgroup-host-test-'.bin2hex(random_bytes(8));
        File::makeDirectory($this->prototypeDirectory.'/assets', 0755, true);
        File::put(
            $this->prototypeDirectory.'/index.html',
            '<!doctype html><html><head></head><body><script src="assets/app.js"></script></body></html>'
        );
        File::put($this->prototypeDirectory.'/assets/app.js', 'window.hostedPrototype = true;');

        Prototype::create([
            'user_id' => 1,
            'project_name' => 'Hosted Demo',
            'slug' => 'hosted-demo',
            'upload_type' => 'zip_archive',
            'storage_path' => $this->prototypeDirectory,
            'ai_provider_used' => 'test',
            'ai_score' => 100,
            'is_approved' => true,
            'is_hosted' => true,
            'is_active' => true,
        ]);
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('prototypes');

        if (isset($this->prototypeDirectory) && File::isDirectory($this->prototypeDirectory)) {
            File::deleteDirectory($this->prototypeDirectory);
        }

        parent::tearDown();
    }

    public function test_it_serves_the_hosted_index_and_static_assets(): void
    {
        $this->get('/p/hosted-demo')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/html; charset=utf-8')
            ->assertSee('/p/hosted-demo/', false)
            ->assertSee('assets/app.js', false);

        $assetResponse = $this->get('/p/hosted-demo/assets/app.js');
        $assetResponse
            ->assertOk()
            ->assertHeader('Content-Type', 'application/javascript; charset=utf-8');

        $this->assertSame(
            'window.hostedPrototype = true;',
            File::get($assetResponse->baseResponse->getFile()->getPathname())
        );
    }

    public function test_it_falls_back_to_index_for_client_side_routes(): void
    {
        $this->get('/p/hosted-demo/dashboard/settings')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/html; charset=utf-8')
            ->assertSee('assets/app.js', false);
    }

    public function test_it_does_not_mask_a_missing_asset_as_an_spa_route(): void
    {
        $this->get('/p/hosted-demo/assets/missing.js')->assertNotFound();
    }
}
