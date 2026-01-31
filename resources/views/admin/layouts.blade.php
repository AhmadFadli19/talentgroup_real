
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbor Keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @media (max-width: 768px) {
            .responsive-table {
                overflow-x: auto;
            }

            .sidebar-toggle {
                display: block;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                position: fixed;
                z-index: 50;
                height: 100vh;
            }

            .sidebar.open {
                transform: translateX(0);
            }
        }
    </style>
</head>

<body class="bg-gray-100 font-sans antialiased">
    <!-- Mobile Navigation Toggle -->
    <div class="lg:hidden fixed top-4 left-4 z-50">
        <button id="sidebar-toggle" class="bg-gray-800 text-white p-2 rounded-md shadow-md">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <div class="flex min-h-screen relative">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="sidebar bg-gray-800 text-white w-64 flex flex-col py-6 px-3 transition-all duration-300">
            <div class="text-xl font-semibold mb-8 px-2 flex items-center justify-between">
                <span>Aplikasi Uang Digital</span>
                <button id="sidebar-close" class="lg:hidden text-gray-300 hover:text-white">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="flex-grow">
                <ul>
                    <ul>
                        <li class="mb-2">
                            <a href="{{ route('admin-home') }}"
                                class="flex items-center py-2 px-4 rounded text-gray-300 hover:bg-gray-700 hover:text-white bg-gray-700 text-white">
                                <i class="fas fa-home mr-3"></i> Dasbor
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('admin-kelolaakun') }}"
                                class="flex items-center py-2 px-4 rounded text-gray-300 hover:bg-gray-700 hover:text-white">
                                <i class="fas fa-cog mr-3"></i> Kelola Akun
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('admin-content') }}"
                                class="flex items-center py-2 px-4 rounded text-gray-300 hover:bg-gray-700 hover:text-white">
                                <i class="fas fa-cog mr-3"></i> content
                            </a>
                        </li>
                    </ul>
                </ul>
            </nav>
            <div class="mt-auto">
                <ul>
                    <li>
                        <a href="{{ route('logout') }}"
                            class="flex items-center py-2 px-4 rounded text-gray-300 hover:bg-gray-700 hover:text-white">
                            @method('post')
                            @csrf
                            <i class="fas fa-sign-out-alt mr-3"></i> Keluar
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        @yield('content')


                <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

                <script>
                    // Toggle sidebar for mobile
                    document.getElementById('sidebar-toggle').addEventListener('click', function() {
                        document.getElementById('sidebar').classList.add('open');
                    });

                    document.getElementById('sidebar-close').addEventListener('click', function() {
                        document.getElementById('sidebar').classList.remove('open');
                    });

                    // Close sidebar when clicking outside on mobile
                    document.addEventListener('click', function(event) {
                        const sidebar = document.getElementById('sidebar');
                        const sidebarToggle = document.getElementById('sidebar-toggle');

                        if (window.innerWidth < 1024) {
                            if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target) && sidebar.classList
                                .contains('open')) {
                                sidebar.classList.remove('open');
                            }
                        }
                    });

                    // Ensure sidebar is visible on desktop
                    window.addEventListener('resize', function() {
                        if (window.innerWidth >= 1024) {
                            document.getElementById('sidebar').classList.remove('open');
                        }
                    });
                </script>
</body>

</html>
