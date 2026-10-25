<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\OTPMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Services\WhatsAppService;

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
        if (!session('verify_user_id')) {
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

        if (!$user) {
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

        if (!$user) {
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

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withInput($request->only('login'))->with('error', 'Username/Email atau password salah.');
        }

        // Email verification only required for regular users (role_id 2)
        if ($user->role_id == 2 && !$user->email_verified_at) {
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

        if (!$user || !Hash::check($request->password, $user->password)) {
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
            if (!$waResult['success']) {
                $message .= ' (Catatan: ' . $waResult['message'] . ')';
            }
        }

        session(['reset_user_id' => $user->id]);

        return redirect()->route('reset.verify.show')->with('success', $message);
    }

    public function showResetVerify()
    {
        if (!session('reset_user_id')) {
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

        if (!$user) {
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
        if (!session('reset_user_id')) {
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

        if (!$user) {
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

            // 1. Jika Socialite terpasang di vendor, gunakan Socialite
            if (class_exists('\Laravel\Socialite\Facades\Socialite')) {
                return \Laravel\Socialite\Facades\Socialite::driver('google')->redirect();
            }

            // 2. Fallback Mandiri (Native Google OAuth 2.0 tanpa dependensi Socialite)
            $state = Str::random(40);
            session(['oauth_state' => $state]);

            $query = http_build_query([
                'client_id' => $clientId,
                'redirect_uri' => $redirectUri,
                'response_type' => 'code',
                'scope' => 'openid profile email',
                'state' => $state,
                'access_type' => 'offline',
                'prompt' => 'select_account',
            ]);

            return redirect()->away('https://accounts.google.com/o/oauth2/v2/auth?' . $query);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Google OAuth Redirect Error: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            return redirect()->route('login')->with('error', 'Gagal mengarahkan ke login Google: ' . $e->getMessage());
        }
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            if ($request->has('error')) {
                return redirect()->route('login')->with('error', 'Login Google dibatalkan: ' . $request->error);
            }

            if (!$request->has('code')) {
                return redirect()->route('login')->with('error', 'Kode otorisasi Google tidak ditemukan.');
            }

            $googleUser = null;

            // 1. Coba lewat Socialite jika package tersedia di vendor
            if (class_exists('\Laravel\Socialite\Facades\Socialite')) {
                try {
                    $googleUser = \Laravel\Socialite\Facades\Socialite::driver('google')->user();
                } catch (\Exception $stateException) {
                    \Illuminate\Support\Facades\Log::warning('Google OAuth state verification failed, falling back to stateless: ' . $stateException->getMessage());
                    try {
                        $googleUser = \Laravel\Socialite\Facades\Socialite::driver('google')->stateless()->user();
                    } catch (\Exception $e) {
                        $googleUser = null;
                    }
                }
            }

            // 2. Fallback Mandiri menggunakan HTTP Client bawaan Laravel (tanpa Socialite)
            if (!$googleUser || empty($googleUser->email)) {
                $clientId = config('services.google.client_id') ?: env('GOOGLE_CLIENT_ID');
                $clientSecret = config('services.google.client_secret') ?: env('GOOGLE_CLIENT_SECRET');
                $redirectUri = config('services.google.redirect') ?: env('GOOGLE_REDIRECT_URI');

                if (empty($redirectUri)) {
                    $redirectUri = url('/auth/google/callback');
                }

                $tokenResponse = \Illuminate\Support\Facades\Http::asForm()->post('https://oauth2.googleapis.com/token', [
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'code' => $request->code,
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => $redirectUri,
                ]);

                if (!$tokenResponse->successful()) {
                    \Illuminate\Support\Facades\Log::error('Google Token Exchange Failed: ' . $tokenResponse->body());
                    $errorDesc = $tokenResponse->json('error_description') ?: $tokenResponse->json('error') ?: 'Gagal autentikasi token';
                    return redirect()->route('login')->with('error', 'Gagal menukarkan token Google: ' . $errorDesc);
                }

                $accessToken = $tokenResponse->json('access_token');
                $userResponse = \Illuminate\Support\Facades\Http::withToken($accessToken)->get('https://www.googleapis.com/oauth2/v3/userinfo');

                if (!$userResponse->successful()) {
                    \Illuminate\Support\Facades\Log::error('Google Userinfo Failed: ' . $userResponse->body());
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

            if (!$googleUser || empty($googleUser->email)) {
                return redirect()->route('login')->with('error', 'Gagal mendapatkan data akun dari Google.');
            }

            // 1. User yang sudah terhubung dengan google_id
            $user = User::where('google_id', $googleUser->id)->first();

            if ($user) {
                Auth::login($user, true);
                return $this->redirectBasedOnRole($user);
            }

            // 2. User dengan email yang sama (sambungkan google_id)
            $existingUser = User::where('email', $googleUser->email)->first();

            if ($existingUser) {
                $existingUser->update([
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar ?: $existingUser->avatar,
                    'email_verified_at' => $existingUser->email_verified_at ?: now(),
                ]);

                Auth::login($existingUser, true);
                return $this->redirectBasedOnRole($existingUser);
            }

            // 3. Pendaftaran akun baru via Google
            $baseUsername = Str::slug($googleUser->name ?: 'user', '_');
            if (empty($baseUsername)) {
                $baseUsername = 'user';
            }
            $username = $baseUsername;
            while (User::where('username', $username)->exists()) {
                $username = $baseUsername . '_' . rand(100, 9999);
            }

            $newUser = User::create([
                'name' => $googleUser->name ?: 'Pengguna Google',
                'username' => $username,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
                'role_id' => 2, // Regular user secara default
                'email_verified_at' => now(), // Email Google otomatis terverifikasi
                'password' => Hash::make(Str::random(32)),
            ]);

            Auth::login($newUser, true);
            return $this->redirectBasedOnRole($newUser);

        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Google OAuth Error: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            return redirect()->route('login')->with('error', 'Terjadi kesalahan saat masuk dengan Google: ' . $e->getMessage());
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
