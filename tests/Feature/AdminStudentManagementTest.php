<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Role;
use App\Models\User;
use App\Models\UserCourse;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use ZipArchive;

class AdminStudentManagementTest extends TestCase
{
    use RefreshDatabase;

    private Role $adminRole;

    private Role $studentRole;

    private User $admin;

    private User $studentWithCourse;

    private User $studentWithoutCourse;

    private Course $course;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminRole = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
        ]);
        $this->studentRole = Role::create([
            'name' => 'user',
            'display_name' => 'Siswa',
        ]);

        $this->admin = User::factory()->create([
            'name' => 'Admin TalentGroup',
            'username' => 'admin_tg',
            'email' => 'admin@talentgroup.test',
            'phone' => '080000000001',
            'role_id' => $this->adminRole->id,
        ]);

        $this->studentWithCourse = User::factory()->create([
            'name' => 'Adrian Siswa Aktif',
            'username' => 'adrian_siswa',
            'email' => 'adrian@student.test',
            'phone' => '080000000002',
            'role_id' => $this->studentRole->id,
            'google_id' => 'google-adrian-123',
        ]);

        $this->studentWithoutCourse = User::factory()->create([
            'name' => 'Budi Belum Kursus',
            'username' => 'budi_baru',
            'email' => 'budi@student.test',
            'phone' => '080000000003',
            'role_id' => $this->studentRole->id,
            'google_id' => null,
        ]);

        $this->course = Course::create([
            'title' => 'Dasar Figma untuk Pemula',
            'description' => 'Kursus pengenalan Figma.',
            'price' => 0,
            'is_active' => true,
            'created_by' => $this->admin->id,
        ]);

        UserCourse::create([
            'user_id' => $this->studentWithCourse->id,
            'course_id' => $this->course->id,
            'purchased_at' => now(),
            'is_completed' => true,
            'current_content_id' => 1,
        ]);
    }

    public function test_admin_can_view_students_and_their_learning_progress(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.students.index'));

        $response
            ->assertOk()
            ->assertSee('Daftar Siswa TalentGroup')
            ->assertSee('Adrian Siswa Aktif')
            ->assertSee('Budi Belum Kursus')
            ->assertSee('Dasar Figma untuk Pemula')
            ->assertSee('Unduh Excel')
            ->assertSee('Unduh PDF');
    }

    public function test_admin_can_filter_students_by_search_course_and_status(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.students.index', [
                'search' => 'Adrian',
                'course' => $this->course->id,
                'status' => 'completed',
            ]))
            ->assertOk()
            ->assertSee('Adrian Siswa Aktif')
            ->assertDontSee('Budi Belum Kursus');

        $this->actingAs($this->admin)
            ->get(route('admin.students.index', ['status' => 'no_course']))
            ->assertOk()
            ->assertSee('Budi Belum Kursus')
            ->assertDontSee('Adrian Siswa Aktif');
    }

    public function test_regular_student_cannot_access_admin_student_data(): void
    {
        $this->actingAs($this->studentWithCourse)
            ->get(route('admin.students.index'))
            ->assertForbidden();

        $this->actingAs($this->studentWithCourse)
            ->get(route('admin.students.export.excel'))
            ->assertForbidden();

        $this->actingAs($this->studentWithCourse)
            ->get(route('admin.students.export.pdf'))
            ->assertForbidden();
    }

    public function test_admin_can_download_a_real_xlsx_student_report(): void
    {
        Carbon::setTestNow('2026-10-30 10:00:00');

        $response = $this->actingAs($this->admin)
            ->get(route('admin.students.export.excel'));

        $response
            ->assertOk()
            ->assertDownload('daftar-siswa-talentgroup-2026-10-30.xlsx')
            ->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        $path = $response->baseResponse->getFile()->getPathname();
        $zip = new ZipArchive;

        $this->assertTrue($zip->open($path) === true);
        $worksheet = $zip->getFromName('xl/worksheets/sheet1.xml');
        $zip->close();

        $this->assertIsString($worksheet);
        $this->assertStringContainsString('Adrian Siswa Aktif', $worksheet);
        $this->assertStringContainsString('Budi Belum Kursus', $worksheet);
        $this->assertStringContainsString('Dasar Figma untuk Pemula', $worksheet);
        $this->assertStringNotContainsString('admin@talentgroup.test', $worksheet);
    }

    public function test_admin_can_download_a_real_pdf_student_report(): void
    {
        Carbon::setTestNow('2026-10-30 10:00:00');

        $response = $this->actingAs($this->admin)
            ->get(route('admin.students.export.pdf'));

        $response
            ->assertOk()
            ->assertDownload('daftar-siswa-talentgroup-2026-10-30.pdf')
            ->assertHeader('content-type', 'application/pdf');

        $this->assertStringStartsWith('%PDF-', $response->getContent());
    }
}
