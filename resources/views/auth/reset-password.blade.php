@extends('layouts.login')

@section('title', 'Reset Password')

@section('content')
<div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8">

    <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">
        Reset Password
    </h2>

    <p class="text-center text-gray-600 mb-6">
        Masukkan password baru untuk akun Anda
    </p>

    {{-- Error Message --}}
    @if(session('error'))
        <div class="mb-4 rounded-lg bg-red-100 text-red-700 px-4 py-3 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('reset.password') }}" method="POST" class="space-y-4">
        @csrf

        {{-- Password --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Password Baru
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

        {{-- Password Confirmation --}}
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
            Reset Password
        </button>
    </form>

</div>
@endsection
