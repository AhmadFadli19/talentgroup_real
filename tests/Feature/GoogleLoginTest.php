<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Laravel\Socialite\Two\User as SocialiteUser;
use Mockery;
use Tests\TestCase;

class GoogleLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_starting_google_login_clears_only_the_current_device_session(): void
    {
        $this->createUserRole();

        $user = $this->createUser([
            'name' => 'Remembered User',
            'username' => 'remembered_user',
            'email' => 'remembered@example.com',
            'phone' => '080000000000',
        ]);
        $user->forceFill(['remember_token' => 'token-for-other-devices'])->save();

        config([
            'services.google.client_id' => 'test-client-id',
            'services.google.client_secret' => 'test-client-secret',
            'services.google.redirect' => 'https://example.com/auth/google/callback',
        ]);

        $provider = Mockery::mock();
        $provider->shouldReceive('with')
            ->once()
            ->with(['prompt' => 'select_account'])
            ->andReturnSelf();
        $provider->shouldReceive('redirect')
            ->once()
            ->andReturn(new RedirectResponse('https://accounts.google.com/o/oauth2/v2/auth'));

        Socialite::shouldReceive('driver')
            ->once()
            ->with('google')
            ->andReturn($provider);

        $response = $this->actingAs($user)->get(route('auth.google'));

        $response->assertRedirect('https://accounts.google.com/o/oauth2/v2/auth');
        $this->assertGuest();
        $this->assertSame('token-for-other-devices', $user->fresh()->remember_token);
    }

    public function test_existing_google_account_replaces_a_stale_authenticated_session(): void
    {
        $this->createUserRole();

        $staleUser = $this->createUser([
            'name' => 'Akun Lama',
            'username' => 'akun_lama',
            'email' => 'lama@example.com',
            'phone' => '081111111111',
        ]);

        $googleUser = $this->createUser([
            'name' => 'Akun Google',
            'username' => 'akun_google',
            'email' => 'google@example.com',
            'phone' => '082222222222',
            'google_id' => 'google-user-123',
        ]);

        $this->mockGoogleUser('google-user-123', 'Akun Google', 'google@example.com');

        $response = $this
            ->actingAs($staleUser)
            ->get(route('auth.google.callback', ['code' => 'valid-code']));

        $response->assertRedirect(route('user.dashboard'));
        $this->assertAuthenticatedAs($googleUser);
    }

    public function test_google_login_links_an_existing_email_case_insensitively(): void
    {
        $this->createUserRole();

        $existingUser = $this->createUser([
            'name' => 'Existing User',
            'username' => 'existing_user',
            'email' => 'Existing@Example.com',
            'phone' => '083333333333',
            'google_id' => null,
        ]);

        $this->mockGoogleUser('google-user-456', 'Existing User', 'existing@example.com');

        $response = $this->get(route('auth.google.callback', ['code' => 'valid-code']));

        $response->assertRedirect(route('user.dashboard'));
        $this->assertAuthenticatedAs($existingUser);
        $this->assertDatabaseHas('users', [
            'id' => $existingUser->id,
            'google_id' => 'google-user-456',
        ]);
    }

    public function test_new_google_account_can_be_created_without_a_phone_number(): void
    {
        $this->createUserRole();
        $this->mockGoogleUser('google-user-789', 'Pengguna Baru', 'baru@example.com');

        $response = $this->get(route('auth.google.callback', ['code' => 'valid-code']));

        $response->assertRedirect(route('user.dashboard'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'baru@example.com',
            'phone' => null,
            'google_id' => 'google-user-789',
            'role_id' => 2,
        ]);
    }

    public function test_invalid_oauth_state_is_rejected_without_stateless_fallback(): void
    {
        $provider = Mockery::mock();
        $provider->shouldReceive('user')
            ->once()
            ->andThrow(new InvalidStateException);

        Socialite::shouldReceive('driver')
            ->once()
            ->with('google')
            ->andReturn($provider);

        $response = $this->get(route('auth.google.callback', ['code' => 'expired-code']));

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error', function (string $message) {
            return str_contains($message, 'kedaluwarsa');
        });
        $this->assertGuest();
    }

    private function mockGoogleUser(string $id, string $name, string $email): void
    {
        $provider = Mockery::mock();
        $provider->shouldReceive('user')
            ->once()
            ->andReturn((new SocialiteUser)->map([
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'avatar' => 'https://example.com/avatar.png',
            ]));

        Socialite::shouldReceive('driver')
            ->once()
            ->with('google')
            ->andReturn($provider);
    }

    private function createUserRole(): void
    {
        DB::table('roles')->insert([
            'id' => 2,
            'name' => 'user',
            'display_name' => 'User',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function createUser(array $attributes): User
    {
        return User::create(array_merge([
            'password' => 'password',
            'role_id' => 2,
            'email_verified_at' => now(),
        ], $attributes));
    }
}
