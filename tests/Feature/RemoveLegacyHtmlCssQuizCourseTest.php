<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\CourseQuestion;
use App\Models\Role;
use App\Models\User;
use App\Models\UserCourse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RemoveLegacyHtmlCssQuizCourseTest extends TestCase
{
    use RefreshDatabase;

    public function test_cleanup_migration_only_removes_the_legacy_group_photo_course(): void
    {
        $adminRole = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
        ]);
        $userRole = Role::create([
            'name' => 'user',
            'display_name' => 'User',
        ]);

        $admin = User::create([
            'name' => 'Admin Test',
            'username' => 'legacy-course-admin',
            'email' => 'legacy-course-admin@example.com',
            'phone' => '081200000001',
            'password' => 'password',
            'role_id' => $adminRole->id,
        ]);
        $student = User::create([
            'name' => 'Student Test',
            'username' => 'legacy-course-student',
            'email' => 'legacy-course-student@example.com',
            'phone' => '081200000002',
            'password' => 'password',
            'role_id' => $userRole->id,
        ]);

        $legacyCourse = Course::create([
            'title' => 'Quiz dasar HTML dan CSS',
            'description' => 'Course lama dengan foto bersama.',
            'price' => 0,
            'is_active' => true,
            'created_by' => $admin->id,
        ]);
        $protectedCourse = Course::create([
            'title' => 'Latihan HTML, CSS & JavaScript',
            'description' => 'Course latihan baru.',
            'price' => 0,
            'is_active' => true,
            'created_by' => $admin->id,
        ]);

        $legacyQuestion = CourseQuestion::create([
            'course_id' => $legacyCourse->id,
            'question_type' => 'multiple_choice',
            'difficulty' => 'beginner',
            'title' => 'Soal Lama',
            'content' => 'Soal yang ikut terhapus.',
            'options' => ['A', 'B'],
            'correct_answer' => 'A',
            'order' => 1,
        ]);

        UserCourse::create([
            'user_id' => $student->id,
            'course_id' => $legacyCourse->id,
            'purchased_at' => now(),
            'is_completed' => false,
            'current_content_id' => 'question:' . $legacyQuestion->id,
        ]);

        $migration = require database_path('migrations/2026_10_28_000002_remove_legacy_html_css_quiz_course.php');
        $migration->up();

        $this->assertDatabaseMissing('courses', ['id' => $legacyCourse->id]);
        $this->assertDatabaseMissing('course_questions', ['id' => $legacyQuestion->id]);
        $this->assertDatabaseMissing('user_courses', ['course_id' => $legacyCourse->id]);
        $this->assertDatabaseHas('courses', ['id' => $protectedCourse->id]);
    }
}
