@extends('layouts.login')

@section('title', 'Lupa Password')

@section('content')
<div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8">

    <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">
        Lupa Password
    </h2>

    <p class="text-center text-gray-600 mb-6">
        Masukkan nomor telepon yang terdaftar untuk menerima kode reset
    </p>

    {{-- Error Message --}}
    @if(session('error'))
        <div class="mb-4 rounded-lg bg-red-100 text-red-700 px-4 py-3 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('forgot.password') }}" method="POST" class="space-y-4">
        @csrf

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

        {{-- Method --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Metode Pengiriman Kode
            </label>
            <select
                name="method"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-white
                focus:outline-none focus:ring-2 focus:ring-indigo-500
                @error('method') border-red-500 focus:ring-red-500 @enderror"
            >
                <option value="email">Email</option>
                {{-- <option value="whatsapp">WhatsApp</option> --}}
            </select>
            @error('method')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button
            type="submit"
            class="w-full rounded-lg bg-indigo-600 py-2.5 font-semibold text-white
            hover:bg-indigo-700 transition"
        >
            Kirim Kode
        </button>
    </form>

    <div class="mt-6 text-center text-sm text-gray-600">
        <a href="{{ route('login.user') }}" class="font-semibold text-indigo-600 hover:underline">
            Kembali ke Login
        </a>
    </div>

</div>
@endsection
