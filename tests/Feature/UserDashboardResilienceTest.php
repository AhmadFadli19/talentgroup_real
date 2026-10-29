<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UserDashboardResilienceTest extends TestCase
{
    use DatabaseMigrations;

    public function test_dashboard_ignores_enrollments_whose_course_no_longer_exists(): void
    {
        DB::table('roles')->insert([
            'id' => 2,
            'name' => 'user',
            'display_name' => 'User',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = User::create([
            'name' => 'Google User',
            'username' => 'google_user',
            'email' => 'google@example.com',
            'phone' => null,
            'password' => 'password',
            'role_id' => 2,
            'google_id' => 'google-123',
            'email_verified_at' => now(),
        ]);

        Schema::disableForeignKeyConstraints();
        DB::table('user_courses')->insert([
            'user_id' => $user->id,
            'course_id' => 999999,
            'purchased_at' => now(),
            'is_completed' => false,
            'current_content_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Schema::enableForeignKeyConstraints();

        $response = $this->actingAs($user)->get(route('user.dashboard'));

        $response->assertOk();
        $response->assertSee('Belum Mengikuti Kursus');
    }

    public function test_profile_uses_histori_kegiatan_wording(): void
    {
        DB::table('roles')->insert([
            'id' => 2,
            'name' => 'user',
            'display_name' => 'User',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = User::create([
            'name' => 'Profile User',
            'username' => 'profile_user',
            'email' => 'profile@example.com',
            'phone' => '081234567890',
            'password' => 'password',
            'role_id' => 2,
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('user.profile'));

        $response->assertOk();
        $response->assertSee('Histori Kegiatan');
        $response->assertDontSee('Riwayat Transaksi');
    }
}
