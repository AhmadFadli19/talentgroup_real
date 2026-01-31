@extends('layouts.login')

@section('title', 'Login User')

@section('content')
<div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8">

    <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">
        Login User
    </h2>

    <p class="text-center text-gray-600 mb-6">
        Masuk menggunakan email
    </p>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-100 text-green-700 px-4 py-3 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
        <div class="mb-4 rounded-lg bg-red-100 text-red-700 px-4 py-3 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('login.user') }}" method="POST" class="space-y-4">
        @csrf

        {{-- Username / Email --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Email
            </label>
            <input
                type="text"
                name="login"
                value="{{ old('login') }}"
                required
                autofocus
                class="w-full rounded-lg border border-gray-300 px-4 py-2
                focus:outline-none focus:ring-2 focus:ring-indigo-500
                @error('login') border-red-500 focus:ring-red-500 @enderror"
            >
            @error('login')
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

        <button
            type="submit"
            class="w-full rounded-lg bg-indigo-600 py-2.5 font-semibold text-white
            hover:bg-indigo-700 transition"
        >
            Login
        </button>
    </form>

    {{-- Links --}}
    <div class="mt-6 space-y-3 text-center text-sm text-gray-600">

        <p>
            <a href="{{ route('forgot.password') }}" class="text-indigo-600 hover:underline">
                Lupa Password?
            </a>
        </p>

        <p>
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:underline">
                Register
            </a>
        </p>

        <hr class="my-2">

        <p>
            <a href="{{ route('login.admin') }}" class="text-gray-500 hover:underline">
                Login sebagai Admin
            </a>
        </p>
    </div>

</div>
@endsection
