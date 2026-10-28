<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\CourseQuestion;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\FigmaPracticeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FigmaPracticeSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_an_idempotent_figma_practice_set_with_three_levels(): void
    {
        $adminRole = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'Administrator',
        ]);

        $admin = User::create([
            'name' => 'Admin Test',
            'username' => 'admin-test',
            'email' => 'admin-test@example.com',
            'phone' => '081234567890',
            'password' => 'password',
            'role_id' => $adminRole->id,
        ]);

        $this->seed(FigmaPracticeSeeder::class);
        $this->seed(FigmaPracticeSeeder::class);

        $course = Course::where('title', 'Latihan Figma: Dasar hingga Lanjutan')->firstOrFail();

        $this->assertSame(0.0, (float) $course->price);
        $this->assertTrue($course->is_active);
        $this->assertFalse($course->isShuffleQuestions());
        $this->assertTrue($course->isShuffleOptions());
        $this->assertSame(15, $course->questions()->count());
        $this->assertSame(5, $course->questions()->where('difficulty', 'beginner')->count());
        $this->assertSame(5, $course->questions()->where('difficulty', 'intermediate')->count());
        $this->assertSame(5, $course->questions()->where('difficulty', 'advanced')->count());

        $course->questions->each(function (CourseQuestion $question): void {
            $this->assertContains($question->correct_answer, $question->options);
        });

        $this->actingAs($admin)
            ->get(route('admin.practice-questions.index'))
            ->assertOk()
            ->assertSee('Kelola Latihan Soal')
            ->assertSee('Latihan Figma: Dasar hingga Lanjutan');
    }
}
