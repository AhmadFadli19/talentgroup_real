<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\CourseQuestion;
use App\Models\Role;
use App\Models\User;
use App\Models\UserCourse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PracticeQuestionSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_end_feedback_does_not_leak_correctness_in_json_response(): void
    {
        [$student, $course, $question] = $this->makePracticeContext(true);

        $this->actingAs($student)
            ->postJson(route('user.courses.answer', [$course, 'question:' . $question->id]), [
                'answer' => $question->correct_answer,
            ])
            ->assertOk()
            ->assertJson([
                'success' => true,
                'is_correct' => null,
                'reveal_answers' => false,
            ]);
    }

    public function test_unenrolled_student_cannot_submit_an_answer(): void
    {
        [$student, $course, $question] = $this->makePracticeContext(false);

        $this->actingAs($student)
            ->postJson(route('user.courses.answer', [$course, 'question:' . $question->id]), [
                'answer' => $question->correct_answer,
            ])
            ->assertForbidden();
    }

    public function test_question_must_belong_to_the_course_in_the_url(): void
    {
        [$student, $course] = $this->makePracticeContext(true);
        $admin = User::where('role_id', 1)->firstOrFail();

        $otherCourse = Course::create([
            'title' => 'Paket Lain',
            'description' => 'Paket pengujian lain.',
            'price' => 0,
            'is_active' => true,
            'quiz_answer_visibility' => 'end',
            'quiz_navigation_mode' => 'free',
            'shuffle_questions' => false,
            'shuffle_options' => true,
            'created_by' => $admin->id,
        ]);

        $otherQuestion = CourseQuestion::create([
            'course_id' => $otherCourse->id,
            'question_type' => 'multiple_choice',
            'difficulty' => 'beginner',
            'title' => 'Soal dari Paket Lain',
            'content' => 'Pilih jawaban yang benar.',
            'options' => ['Benar', 'Salah'],
            'correct_answer' => 'Benar',
            'order' => 1,
        ]);

        $this->actingAs($student)
            ->postJson(route('user.courses.answer', [$course, 'question:' . $otherQuestion->id]), [
                'answer' => 'Benar',
            ])
            ->assertNotFound();
    }

    private function makePracticeContext(bool $enrolled): array
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
            'username' => 'security-admin',
            'email' => 'security-admin@example.com',
            'phone' => '081111111111',
            'password' => 'password',
            'role_id' => $adminRole->id,
        ]);
        $student = User::create([
            'name' => 'Student Test',
            'username' => 'security-student',
            'email' => 'security-student@example.com',
            'phone' => '082222222222',
            'password' => 'password',
            'role_id' => $userRole->id,
        ]);

        $course = Course::create([
            'title' => 'Latihan Aman',
            'description' => 'Paket latihan untuk pengujian keamanan.',
            'price' => 0,
            'is_active' => true,
            'quiz_answer_visibility' => 'end',
            'quiz_navigation_mode' => 'free',
            'shuffle_questions' => false,
            'shuffle_options' => true,
            'created_by' => $admin->id,
        ]);

        $question = CourseQuestion::create([
            'course_id' => $course->id,
            'question_type' => 'multiple_choice',
            'difficulty' => 'beginner',
            'title' => 'Soal Aman',
            'content' => 'Pilih jawaban yang benar.',
            'options' => ['Benar', 'Salah'],
            'correct_answer' => 'Benar',
            'order' => 1,
        ]);

        if ($enrolled) {
            UserCourse::create([
                'user_id' => $student->id,
                'course_id' => $course->id,
                'purchased_at' => now(),
                'is_completed' => false,
                'current_content_id' => 'question:' . $question->id,
            ]);
        }

        return [$student, $course, $question];
    }
}
