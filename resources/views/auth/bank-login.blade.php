@extends('layouts.login')

@section('title', 'Bank Login')

@section('content')
<div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8">

    {{-- Header --}}
    <div class="text-center mb-6">
        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-blue-100">
            <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-2 0H7m5 0v-5a2 2 0 00-2-2H8a2 2 0 00-2 2v5m5 0V9a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h3m5-1V2a1 1 0 00-1-1H9a1 1 0 00-1 1v3m5 14h3m-3 0h-3m-3 0H5"/>
            </svg>
        </div>

        <h2 class="text-2xl font-bold text-gray-800">Bank Login</h2>
        <p class="mt-2 text-gray-600">Access Bank Management System</p>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-100 px-4 py-3 text-sm text-red-700">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Login Form --}}
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        {{-- Email --}}
        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">
                Email
            </label>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Enter your bank email"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-2
                focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>

        {{-- Password --}}
        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">
                Password
            </label>
            <input
                type="password"
                name="password"
                placeholder="Enter your password"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-2
                focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>

        <button
            type="submit"
            class="w-full rounded-lg bg-blue-600 py-2.5 font-semibold text-white
            hover:bg-blue-700 transition"
        >
            Login to Bank System
        </button>
    </form>

    {{-- Demo Info --}}
    <div class="mt-6 rounded-lg bg-blue-50 p-4 text-sm text-blue-800">
        <h3 class="mb-2 font-semibold">Demo Bank Accounts</h3>
        <ul class="space-y-1">
            <li><strong>Bank Officer:</strong> bank@example.com</li>
            <li><strong>Bank Manager:</strong> manager@example.com</li>
            <li><strong>Password:</strong> password</li>
        </ul>
    </div>

    {{-- Back Link --}}
    <div class="mt-6 text-center text-sm">
        <a href="{{ route('login') }}" class="text-blue-600 hover:underline">
            ← Back to regular login
        </a>
    </div>

</div>
@endsection
