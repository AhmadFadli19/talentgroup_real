<?php

namespace App\Http\Controllers;

use App\Mail\OTPMail;
use App\Models\User;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.login');
    }

    public function showLoginDashboard()
    {
        return $this->showLogin();
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|unique:users',
            'password' => 'required|min:8|confirmed',
            'verification_method' => 'required|in:email,whatsapp',
        ]);

        $code = rand(100000, 999999);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'email_verification_code' => $code,
            'role_id' => 2, // Default user
        ]);

        $method = $request->input('verification_method', 'email');
        session(['verify_method' => $method]);

        if ($method === 'email') {
            Mail::to($user->email)->send(new OTPMail($code, 'verification'));
            $msg = 'Kode verifikasi telah dikirim ke email Anda.';
        } else {
            if ($user->phone) {
                $waMsg = "Halo {$user->name},\n\nKode verifikasi akun talentgroup.id Anda adalah: *{$code}*.\n\nMasukkan kode ini di halaman verifikasi untuk mengaktifkan akun Anda. Jangan bagikan kode ini kepada siapapun.";
                WhatsAppService::sendMessage($user->phone, $waMsg);
            }
            $msg = 'Kode verifikasi telah dikirim ke nomor WhatsApp Anda.';
        }

        session(['verify_user_id' => $user->id]);

        return redirect()->route('verify.show')->with('success', $msg);
    }

    public function showVerify()
    {
        if (! session('verify_user_id')) {
            return redirect()->route('register')->with('error', 'Silakan register terlebih dahulu.');
        }

        return view('auth.verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric|digits:6',
        ]);

        $user = User::find(session('verify_user_id'));

        if (! $user) {
            return back()->with('error', 'User tidak ditemukan.');
        }

        if ($user->email_verification_code != $request->code) {
            return back()->with('error', 'Kode verifikasi salah.');
        }

        $user->update([
            'email_verified_at' => now(),
            'email_verification_code' => null,
        ]);

        Auth::login($user, true);
        session()->forget('verify_user_id');

        return redirect()->route('user.dashboard')->with('success', 'Email berhasil diverifikasi!');
    }

    public function resendCode()
    {
        $user = User::find(session('verify_user_id'));

        if (! $user) {
            return back()->with('error', 'User tidak ditemukan.');
        }

        $code = rand(100000, 999999);
        $user->update(['email_verification_code' => $code]);

        $method = session('verify_method', 'email');

        if ($method === 'email') {
            Mail::to($user->email)->send(new OTPMail($code, 'verification'));
            $msg = 'Kode verifikasi baru telah dikirim ke email Anda.';
        } else {
            if ($user->phone) {
                $waMsg = "Halo {$user->name},\n\nKode verifikasi baru akun talentgroup.id Anda adalah: *{$code}*.\n\nJangan bagikan kode ini kepada siapapun.";
                WhatsAppService::sendMessage($user->phone, $waMsg);
            }
            $msg = 'Kode verifikasi baru telah dikirim ke WhatsApp Anda.';
        }

        return back()->with('success', $msg);
    }

    // ==================== LOGIN SPLIT ====================
    public function showLoginAdmin()
    {
        return $this->showLogin();
    }

    public function showLoginUser()
    {
        return $this->showLogin();
    }

    public function showBankLogin()
    {
        return view('auth.bank-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ], [
            'login.required' => 'Email atau Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($loginType, $request->login)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return back()->withInput($request->only('login'))->with('error', 'Username/Email atau password salah.');
        }

        // Email verification only required for regular users (role_id 2)
        if ($user->role_id == 2 && ! $user->email_verified_at) {
            session(['verify_user_id' => $user->id]);

            return redirect()->route('verify.show')->with('error', 'Silakan verifikasi email Anda terlebih dahulu.');
        }

        // Default persistent login to 1 week unless explicitly turned off
        $remember = $request->has('remember') ? $request->boolean('remember') : true;
        Auth::login($user, $remember);

        return $this->redirectBasedOnRole($user);
    }

    public function loginAdmin(Request $request)
    {
        return $this->login($request);
    }

    public function loginUser(Request $request)
    {
        return $this->login($request);
    }

    // ==================== BANK LOGIN (FIXED: Tambah method ini) ====================
    public function loginBank(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($loginType, $request->login)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Username/Email atau password salah.');
        }

        if ($user->role_id != 4) {
            return back()->with('error', 'Anda tidak memiliki akses bank.');
        }

        Auth::login($user, true);

        return redirect()->route('bank.dashboard');
    }

    // ==================== FORGOT PASSWORD ====================
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetCode(Request $request)
    {
        $request->validate([
            'phone' => 'required|exists:users,phone',
            'method' => 'required|in:email,whatsapp',
        ]);

        $user = User::where('phone', $request->phone)->first();
        $code = rand(100000, 999999);

        $user->update([
            'reset_code' => $code,
            'reset_code_expired_at' => now()->addMinutes(10),
        ]);

        if ($request->method === 'email') {
            Mail::to($user->email)->send(new OTPMail($code, 'reset'));
            $message = 'Kode reset password telah dikirim ke email Anda.';
        } else {
            // WhatsApp Reset Password Delivery
            $waMsg = "Halo {$user->name},\n\nKode verifikasi untuk reset password akun talentgroup.id Anda adalah: *{$code}*.\n\nKode ini berlaku selama 10 menit. Jangan bagikan kode ini kepada siapapun.";
            $waResult = WhatsAppService::sendMessage($user->phone, $waMsg);

            $message = 'Kode reset password telah dikirim ke nomor WhatsApp Anda.';
            if (! $waResult['success']) {
                $message .= ' (Catatan: '.$waResult['message'].')';
            }
        }

        session(['reset_user_id' => $user->id]);

        return redirect()->route('reset.verify.show')->with('success', $message);
    }

    public function showResetVerify()
    {
        if (! session('reset_user_id')) {
            return redirect()->route('forgot.password')->with('error', 'Silakan masukkan nomor telepon terlebih dahulu.');
        }

        return view('auth.reset-verify');
    }

    public function verifyResetCode(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric|digits:6',
        ]);

        $user = User::find(session('reset_user_id'));

        if (! $user) {
            return back()->with('error', 'User tidak ditemukan.');
        }

        if ($user->reset_code != $request->code) {
            return back()->with('error', 'Kode salah.');
        }

        if (now()->greaterThan($user->reset_code_expired_at)) {
            return back()->with('error', 'Kode sudah kadaluarsa.');
        }

        return redirect()->route('reset.password.show');
    }

    public function showResetPassword()
    {
        if (! session('reset_user_id')) {
            return redirect()->route('forgot.password');
        }

        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::find(session('reset_user_id'));

        if (! $user) {
            return back()->with('error', 'User tidak ditemukan.');
        }

        $user->update([
            'password' => Hash::make($request->password),
            'reset_code' => null,
            'reset_code_expired_at' => null,
        ]);

        session()->forget('reset_user_id');

        return redirect()->route('login')->with('success', 'Password berhasil direset!');
    }

    // ==================== GOOGLE OAUTH ====================
    public function redirectToGoogle(Request $request)
    {
        try {
            $clientId = config('services.google.client_id') ?: env('GOOGLE_CLIENT_ID');
            $clientSecret = config('services.google.client_secret') ?: env('GOOGLE_CLIENT_SECRET');
            $redirectUri = config('services.google.redirect') ?: env('GOOGLE_REDIRECT_URI');

            if (empty($redirectUri)) {
                $redirectUri = url('/auth/google/callback');
            }

            if (empty($clientId) || empty($clientSecret)) {
                return redirect()->route('login')->with('error', 'Google Client ID atau Client Secret belum diatur di file .env server. Silakan hubungi administrator.');
            }

            // Memulai login Google berarti pengguna ingin memilih akun lagi.
            // Bersihkan autentikasi hanya di perangkat ini agar akun dari cookie
            // "remember me" tidak terbawa tanpa memutus perangkat lain.
            if (Auth::check()) {
                Auth::logoutCurrentDevice();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }

            // 1. Jika Socialite terpasang di vendor, gunakan Socialite
            if (class_exists(Socialite::class)) {
                return Socialite::driver('google')
                    ->with(['prompt' => 'select_account'])
                    ->redirect();
            }

            // 2. Fallback Mandiri (Native Google OAuth 2.0 tanpa dependensi Socialite)
            $state = Str::random(40);
            $request->session()->put('oauth_state', $state);

            $query = http_build_query([
                'client_id' => $clientId,
                'redirect_uri' => $redirectUri,
                'response_type' => 'code',
                'scope' => 'openid profile email',
                'state' => $state,
                'access_type' => 'offline',
                'prompt' => 'select_account',
            ]);

            return redirect()->away('https://accounts.google.com/o/oauth2/v2/auth?'.$query);
        } catch (\Throwable $e) {
            Log::error('Google OAuth Redirect Error: '.$e->getMessage(), [
                'exception' => $e,
            ]);

            return redirect()->route('login')->with('error', 'Login Google sedang tidak dapat dimulai. Silakan coba kembali.');
        }
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            if ($request->has('error')) {
                return redirect()->route('login')->with('error', 'Login Google dibatalkan: '.$request->error);
            }

            if (! $request->has('code')) {
                return redirect()->route('login')->with('error', 'Kode otorisasi Google tidak ditemukan.');
            }

            // 1. Gunakan Socialite bila tersedia. State tidak boleh dilewati karena
            // berfungsi melindungi callback OAuth dari request yang tidak sah.
            if (class_exists(Socialite::class)) {
                try {
                    $googleUser = Socialite::driver('google')->user();
                } catch (InvalidStateException $e) {
                    Log::warning('Google OAuth state verification failed.', [
                        'ip' => $request->ip(),
                    ]);

                    return redirect()->route('login')->with(
                        'error',
                        'Sesi login Google sudah kedaluwarsa atau berubah. Silakan klik "Lanjutkan dengan Google" sekali lagi.'
                    );
                }
            } else {
                // 2. Fallback mandiri hanya dipakai bila package Socialite memang tidak tersedia.
                $expectedState = (string) $request->session()->pull('oauth_state', '');
                $returnedState = (string) $request->query('state', '');

                if ($expectedState === '' || $returnedState === '' || ! hash_equals($expectedState, $returnedState)) {
                    Log::warning('Native Google OAuth state verification failed.', [
                        'ip' => $request->ip(),
                    ]);

                    return redirect()->route('login')->with(
                        'error',
                        'Sesi login Google tidak valid. Silakan mulai login Google kembali.'
                    );
                }

                $clientId = config('services.google.client_id') ?: env('GOOGLE_CLIENT_ID');
                $clientSecret = config('services.google.client_secret') ?: env('GOOGLE_CLIENT_SECRET');
                $redirectUri = config('services.google.redirect') ?: env('GOOGLE_REDIRECT_URI');

                if (empty($redirectUri)) {
                    $redirectUri = url('/auth/google/callback');
                }

                $tokenResponse = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'code' => $request->code,
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => $redirectUri,
                ]);

                if (! $tokenResponse->successful()) {
                    Log::error('Google Token Exchange Failed.', [
                        'status' => $tokenResponse->status(),
                        'response' => $tokenResponse->body(),
                    ]);

                    return redirect()->route('login')->with('error', 'Autentikasi Google gagal. Silakan coba kembali.');
                }

                $accessToken = $tokenResponse->json('access_token');
                $userResponse = Http::withToken($accessToken)->get('https://www.googleapis.com/oauth2/v3/userinfo');

                if (! $userResponse->successful()) {
                    Log::error('Google Userinfo Failed.', [
                        'status' => $userResponse->status(),
                        'response' => $userResponse->body(),
                    ]);

                    return redirect()->route('login')->with('error', 'Gagal mengambil data profil dari akun Google.');
                }

                $userData = $userResponse->json();
                $googleUser = (object) [
                    'id' => $userData['sub'] ?? null,
                    'name' => $userData['name'] ?? 'Pengguna Google',
                    'email' => $userData['email'] ?? null,
                    'avatar' => $userData['picture'] ?? null,
                ];
            }

            $googleId = method_exists($googleUser, 'getId') ? $googleUser->getId() : ($googleUser->id ?? null);
            $googleName = method_exists($googleUser, 'getName') ? $googleUser->getName() : ($googleUser->name ?? null);
            $googleEmail = method_exists($googleUser, 'getEmail') ? $googleUser->getEmail() : ($googleUser->email ?? null);
            $googleAvatar = method_exists($googleUser, 'getAvatar') ? $googleUser->getAvatar() : ($googleUser->avatar ?? null);

            $googleId = trim((string) $googleId);
            $googleName = trim((string) ($googleName ?: 'Pengguna Google'));
            $googleEmail = mb_strtolower(trim((string) $googleEmail));

            if ($googleId === '' || ! filter_var($googleEmail, FILTER_VALIDATE_EMAIL)) {
                return redirect()->route('login')->with('error', 'Gagal mendapatkan data akun dari Google.');
            }

            $user = DB::transaction(function () use ($googleId, $googleName, $googleEmail, $googleAvatar) {
                // Akun yang sudah ditautkan selalu menjadi prioritas.
                $user = User::where('google_id', $googleId)->lockForUpdate()->first();

                if ($user) {
                    $user->update([
                        'avatar' => $googleAvatar ?: $user->avatar,
                        'email_verified_at' => $user->email_verified_at ?: now(),
                    ]);

                    return $user;
                }

                // Cocokkan email tanpa membedakan huruf besar/kecil untuk akun lama.
                $existingUser = User::whereRaw('LOWER(email) = ?', [$googleEmail])
                    ->lockForUpdate()
                    ->first();

                if ($existingUser) {
                    if ($existingUser->google_id && $existingUser->google_id !== $googleId) {
                        throw new \RuntimeException('Email akun sudah terhubung dengan identitas Google lain.');
                    }

                    $existingUser->update([
                        'google_id' => $googleId,
                        'avatar' => $googleAvatar ?: $existingUser->avatar,
                        'email_verified_at' => $existingUser->email_verified_at ?: now(),
                    ]);

                    return $existingUser;
                }

                // Pendaftaran akun baru via Google. Nomor telepon boleh dilengkapi nanti.
                $baseUsername = Str::slug($googleName, '_') ?: 'user';
                $username = $baseUsername;

                while (User::where('username', $username)->exists()) {
                    $username = $baseUsername.'_'.Str::lower(Str::random(6));
                }

                return User::create([
                    'name' => $googleName,
                    'username' => $username,
                    'email' => $googleEmail,
                    'phone' => null,
                    'google_id' => $googleId,
                    'avatar' => $googleAvatar,
                    'role_id' => 2,
                    'email_verified_at' => now(),
                    'password' => Hash::make(Str::random(32)),
                ]);
            }, 3);

            Auth::login($user, true);
            $request->session()->regenerate();

            return $this->redirectBasedOnRole($user);

        } catch (\Throwable $e) {
            Log::error('Google OAuth Error: '.$e->getMessage(), [
                'exception' => $e,
            ]);

            return redirect()->route('login')->with('error', 'Terjadi kendala saat masuk dengan Google. Silakan coba kembali.');
        }
    }

    private function redirectBasedOnRole($user)
    {
        if ($user->role_id == 1 || (method_exists($user, 'isAdmin') && $user->isAdmin())) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role_id == 2) {
            return redirect()->route('user.dashboard');
        } elseif ($user->role_id == 3) {
            return redirect()->route('developer.dashboard');
        } elseif ($user->role_id == 4) {
            return redirect()->route('bank.dashboard');
        }

        return redirect()->route('user.dashboard');
    }

    // ==================== LOGOUT ====================
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
