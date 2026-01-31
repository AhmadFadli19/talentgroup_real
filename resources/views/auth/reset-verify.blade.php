@extends('layouts.login')

@section('title', 'Verifikasi Kode Reset')

@section('content')
<div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8">

    <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">
        Verifikasi Kode
    </h2>

    <p class="text-center text-gray-600 mb-6">
        Masukkan kode yang telah dikirim ke email Anda
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

    {{-- Verify Form --}}
    <form action="{{ route('reset.verify') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Kode Reset (6 digit)
            </label>

        <input
            type="text"
            name="code"
            maxlength="6"
            required
            autofocus
            class="w-full rounded-lg border border-gray-300 px-4 py-2 text-center text-lg tracking-widest
            focus:outline-none focus:ring-2 focus:ring-indigo-500
            @error('code') border-red-500 focus:ring-red-500 @enderror"
        >

            @error('code')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button
            type="submit"
            class="w-full rounded-lg bg-indigo-600 py-2.5 font-semibold text-white
            hover:bg-indigo-700 transition duration-200"
        >
            Verifikasi
        </button>
    </form>

</div>
@endsection
