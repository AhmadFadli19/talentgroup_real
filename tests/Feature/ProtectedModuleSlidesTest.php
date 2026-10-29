<?php

namespace Tests\Feature;

use App\Models\Module;
use App\Models\ModuleCategory;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\TalentGroupHimaUpnvjModuleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProtectedModuleSlidesTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_an_authenticated_authorized_reader_can_receive_a_decrypted_slide(): void
    {
        [$student, $category, $lesson] = $this->makeProtectedModule();

        Storage::fake('secure');
        Storage::disk('secure')->put(
            'modules/security-test/page-001.enc',
            Crypt::encryptString('fake-webp-binary')
        );

        $pageUrl = route('modules.lesson.page', [
            'moduleSlug' => $category->slug,
            'lessonSlug' => $lesson->slug,
            'page' => 1,
        ]);

        $this->get($pageUrl)->assertRedirect(route('login'));

        $this->actingAs($student)
            ->get($pageUrl)
            ->assertOk()
            ->assertHeader('Content-Type', 'image/webp')
            ->assertHeader('Cache-Control', 'max-age=0, must-revalidate, no-cache, no-store, private')
            ->assertSee('fake-webp-binary', false);
    }

    public function test_protected_viewer_exposes_pages_without_embedding_the_original_pdf(): void
    {
        [$student, $category, $lesson] = $this->makeProtectedModule();

        $response = $this->actingAs($student)->get(route('modules.lesson.show', [
            'moduleSlug' => $category->slug,
            'lessonSlug' => $lesson->slug,
        ]));

        $response->assertOk()
            ->assertSee('data-protected-slide-viewer', false)
            ->assertSee('data-protected-slide', false)
            ->assertSee('student-slides@example.com', false)
            ->assertSee(route('modules.lesson.page', [
                'moduleSlug' => $category->slug,
                'lessonSlug' => $lesson->slug,
                'page' => 1,
            ]), false)
            ->assertDontSee('<iframe', false)
            ->assertDontSee('.pdf', false);
    }

    public function test_mentoring_module_seeder_is_repeatable_and_creates_both_protected_modules(): void
    {
        $this->seed(TalentGroupHimaUpnvjModuleSeeder::class);
        $this->seed(TalentGroupHimaUpnvjModuleSeeder::class);

        $this->assertDatabaseCount('module_categories', 2);
        $this->assertDatabaseCount('modules', 2);
        $this->assertDatabaseHas('modules', [
            'slug' => 'materi-pertemuan-1-talentgroup-infinity-hima-informatika-upnvj',
            'content_type' => 'protected_slides',
            'page_count' => 15,
            'enable_anti_screenshot' => true,
            'enable_anti_copy' => true,
        ]);
        $this->assertDatabaseHas('modules', [
            'slug' => 'materi-pertemuan-2-talentgroup-infinity-hima-informatika-upnvj',
            'content_type' => 'protected_slides',
            'page_count' => 14,
            'enable_anti_screenshot' => true,
            'enable_anti_copy' => true,
        ]);
    }

    private function makeProtectedModule(): array
    {
        Role::create(['name' => 'admin', 'display_name' => 'Administrator']);
        $studentRole = Role::create(['name' => 'user', 'display_name' => 'User']);

        $student = User::create([
            'name' => 'Student Slides',
            'username' => 'student-slides',
            'email' => 'student-slides@example.com',
            'phone' => '081234567890',
            'password' => 'password',
            'role_id' => $studentRole->id,
        ]);

        $category = ModuleCategory::create([
            'name' => 'Protected Test Module',
            'slug' => 'protected-test-module',
            'description' => 'Protected module test.',
            'is_public' => true,
            'is_active' => true,
            'enable_anti_screenshot' => true,
            'enable_anti_copy' => true,
        ]);

        $lesson = Module::create([
            'category_id' => $category->id,
            'section' => 'TEST',
            'title' => 'Protected Slides Test',
            'slug' => 'protected-slides-test',
            'content_type' => 'protected_slides',
            'file_path' => 'modules/security-test',
            'file_name' => 'Viewer Terproteksi',
            'file_size' => 100,
            'page_count' => 1,
            'is_published' => true,
            'is_public' => true,
            'enable_protection' => true,
            'enable_anti_screenshot' => true,
            'enable_anti_copy' => true,
        ]);

        return [$student, $category, $lesson];
    }
}
