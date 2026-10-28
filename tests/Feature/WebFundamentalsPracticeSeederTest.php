<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\CourseQuestion;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\WebFundamentalsPracticeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebFundamentalsPracticeSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_balanced_idempotent_web_practice_set(): void
    {
        $adminRole = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'Administrator',
        ]);

        User::create([
            'name' => 'Admin Test',
            'username' => 'admin-web-test',
            'email' => 'admin-web-test@example.com',
            'phone' => '081234567891',
            'password' => 'password',
            'role_id' => $adminRole->id,
        ]);

        $this->seed(WebFundamentalsPracticeSeeder::class);
        $this->seed(WebFundamentalsPracticeSeeder::class);

        $course = Course::where('title', 'Latihan HTML, CSS & JavaScript')->firstOrFail();

        $this->assertSame(0.0, (float) $course->price);
        $this->assertTrue($course->is_active);
        $this->assertFalse($course->isShuffleQuestions());
        $this->assertTrue($course->isShuffleOptions());
        $this->assertSame('tg/assets/quiz-web-fundamentals.png', $course->image);
        $this->assertStringEndsWith('/tg/assets/quiz-web-fundamentals.png', $course->image_url);
        $this->assertSame(30, $course->questions()->count());
        $this->assertSame(10, $course->questions()->where('difficulty', 'beginner')->count());
        $this->assertSame(10, $course->questions()->where('difficulty', 'intermediate')->count());
        $this->assertSame(10, $course->questions()->where('difficulty', 'advanced')->count());

        $course->questions->each(function (CourseQuestion $question): void {
            $this->assertContains($question->correct_answer, $question->options);
            $this->assertCorrectAnswerIsNotTheOnlyLongestOption($question);
        });
    }

    private function assertCorrectAnswerIsNotTheOnlyLongestOption(CourseQuestion $question): void
    {
        $lengths = array_map(fn (string $option): int => mb_strlen($option), $question->options);
        $correctLength = mb_strlen($question->correct_answer);
        $longestLength = max($lengths);
        $longestCount = count(array_filter($lengths, fn (int $length): bool => $length === $longestLength));

        $this->assertFalse(
            $correctLength === $longestLength && $longestCount === 1,
            "Jawaban benar soal '{$question->title}' tidak boleh menjadi satu-satunya opsi terpanjang."
        );
    }
}
