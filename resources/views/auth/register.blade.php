@extends('layouts.login')

@section('title', 'Register')

@section('content')
<div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8">

    <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">
        Buat Akun Baru
    </h2>

    <p class="text-center text-gray-600 mb-6">
        Silakan isi data di bawah untuk mendaftar
    </p>

    {{-- Error Message --}}
    @if(session('error'))
        <div class="mb-4 rounded-lg bg-red-100 text-red-700 px-4 py-3 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST" class="space-y-4">
        @csrf

        {{-- Nama --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Nama Lengkap
            </label>
            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-2
                focus:outline-none focus:ring-2 focus:ring-indigo-500
                @error('name') border-red-500 focus:ring-red-500 @enderror"
            >
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Username --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Username
            </label>
            <input
                type="text"
                name="username"
                value="{{ old('username') }}"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-2
                focus:outline-none focus:ring-2 focus:ring-indigo-500
                @error('username') border-red-500 focus:ring-red-500 @enderror"
            >
            @error('username')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Email
            </label>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-2
                focus:outline-none focus:ring-2 focus:ring-indigo-500
                @error('email') border-red-500 focus:ring-red-500 @enderror"
            >
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Phone --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Nomor Telepon
            </label>
            <input
                type="text"
                name="phone"
                value="{{ old('phone') }}"
                placeholder="+628123456789"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-2
                focus:outline-none focus:ring-2 focus:ring-indigo-500
                @error('phone') border-red-500 focus:ring-red-500 @enderror"
            >
            @error('phone')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Password
            </label>
            <input
                type="password"
                name="password"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-2
                focus:outline-none focus:ring-2 focus:ring-indigo-500
                @error('password') border-red-500 focus:ring-red-500 @enderror"
            >
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Konfirmasi Password
            </label>
            <input
                type="password"
                name="password_confirmation"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-2
                focus:outline-none focus:ring-2 focus:ring-indigo-500"
            >
        </div>

        <button
            type="submit"
            class="w-full rounded-lg bg-indigo-600 py-2.5 font-semibold text-white
            hover:bg-indigo-700 transition duration-200"
        >
            Register
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-600">
        Sudah punya akun?
        <a href="{{ route('login.user') }}" class="font-semibold text-indigo-600 hover:underline">
            Login
        </a>
    </p>

</div>
@endsection
