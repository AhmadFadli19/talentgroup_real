<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'TalentGroup')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg" x-data="{ open: false, dropdownOpen: false }">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="text-xl font-bold text-gray-800">
                    TalentGroup
                </a>

                <!-- Burger Icon -->
                <div class="md:hidden">
                    <button @click="open = !open" class="text-gray-700 focus:outline-none">
                        <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Menu Items -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                                class="text-gray-700 hover:text-blue-600 {{ request()->routeIs('admin.dashboard') ? 'text-blue-600 font-medium' : '' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('admin-content') }}"
                                class="text-gray-700 hover:text-blue-600 {{ request()->routeIs('admin-content') ? 'text-blue-600 font-medium' : '' }}">
                                Add Content
                            </a>
                            <a href="{{ route('admin.courses.index') }}"
                                class="text-gray-700 hover:text-blue-600 {{ request()->routeIs('admin.courses.*') ? 'text-blue-600 font-medium' : '' }}">
                                Manage Courses
                            </a>
                        @else
                            <a href="{{ route('user.dashboard') }}" class="text-gray-700 hover:text-blue-600">
                                Dashboard
                            </a>
                            <a href="{{ route('user.courses.index') }}" class="text-gray-700 hover:text-blue-600">
                                Kursus
                            </a>
                            <a href="{{ route('user.my-courses') }}" class="text-gray-700 hover:text-blue-600">
                                Kursus Saya
                            </a>
                            <span class="text-gray-700">
                                Saldo: Rp {{ number_format(auth()->user()->balance, 0, ',', '.') }}
                            </span>
                        @endif

                        <!-- Dropdown -->
                        <div class="relative" @click.away="dropdownOpen = false">
                            <button @click="dropdownOpen = !dropdownOpen"
                                class="flex items-center text-gray-700 hover:text-blue-600">
                                {{ auth()->user()->name }}
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="dropdownOpen"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                    @endauth
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="md:hidden mt-2" x-show="open" @click.away="open = false">
                <div class="flex flex-col space-y-2 py-2 border-t">
                    @auth
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                                class="px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                            <a href="{{ route('admin.courses.index') }}"
                                class="px-4 py-2 text-gray-700 hover:bg-gray-100">Manage Courses</a>
                        @else
                            <a href="{{ route('user.dashboard') }}"
                                class="px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                            <a href="{{ route('user.courses.index') }}"
                                class="px-4 py-2 text-gray-700 hover:bg-gray-100">Kursus</a>
                            <a href="{{ route('user.my-courses') }}"
                                class="px-4 py-2 text-gray-700 hover:bg-gray-100">Kursus Saya</a>
                            <span class="px-4 text-gray-700">
                                Saldo: Rp {{ number_format(auth()->user()->balance, 0, ',', '.') }}
                            </span>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="px-4">
                            @csrf
                            <button type="submit"
                                class="w-full text-left py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-gray-700 hover:bg-gray-100">Login</a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 text-gray-700 hover:bg-gray-100">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; 2025 TalentGroup. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
