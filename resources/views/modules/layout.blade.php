<!DOCTYPE html>
<html lang="id" class="dark scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dokumentasi Modul Belajar') | talentgroup.id</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Fira+Code:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS & FontAwesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        docbg: '#0b1120',
                        doccard: '#0f172a',
                        docborder: '#1e293b',
                        doccyan: '#38bdf8',
                        docsidebar: '#080d1a'
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                        mono: ['"Fira Code"', 'monospace'],
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* Base Dark Layout Styles matching Tailwind Docs */
        body {
            background-color: #0b1120;
            color: #cbd5e1;
            font-family: 'Outfit', sans-serif;
            overflow-x: hidden;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #080d1a;
        }
        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #334155;
        }

        /* Anti-Copy and Text Selection */
        .protected-content {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Anti-Print Protection */
        @media print {
            html, body {
                display: block !important;
                background: #000000 !important;
                background-color: #000000 !important;
                color: #000000 !important;
                filter: brightness(0) !important;
            }
            body * {
                display: none !important;
                visibility: hidden !important;
            }
        }

        /* Blackout Shield for Anti-Screenshot (Solid pure black across entire viewport) */
        #blackout-shield {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100vw !important;
            width: 100% !important;
            height: 100vh !important;
            height: 100dvh !important;
            background: #000000 !important;
            background-color: #000000 !important;
            z-index: 2147483647 !important; /* Highest possible 32-bit z-index */
            opacity: 0 !important;
            visibility: hidden !important;
            display: none !important;
            pointer-events: none !important;
            transition: none !important;
            -webkit-backdrop-filter: none !important;
            backdrop-filter: none !important;
            cursor: pointer;
        }

        #blackout-shield.active {
            opacity: 1 !important;
            visibility: visible !important;
            display: block !important;
            pointer-events: all !important;
        }

        /* Instant total blackout applied to HTML and all DOM elements during screenshot */
        html.ss-blackout,
        html.ss-blackout body {
            background: #000000 !important;
            background-color: #000000 !important;
            color: #000000 !important;
            filter: brightness(0) !important;
        }

        html.ss-blackout body > *:not(#blackout-shield) {
            visibility: hidden !important;
            opacity: 0 !important;
            display: none !important;
        }

        /* Toast notification */
        #doc-toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 100000;
            transform: translateY(120%);
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.3s ease;
            opacity: 0;
            pointer-events: none;
        }
        #doc-toast.show {
            transform: translateY(0);
            opacity: 1;
            pointer-events: all;
        }

        /* Active Navigation item left-cyan border (like Tailwind docs) */
        .sidebar-item-active {
            color: #ffffff !important;
            font-weight: 600;
            position: relative;
        }
        .sidebar-item-active::before {
            content: '';
            position: absolute;
            left: -12px;
            top: 2px;
            bottom: 2px;
            width: 2.5px;
            background: #38bdf8;
            border-radius: 9999px;
            box-shadow: 0 0 10px rgba(56, 189, 248, 0.8);
        }

        /* Code block syntax colors */
        .code-frame-body code {
            font-family: 'Fira Code', monospace;
            font-size: 13.5px;
        }

        /* Prism.js Tailwind Docs Custom Colors */
        code[class*="language-"], pre[class*="language-"] {
            background: transparent !important;
            font-family: 'Fira Code', monospace !important;
            font-size: 13.5px !important;
            text-shadow: none !important;
        }
        .token.tag, .token.selector, .token.deleted { color: #f43f5e !important; }
        .token.attr-name { color: #38bdf8 !important; }
        .token.attr-value, .token.string, .token.char, .token.inserted { color: #34d399 !important; }
        .token.property, .token.variable, .token.constant { color: #22d3ee !important; }
        .token.keyword, .token.atrule { color: #c084fc !important; font-weight: 600 !important; }
        .token.comment, .token.prolog, .token.doctype, .token.cdata { color: #64748b !important; font-style: italic !important; }
        .token.punctuation { color: #94a3b8 !important; }
        .token.class-name, .token.function { color: #f472b6 !important; }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css">

    @stack('styles')
</head>

<body class="bg-[#0b1120] text-slate-300 min-h-screen flex flex-col antialiased selection:bg-cyan-500/30 selection:text-cyan-200">

    <!-- Anti-Screenshot Blackout Overlay (Solid pure black to ensure captured screenshot is 100% black) -->
    <div id="blackout-shield" aria-hidden="true" title="Klik untuk melanjutkan membaca"></div>

    <!-- Security Toast -->
    <div id="doc-toast" class="bg-slate-900 border border-slate-700/80 text-white px-4 py-3 rounded-xl shadow-2xl flex items-center gap-3 text-sm">
        <i class="fas fa-exclamation-triangle text-amber-400 text-base" id="doc-toast-icon"></i>
        <span id="doc-toast-msg">Pemberitahuan keamanan</span>
    </div>

    <!-- Top Navigation Header -->
    <header class="sticky top-0 z-40 w-full border-b border-slate-800/80 bg-[#0b1120]/80 backdrop-blur-xl transition">
        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
            
            <!-- Left Branding & Mobile Hamburger -->
            <div class="flex items-center gap-2 sm:gap-4">
                <!-- Smart Back Navigation Button (Works from Google or browser history) -->
                <button type="button" 
                        onclick="handleSmartGoBack()" 
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-900/90 hover:bg-slate-800 text-slate-300 hover:text-white border border-slate-700/60 hover:border-cyan-500/50 text-xs font-semibold transition shadow"
                        title="Kembali ke halaman sebelumnya">
                    <i class="fas fa-arrow-left text-cyan-400"></i>
                    <span class="hidden sm:inline">Kembali</span>
                </button>

                <!-- Mobile Burger Toggle Button -->
                <button type="button" 
                        id="openSidebarBtn"
                        class="lg:hidden inline-flex items-center justify-center p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 border border-slate-700/50 transition" 
                        aria-label="Buka menu navigasi">
                    <i class="fas fa-bars text-lg"></i>
                </button>

                <!-- Brand Logo (Tailwind doc style) -->
                <a href="{{ route('modules.index') }}" class="flex items-center gap-2.5 group">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-cyan-500 to-sky-400 flex items-center justify-center shadow-lg shadow-cyan-500/20 group-hover:scale-105 transition-transform">
                        <i class="fas fa-code text-white text-sm"></i>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-base font-extrabold text-white tracking-tight">talentgroup.id</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-mono font-semibold bg-slate-800 text-cyan-400 border border-slate-700">v4.3</span>
                    </div>
                </a>

                <!-- Module Title in Navbar -->
                @if(isset($learningModule))
                    <div class="hidden sm:flex items-center gap-2.5 pl-3 ml-1 border-l border-slate-800">
                        <div class="flex items-center gap-2 px-3 py-1 rounded-lg bg-slate-900/90 border border-slate-700/70 shadow-sm">
                            <i class="{{ $learningModule->icon ?: 'fas fa-book' }} text-cyan-400 text-xs"></i>
                            <span class="font-bold text-white text-xs sm:text-sm tracking-tight truncate max-w-[170px] md:max-w-xs lg:max-w-sm">
                                {{ $learningModule->name }}
                            </span>
                        </div>

                        @if(!$learningModule->is_public)
                            <span class="hidden md:inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-amber-500/15 text-amber-400 border border-amber-500/30">
                                <i class="fas fa-lock text-[8px]"></i> PRIVATE
                            </span>
                        @else
                            <span class="hidden md:inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-emerald-500/15 text-emerald-400 border border-emerald-500/30">
                                <i class="fas fa-globe text-[8px]"></i> FREE / PUBLIC
                            </span>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Quick Search Bar (Ctrl+K) -->
            <div class="flex-1 max-w-md hidden md:block">
                <button type="button" 
                        id="searchTriggerBtn"
                        class="w-full flex items-center justify-between px-3.5 py-1.5 rounded-lg bg-slate-900/90 hover:bg-slate-800/90 border border-slate-800 hover:border-slate-700 text-slate-400 text-xs transition shadow-inner">
                    <span class="flex items-center gap-2.5">
                        <i class="fas fa-search text-slate-500"></i>
                        <span>Cari dokumentasi & topik...</span>
                    </span>
                    <kbd class="px-2 py-0.5 rounded bg-slate-800 text-slate-400 font-mono text-[10px] border border-slate-700/60 shadow-sm">Ctrl K</kbd>
                </button>
            </div>

            <!-- Right Nav Links & User Area -->
            <div class="flex items-center gap-3 sm:gap-4 text-xs font-medium">
                <!-- Search icon on mobile -->
                <button type="button" id="searchTriggerBtnMobile" class="md:hidden p-2 text-slate-400 hover:text-white">
                    <i class="fas fa-search text-base"></i>
                </button>

                <a href="{{ route('modules.index') }}" class="text-cyan-400 hover:text-cyan-300 font-semibold transition flex items-center gap-1.5">
                    <i class="fas fa-layer-group text-[11px]"></i>
                    <span class="hidden sm:inline">Katalog Modul</span>
                </a>
                <a href="{{ route('home') }}" class="hidden sm:inline-block text-slate-400 hover:text-white transition">Beranda</a>
                <a href="{{ route('user.courses.index') }}" class="hidden sm:inline-block text-slate-400 hover:text-white transition">Kursus</a>
                
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.modules.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-cyan-500/10 text-cyan-400 border border-cyan-500/30 hover:bg-cyan-500/20 transition font-semibold">
                            <i class="fas fa-cog"></i>
                            <span>Admin CMS</span>
                        </a>
                    @else
                        <a href="{{ route('user.dashboard') }}" class="text-slate-400 hover:text-white transition">Dashboard</a>
                    @endif
                    <div class="h-4 w-px bg-slate-800 hidden sm:block"></div>
                    <div class="flex items-center gap-2">
                        <img src="{{ auth()->user()->avatar_url }}" 
                             alt="Avatar" class="w-7 h-7 rounded-full object-cover border border-slate-700">
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-3 py-1.5 rounded-lg bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-bold transition">Masuk</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Docs Content Area (3-Column Layout on Desktop) -->
    <div class="flex-1 max-w-[90rem] w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex gap-8">

            <!-- ============================================== -->
            <!-- DESKTOP LEFT SIDEBAR -->
            <!-- ============================================== -->
            <aside class="hidden lg:block w-72 shrink-0 py-8 sticky top-16 h-[calc(100vh-4rem)] overflow-y-auto pr-4 border-r border-slate-800/60">
                <div class="space-y-6">
                    @if(isset($learningModule))
                        <!-- Small Back to Catalog Link -->
                        <div class="pb-2">
                            <a href="{{ route('modules.index') }}" 
                               class="inline-flex items-center gap-2 text-xs font-semibold text-slate-400 hover:text-cyan-400 transition-colors group">
                                <i class="fas fa-arrow-left text-[11px] group-hover:-translate-x-1 transition-transform"></i>
                                <span>Katalog Semua Modul</span>
                            </a>
                        </div>

                        <!-- Grouped Sections & Lessons -->
                        @if(isset($groupedLessons) && $groupedLessons->count() > 0)
                            @foreach($groupedLessons as $sectionName => $sectionLessons)
                                <div class="mb-6">
                                    <h5 class="text-[11px] font-bold tracking-widest text-slate-400 uppercase mb-3 px-1 font-mono">
                                        {{ $sectionName }}
                                    </h5>

                                    <ul class="space-y-1 border-l border-slate-800/90 ml-1 pl-3">
                                        @foreach($sectionLessons as $item)
                                            @php
                                                $isActiveLesson = isset($currentLesson) && $currentLesson->id === $item->id;
                                            @endphp
                                            <li>
                                                <a href="{{ route('modules.lesson.show', ['moduleSlug' => $learningModule->slug, 'lessonSlug' => $item->slug]) }}" 
                                                   class="block py-1.5 text-[13.5px] leading-snug transition-all -ml-[13px] pl-3 border-l-2 {{ $isActiveLesson ? 'border-cyan-400 text-white font-semibold' : 'border-transparent text-slate-400 hover:text-slate-200 hover:border-slate-700' }}">
                                                    <div class="flex items-center justify-between gap-2">
                                                        <span class="truncate">{{ $item->title }}</span>
                                                        @if(!$learningModule->is_public && !empty($isLocked))
                                                            <i class="fas fa-lock text-[9px] text-amber-500/80"></i>
                                                        @endif
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        @elseif(isset($lessons) && $lessons->count() > 0)
                            <div>
                                <h5 class="text-[11px] font-bold tracking-widest text-slate-400 uppercase mb-3 px-1 font-mono">
                                    MATERI
                                </h5>
                                <ul class="space-y-1 border-l border-slate-800/90 ml-1 pl-3">
                                    @foreach($lessons as $item)
                                        @php
                                            $isActiveLesson = isset($currentLesson) && $currentLesson->id === $item->id;
                                        @endphp
                                        <li>
                                            <a href="{{ route('modules.lesson.show', ['moduleSlug' => $learningModule->slug, 'lessonSlug' => $item->slug]) }}" 
                                               class="block py-1.5 text-[13.5px] leading-snug transition-all -ml-[13px] pl-3 border-l-2 {{ $isActiveLesson ? 'border-cyan-400 text-white font-semibold' : 'border-transparent text-slate-400 hover:text-slate-200 hover:border-slate-700' }}">
                                                <span class="truncate">{{ $item->title }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div class="text-xs text-slate-500 italic py-2">Belum ada materi di modul ini.</div>
                        @endif

                        <!-- Admin Module Quick Actions -->
                        @auth
                            @if(auth()->user()->isAdmin())
                                <div class="pt-4 border-t border-slate-800/80 space-y-2">
                                    <a href="{{ route('admin.modules.contents.create', $learningModule->id) }}" 
                                       class="w-full py-2 px-3 rounded-lg bg-cyan-500/10 hover:bg-cyan-500/20 text-cyan-400 border border-cyan-500/30 text-xs font-semibold flex items-center justify-center gap-2 transition">
                                        <i class="fas fa-plus text-[10px]"></i>
                                        <span>Tambah Materi Baru</span>
                                    </a>
                                    <a href="{{ route('admin.modules.contents.index', $learningModule->id) }}" 
                                       class="w-full py-1.5 px-3 rounded-lg bg-slate-900 hover:bg-slate-800 text-slate-400 hover:text-white border border-slate-800 text-[11px] font-medium flex items-center justify-center gap-1.5 transition">
                                        <i class="fas fa-cog text-[10px]"></i>
                                        <span>Kelola Bab & Materi</span>
                                    </a>
                                </div>
                            @endif
                        @endauth

                    @elseif(isset($categories))
                        <!-- Fallback if viewing legacy global index -->
                        <div>
                            <a href="{{ route('modules.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-400 hover:text-cyan-400 transition-colors">
                                <i class="fas fa-arrow-left text-[11px]"></i>
                                <span>Katalog Semua Modul</span>
                            </a>
                        </div>
                        @foreach($categories as $category)
                            <div>
                                <h5 class="text-[11px] font-bold tracking-widest text-slate-400 uppercase mb-3 flex items-center justify-between font-mono">
                                    <span>{{ $category->name }}</span>
                                    <span class="text-[10px] font-mono text-slate-600">({{ $category->publishedModules->count() }})</span>
                                </h5>
                                <ul class="space-y-1 border-l border-slate-800/90 ml-1 pl-3">
                                    @foreach($category->publishedModules as $catModule)
                                        <li>
                                            <a href="{{ route('modules.show', $catModule->slug) }}" 
                                               class="block py-1.5 text-[13.5px] transition-all -ml-[13px] pl-3 border-l-2 {{ isset($module) && $module->id === $catModule->id ? 'border-cyan-400 text-white font-semibold' : 'border-transparent text-slate-400 hover:text-slate-200 hover:border-slate-700' }}">
                                                {{ $catModule->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    @endif
                </div>
            </aside>

            <!-- ============================================== -->
            <!-- MOBILE SLIDE-IN DRAWER (Scoped to Module)      -->
            <!-- ============================================== -->
            <div id="mobileSidebarDrawer" class="fixed inset-0 z-50 lg:hidden pointer-events-none transition-all duration-300">
                <!-- Backdrop overlay -->
                <div id="mobileSidebarBackdrop" class="fixed inset-0 bg-black/75 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>

                <!-- Slide Drawer Content -->
                <div id="mobileSidebarPanel" class="fixed inset-y-0 left-0 w-80 max-w-[85vw] bg-[#080d1a] border-r border-slate-800 p-6 overflow-y-auto transform -translate-x-full transition-transform duration-300 ease-in-out shadow-2xl flex flex-col justify-between">
                    <div>
                        <!-- Mobile Drawer Header with Close [esc] -->
                        <div class="flex items-center justify-between pb-6 border-b border-slate-800 mb-6">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-lg bg-cyan-500 flex items-center justify-center">
                                    <i class="fas fa-book text-slate-950 text-xs"></i>
                                </div>
                                <span class="font-bold text-white text-sm truncate max-w-[180px]">
                                    {{ isset($learningModule) ? $learningModule->name : 'Daftar Materi' }}
                                </span>
                            </div>

                            <button type="button" 
                                     id="closeSidebarBtn"
                                    class="inline-flex items-center gap-1 px-2 py-1 rounded bg-slate-800 text-slate-400 hover:text-white border border-slate-700 text-xs font-mono">
                                <span>esc</span>
                                <i class="fas fa-times text-[10px]"></i>
                            </button>
                        </div>

                        <!-- Scoped Module Navigation or Fallback -->
                        @if(isset($learningModule))
                            <div class="space-y-5">
                                <a href="{{ route('modules.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-cyan-400">
                                    <i class="fas fa-arrow-left text-[10px]"></i>
                                    <span>Kembali ke Katalog Modul</span>
                                </a>

                                @if(isset($groupedLessons) && $groupedLessons->count() > 0)
                                    @foreach($groupedLessons as $sectionName => $sectionLessons)
                                        <div>
                                            <h5 class="text-[11px] font-bold tracking-widest text-slate-400 uppercase mb-2 px-1 font-mono">
                                                {{ $sectionName }}
                                            </h5>
                                            <ul class="space-y-1 border-l border-slate-800/90 ml-1 pl-3">
                                                @foreach($sectionLessons as $item)
                                                    @php
                                                        $isActiveLesson = isset($currentLesson) && $currentLesson->id === $item->id;
                                                    @endphp
                                                    <li>
                                                        <a href="{{ route('modules.lesson.show', ['moduleSlug' => $learningModule->slug, 'lessonSlug' => $item->slug]) }}" 
                                                           class="block py-1.5 text-xs transition-all -ml-[13px] pl-3 border-l-2 {{ $isActiveLesson ? 'border-cyan-400 text-white font-bold' : 'border-transparent text-slate-400 hover:text-white' }}">
                                                            {{ $item->title }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach
                                @elseif(isset($lessons) && $lessons->count() > 0)
                                    <div class="space-y-1">
                                        @foreach($lessons as $item)
                                            @php
                                                $isActiveLesson = isset($currentLesson) && $currentLesson->id === $item->id;
                                            @endphp
                                            <a href="{{ route('modules.lesson.show', ['moduleSlug' => $learningModule->slug, 'lessonSlug' => $item->slug]) }}" 
                                               class="block py-2 px-3 rounded-lg text-xs {{ $isActiveLesson ? 'bg-cyan-500/10 text-cyan-400 font-bold border border-cyan-500/30' : 'text-slate-300 hover:bg-slate-800' }}">
                                                {{ $item->title }}
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-xs text-slate-500 italic">Belum ada materi.</div>
                                @endif
                            </div>
                        @elseif(isset($categories))
                            <div class="space-y-6">
                                @foreach($categories as $category)
                                    <div>
                                        <h5 class="text-[11px] font-bold tracking-widest text-slate-400 uppercase mb-3 font-mono">
                                            {{ $category->name }}
                                        </h5>
                                        <ul class="space-y-2 border-l border-slate-800 ml-1 pl-3">
                                            @foreach($category->publishedModules as $catModule)
                                                <li>
                                                    <a href="{{ route('modules.show', $catModule->slug) }}" 
                                                       class="block py-1 text-[13.5px] transition-colors {{ isset($module) && $module->id === $catModule->id ? 'sidebar-item-active' : 'text-slate-400 hover:text-white' }}">
                                                        {{ $catModule->title }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Bottom admin action -->
                    @auth
                        @if(auth()->user()->isAdmin())
                            <div class="pt-6 mt-6 border-t border-slate-800">
                                @if(isset($learningModule))
                                    <a href="{{ route('admin.modules.contents.create', $learningModule->id) }}" class="w-full py-2 px-3 rounded-lg bg-cyan-500/20 text-cyan-300 border border-cyan-500/30 text-xs font-semibold flex items-center justify-center gap-2">
                                        <i class="fas fa-plus"></i> Tambah Materi Modul Ini
                                    </a>
                                @else
                                    <a href="{{ route('admin.modules.create') }}" class="w-full py-2 px-3 rounded-lg bg-cyan-500/20 text-cyan-300 border border-cyan-500/30 text-xs font-semibold flex items-center justify-center gap-2">
                                        <i class="fas fa-plus"></i> Buat Modul Baru
                                    </a>
                                @endif
                            </div>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- ============================================== -->
            <!-- MAIN CONTENT (Middle Column)                   -->
            <!-- ============================================== -->
            <main class="flex-1 min-w-0 py-8 lg:py-10 max-w-4xl mx-auto @if(isset($module) && $module->enable_protection) protected-content @endif">
                @yield('content')
            </main>

            <!-- ============================================== -->
            <!-- RIGHT SIDEBAR ("ON THIS PAGE" Table of Contents)-->
            <!-- ============================================== -->
            @if(isset($tableOfContents) && count($tableOfContents) > 0)
                <aside class="hidden xl:block w-64 shrink-0 py-10 sticky top-16 h-[calc(100vh-4rem)] overflow-y-auto pl-6 border-l border-slate-800/60">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4 flex items-center gap-2">
                        <i class="fas fa-list-ul text-[10px] text-cyan-400"></i>
                        <span>On this page</span>
                    </div>

                    <nav class="space-y-2 text-[13px] font-normal" id="tocNavigation">
                        @foreach($tableOfContents as $tocItem)
                            <a href="#{{ $tocItem['id'] }}" 
                               data-toc-id="{{ $tocItem['id'] }}"
                               class="toc-link block text-slate-400 hover:text-cyan-400 transition-colors {{ $tocItem['level'] === 1 ? 'font-semibold text-slate-200' : ($tocItem['level'] === 3 ? 'pl-4 text-xs' : 'pl-2') }}">
                                {{ $tocItem['title'] }}
                            </a>
                        @endforeach
                    </nav>
                </aside>
            @endif

        </div>
    </div>

    <!-- Search Modal (Ctrl+K) -->
    <div id="searchModal" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-start justify-center pt-20 px-4">
        <div class="bg-slate-900 border border-slate-700/80 rounded-2xl w-full max-w-xl shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200">
            <!-- Search Input -->
            <div class="p-4 border-b border-slate-800 flex items-center gap-3">
                <i class="fas fa-search text-slate-400 text-base"></i>
                <input type="text" 
                       id="searchInput" 
                       placeholder="Ketik kata kunci untuk mencari modul..." 
                       class="w-full bg-transparent text-white text-sm placeholder-slate-500 outline-none">
                <kbd class="px-2 py-0.5 rounded bg-slate-800 text-slate-400 font-mono text-[10px] border border-slate-700">ESC</kbd>
            </div>

            <!-- Search Results -->
            <div id="searchResults" class="max-h-96 overflow-y-auto p-2 divide-y divide-slate-800/40">
                <div class="p-6 text-center text-xs text-slate-500">
                    Ketik judul modul, kategori, atau topik untuk mencari...
                </div>
            </div>
        </div>
    </div>

    <!-- Copy Code Script & Helpers -->
    <script>
        // Copy Code Functionality
        function copyCodeBlock(codeId, button) {
            const codeEl = document.getElementById(codeId);
            if (!codeEl) return;

            const textToCopy = codeEl.innerText || codeEl.textContent;
            
            // Allow copy specifically for the code button
            window.__allowClipboardAction = true;
            navigator.clipboard.writeText(textToCopy).then(() => {
                const icon = button.querySelector('i');
                const text = button.querySelector('span');
                const origIcon = icon.className;
                const origText = text.innerText;

                icon.className = 'fas fa-check text-emerald-400';
                text.innerText = 'Tersalin!';
                button.classList.add('border-emerald-500/50', 'text-emerald-400');

                setTimeout(() => {
                    icon.className = origIcon;
                    text.innerText = origText;
                    button.classList.remove('border-emerald-500/50', 'text-emerald-400');
                    window.__allowClipboardAction = false;
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy: ', err);
                window.__allowClipboardAction = false;
            });
        }

        // Mobile Sidebar Drawer Controller
        const openSidebarBtn = document.getElementById('openSidebarBtn');
        const closeSidebarBtn = document.getElementById('closeSidebarBtn');
        const mobileSidebarDrawer = document.getElementById('mobileSidebarDrawer');
        const mobileSidebarBackdrop = document.getElementById('mobileSidebarBackdrop');
        const mobileSidebarPanel = document.getElementById('mobileSidebarPanel');

        function openDrawer() {
            if (!mobileSidebarDrawer) return;
            mobileSidebarDrawer.classList.remove('pointer-events-none');
            mobileSidebarBackdrop.classList.remove('opacity-0');
            mobileSidebarPanel.classList.remove('-translate-x-full');
            document.body.style.overflow = 'hidden';
        }

        function closeDrawer() {
            if (!mobileSidebarDrawer) return;
            mobileSidebarPanel.classList.add('-translate-x-full');
            mobileSidebarBackdrop.classList.add('opacity-0');
            setTimeout(() => {
                mobileSidebarDrawer.classList.add('pointer-events-none');
                document.body.style.overflow = '';
            }, 300);
        }

        if (openSidebarBtn) openSidebarBtn.addEventListener('click', openDrawer);
        if (closeSidebarBtn) closeSidebarBtn.addEventListener('click', closeDrawer);
        if (mobileSidebarBackdrop) mobileSidebarBackdrop.addEventListener('click', closeDrawer);

        // Close on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeDrawer();
                closeSearchModal();
            }
        });

        // Search Modal Controller (Ctrl + K)
        const searchModal = document.getElementById('searchModal');
        const searchTriggerBtn = document.getElementById('searchTriggerBtn');
        const searchTriggerBtnMobile = document.getElementById('searchTriggerBtnMobile');
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');

        function openSearchModal() {
            if (!searchModal) return;
            searchModal.classList.remove('hidden');
            setTimeout(() => searchInput.focus(), 50);
        }

        function closeSearchModal() {
            if (!searchModal) return;
            searchModal.classList.add('hidden');
            searchInput.value = '';
        }

        if (searchTriggerBtn) searchTriggerBtn.addEventListener('click', openSearchModal);
        if (searchTriggerBtnMobile) searchTriggerBtnMobile.addEventListener('click', openSearchModal);
        if (searchModal) {
            searchModal.addEventListener('click', (e) => {
                if (e.target === searchModal) closeSearchModal();
            });
        }

        document.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                openSearchModal();
            }
        });

        // Live Search Input handler
        let searchTimer = null;
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimer);
                const query = e.target.value.trim();
                if (query.length < 2) {
                    searchResults.innerHTML = '<div class="p-6 text-center text-xs text-slate-500">Ketik kata kunci untuk mencari...</div>';
                    return;
                }

                searchResults.innerHTML = '<div class="p-6 text-center text-xs text-slate-400"><i class="fas fa-spinner fa-spin mr-2"></i>Mencari modul...</div>';

                searchTimer = setTimeout(() => {
                    fetch(`{{ route('modules.search') }}?q=${encodeURIComponent(query)}`)
                        .then(res => res.json())
                        .then(items => {
                            if (items.length === 0) {
                                searchResults.innerHTML = '<div class="p-6 text-center text-xs text-slate-500">Tidak ada modul yang cocok dengan pencarian.</div>';
                                return;
                            }

                            let html = '';
                            items.forEach(item => {
                                html += `
                                    <a href="${item.url}" class="block p-3 rounded-xl hover:bg-slate-800/80 transition group">
                                        <div class="flex items-center justify-between text-xs text-cyan-400 font-mono mb-1">
                                            <span>${item.category}</span>
                                            <i class="fas fa-arrow-right text-[10px] opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                        </div>
                                        <div class="text-sm font-bold text-white group-hover:text-cyan-300 transition-colors">${item.title}</div>
                                        ${item.excerpt ? `<div class="text-xs text-slate-400 mt-1 line-clamp-1">${item.excerpt}</div>` : ''}
                                    </a>
                                `;
                            });
                            searchResults.innerHTML = html;
                        })
                        .catch(err => {
                            searchResults.innerHTML = '<div class="p-4 text-center text-xs text-rose-400">Gagal mengambil data pencarian.</div>';
                        });
                }, 250);
            });
        }

        // Scrollspy for "On this page" TOC
        const headings = document.querySelectorAll('main h1, main h2, main h3');
        const tocLinks = document.querySelectorAll('.toc-link');

        function updateActiveToc() {
            let currentHeadingId = '';
            const scrollPos = window.scrollY + 120;

            headings.forEach(h => {
                if (h.offsetTop <= scrollPos) {
                    currentHeadingId = h.id;
                }
            });

            tocLinks.forEach(link => {
                if (link.getAttribute('data-toc-id') === currentHeadingId) {
                    link.classList.add('text-cyan-400', 'font-semibold');
                    link.classList.remove('text-slate-400');
                } else {
                    link.classList.remove('text-cyan-400', 'font-semibold');
                    link.classList.add('text-slate-400');
                }
            });
        }

        window.addEventListener('scroll', updateActiveToc, { passive: true });
        updateActiveToc();

        // Global smart go back handler (supporting Google and external referrer)
        function handleSmartGoBack() {
            if (document.referrer && document.referrer.indexOf(window.location.host) === -1) {
                window.history.back();
            } else if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.href = "{{ route('modules.index') }}";
            }
        }
    </script>

    <!-- ================================================================= -->
    <!-- BULLETPROOF ANTI-SCREENSHOT & ANTI-INSPECT ENGINE (DESKTOP & MOBILE) -->
    <!-- ================================================================= -->
    @php
        $isProtectionEnabled = true;
        if (isset($module) && isset($module->enable_protection)) {
            $isProtectionEnabled = (bool) $module->enable_protection;
        } elseif (isset($learningModule) && isset($learningModule->enable_protection)) {
            $isProtectionEnabled = (bool) $learningModule->enable_protection;
        }
    @endphp
    @if($isProtectionEnabled)
    <script>
        (function() {
            'use strict';

            const blackoutShield = document.getElementById('blackout-shield');
            const toast = document.getElementById('doc-toast');
            const toastMsg = document.getElementById('doc-toast-msg');

            let blackoutActive = false;
            let isSnippingLocked = false;
            let blackoutTimer = null;
            let lockReleaseTimer = null;
            let hadScreenshotAttempt = false;

            // Detect OS platform
            const isMac = /(Mac|iPhone|iPod|iPad)/i.test(navigator.platform || navigator.userAgent);

            // 1. Generate Synchronous Pure Black Blob for Instant Clipboard Poisoning
            let blackImageBlob = null;
            try {
                const canvas = document.createElement('canvas');
                canvas.width = 1920;
                canvas.height = 1080;
                const ctx = canvas.getContext('2d');
                ctx.fillStyle = '#000000';
                ctx.fillRect(0, 0, 1920, 1080);
                const dataUrl = canvas.toDataURL('image/png');
                const binStr = atob(dataUrl.split(',')[1]);
                const len = binStr.length;
                const arr = new Uint8Array(len);
                for (let i = 0; i < len; i++) {
                    arr[i] = binStr.charCodeAt(i);
                }
                blackImageBlob = new Blob([arr], { type: 'image/png' });
            } catch (err) {}

            function showToast(msg) {
                if (!toast || !toastMsg) return;
                toastMsg.innerText = msg;
                toast.classList.add('show');
                clearTimeout(toast.__timer);
                toast.__timer = setTimeout(() => toast.classList.remove('show'), 3500);
            }

            // Immediately overwrite system clipboard with pure solid black image
            function overwriteClipboardWithBlack() {
                if (!navigator.clipboard || window.__allowClipboardAction) return;

                if (blackImageBlob && typeof ClipboardItem !== 'undefined') {
                    try {
                        navigator.clipboard.write([
                            new ClipboardItem({ 'image/png': blackImageBlob })
                        ]).catch(() => {
                            navigator.clipboard.writeText('').catch(() => {});
                        });
                    } catch (e) {
                        navigator.clipboard.writeText('').catch(() => {});
                    }
                } else {
                    try {
                        navigator.clipboard.writeText('').catch(() => {});
                    } catch (e) {}
                }
            }

            // Poison clipboard repeatedly across multiple microtasks
            function poisonClipboardBurst() {
                overwriteClipboardWithBlack();
                [50, 150, 300, 600, 1200, 2000, 3000].forEach((delay) => {
                    setTimeout(overwriteClipboardWithBlack, delay);
                });
            }

            // Instant Blackout Trigger (0ms latency solid black screen with locking)
            function triggerInstantBlackout(reason, duration = 4500, lock = true) {
                blackoutActive = true;
                hadScreenshotAttempt = true;

                if (lock) {
                    isSnippingLocked = true;
                }

                // Instantly apply solid black classes to DOM
                document.documentElement.classList.add('ss-blackout');
                if (blackoutShield) {
                    blackoutShield.classList.add('active');
                }

                // Deselect any selected text
                try {
                    if (window.getSelection) {
                        window.getSelection().removeAllRanges();
                    }
                } catch (e) {}

                // Poison clipboard immediately
                poisonClipboardBurst();

                clearTimeout(blackoutTimer);
                clearTimeout(lockReleaseTimer);

                // Keep black for duration so Snipping Tool / Mac capture captures PURE BLACK
                if (duration > 0) {
                    blackoutTimer = setTimeout(() => {
                        isSnippingLocked = false;
                        if (!document.hidden) {
                            clearBlackout(true);
                        }
                    }, duration);
                }
            }

            // Clear blackout cleanly and restore content for legitimate readers
            function clearBlackout(notify = false) {
                blackoutActive = false;
                isSnippingLocked = false;
                clearTimeout(blackoutTimer);
                clearTimeout(lockReleaseTimer);

                document.documentElement.classList.remove('ss-blackout');
                if (blackoutShield) {
                    blackoutShield.classList.remove('active');
                }

                if (notify || hadScreenshotAttempt) {
                    hadScreenshotAttempt = false;
                    showToast('Tangkapan layar dinonaktifkan demi perlindungan hak cipta.');
                }
            }

            // ========================================================
            // A. HARDWARE & KEYBOARD SHORTCUTS (DESKTOP & MAC OS)
            // ========================================================
            function handleKeyDown(e) {
                // Developer Tools Shortcuts: F12, Ctrl+Shift+I/J/C, Ctrl+U
                if (e.key === 'F12' || e.keyCode === 123) {
                    e.preventDefault();
                    e.stopPropagation();
                    showToast('Developer Tools dinonaktifkan.');
                    return false;
                }

                if ((e.ctrlKey || e.metaKey) && e.shiftKey && ['I','i','J','j','C','c'].includes(e.key)) {
                    e.preventDefault();
                    e.stopPropagation();
                    showToast('Developer Tools dinonaktifkan.');
                    return false;
                }

                if ((e.ctrlKey || e.metaKey) && (e.key === 'u' || e.key === 'U')) {
                    e.preventDefault();
                    e.stopPropagation();
                    showToast('Lihat sumber halaman dinonaktifkan.');
                    return false;
                }

                // Save page shortcut: Ctrl+S / Cmd+S
                if ((e.ctrlKey || e.metaKey) && (e.key === 's' || e.key === 'S')) {
                    e.preventDefault();
                    e.stopPropagation();
                    triggerInstantBlackout('Save shortcut', 2500, true);
                    showToast('Menyimpan halaman dinonaktifkan.');
                    return false;
                }

                // Print page shortcut: Ctrl+P / Cmd+P
                if ((e.ctrlKey || e.metaKey) && (e.key === 'p' || e.key === 'P')) {
                    e.preventDefault();
                    e.stopPropagation();
                    triggerInstantBlackout('Print capture', 3000, true);
                    showToast('Pencetakan halaman dinonaktifkan.');
                    return false;
                }

                // PrintScreen (PrtScn) Key - All variants on Windows / Linux
                if (e.key === 'PrintScreen' || e.keyCode === 44 || e.code === 'PrintScreen' || e.altKey && (e.key === 'PrintScreen' || e.keyCode === 44)) {
                    e.preventDefault();
                    triggerInstantBlackout('PrintScreen key', 5000, true);
                    return false;
                }

                // ----------------------------------------------------
                // WINDOWS SNIPPING TOOL (Win + Shift + S) & Windows Key
                // Windows intercepts the 'S' key, so we MUST trigger on Meta (Win) key!
                // ----------------------------------------------------
                if (!isMac) {
                    // Detect Windows key (Meta) alone or combination
                    const isWinKey = e.key === 'Meta' || e.code === 'MetaLeft' || e.code === 'MetaRight' || e.code === 'OSLeft' || e.code === 'OSRight' || e.keyCode === 91 || e.keyCode === 92;

                    // If Windows key is pressed (alone or with Shift)
                    if (isWinKey || e.metaKey) {
                        // Instant blackout! Before user even presses 'S', screen is 100% black!
                        triggerInstantBlackout('Windows Key / Snipping Tool', 5000, true);
                    }

                    // If Shift is pressed while Meta is down
                    if (e.shiftKey && (isWinKey || e.metaKey)) {
                        triggerInstantBlackout('Win+Shift Snipping Tool', 5000, true);
                    }
                }

                // ----------------------------------------------------
                // MAC OS SCREENSHOT (Cmd + Shift + 3 / 4 / 5)
                // macOS intercepts 3/4/5, so we MUST trigger on (Cmd + Shift)!
                // ----------------------------------------------------
                if (isMac) {
                    const isCmdKey = e.key === 'Meta' || e.keyCode === 91 || e.keyCode === 93 || e.metaKey;
                    const isShiftKey = e.key === 'Shift' || e.keyCode === 16 || e.shiftKey;

                    // If both Command (Meta) and Shift are active
                    if ((e.metaKey && e.shiftKey) || (isCmdKey && isShiftKey)) {
                        // Instant blackout! Before user touches 3/4/5, screen is 100% black!
                        triggerInstantBlackout('Mac Screenshot Shortcut', 5000, true);
                    }

                    // If Meta + 3/4/5 is received
                    if (e.metaKey && ['3', '4', '5'].includes(e.key)) {
                        triggerInstantBlackout('Mac Screenshot Key', 5000, true);
                    }
                }

                // Edge / Browser Web Capture: Ctrl + Shift + S
                if (e.ctrlKey && e.shiftKey && (e.key === 'S' || e.key === 's')) {
                    triggerInstantBlackout('Browser Web Capture', 4000, true);
                }
            }

            // Register keydown with capture phase on BOTH window and document
            window.addEventListener('keydown', handleKeyDown, true);
            document.addEventListener('keydown', handleKeyDown, true);

            // Keyup: re-poison clipboard (do NOT immediately clear blackout so snipping stays black!)
            window.addEventListener('keyup', function(e) {
                if (e.key === 'PrintScreen' || e.keyCode === 44 || e.code === 'PrintScreen') {
                    poisonClipboardBurst();
                }
            }, true);

            // ========================================================
            // B. MOBILE PHONES (HP) & EXTERNAL SCREENSHOT TOOLS
            // ========================================================
            // 1. Multi-Touch Gesture Detection:
            // Android 3-finger swipe screenshot triggers touchstart with 2+ touches.
            // Instant blackout happens BEFORE gesture completes!
            window.addEventListener('touchstart', function(e) {
                if (e.touches && e.touches.length >= 2) {
                    triggerInstantBlackout('Multi-touch gesture screenshot', 4500, true);
                }
            }, { passive: true, capture: true });

            // 2. Window Blur:
            // Triggers when external screenshot apps (Lightshot, ShareX, Snipping Tool) take focus,
            // or on Mobile when hardware buttons / notification bar / app switcher triggers.
            window.addEventListener('blur', function() {
                triggerInstantBlackout('Window blur / External capture', 4000, true);
            });

            // 3. Document Visibility Change:
            // When user switches apps or OS capture overlay hides the webpage
            document.addEventListener('visibilitychange', function() {
                if (document.hidden || document.visibilityState === 'hidden') {
                    triggerInstantBlackout('Visibility change / Capture hidden', 4000, true);
                } else {
                    // Only restore after brief delay if not actively locked
                    setTimeout(() => {
                        if (!isSnippingLocked && !document.hidden) {
                            clearBlackout(true);
                        }
                    }, 250);
                }
            });

            // 4. Page Hide
            window.addEventListener('pagehide', function() {
                triggerInstantBlackout('Page hide', 4000, true);
            });

            // ========================================================
            // C. SEAMLESS USER RESTORATION (RESUME READING)
            // ========================================================
            // Tapping or clicking anywhere on the black screen immediately clears the blackout
            if (blackoutShield) {
                blackoutShield.addEventListener('click', function() {
                    clearBlackout(hadScreenshotAttempt);
                });
                blackoutShield.addEventListener('touchstart', function(e) {
                    if (!e.touches || e.touches.length === 1) {
                        clearBlackout(hadScreenshotAttempt);
                    }
                }, { passive: true });
            }

            // Window focus: if lock duration has expired, restore cleanly
            window.addEventListener('focus', function() {
                setTimeout(() => {
                    if (!isSnippingLocked && !document.hidden) {
                        clearBlackout(hadScreenshotAttempt);
                    }
                }, 300);
            });

            // Single tap on document restores after lock
            document.addEventListener('touchstart', function(e) {
                if (blackoutActive && (!e.touches || e.touches.length === 1) && !isSnippingLocked && !document.hidden) {
                    clearBlackout(hadScreenshotAttempt);
                }
            }, { passive: true });

            // Print capture protection
            window.addEventListener('beforeprint', function() {
                triggerInstantBlackout('Print capture', 4000, true);
            });

            // Screen Recording Protection (Block getDisplayMedia)
            try {
                if (navigator.mediaDevices && navigator.mediaDevices.getDisplayMedia) {
                    const originalGetDisplayMedia = navigator.mediaDevices.getDisplayMedia.bind(navigator.mediaDevices);
                    navigator.mediaDevices.getDisplayMedia = function() {
                        triggerInstantBlackout('Screen recording capture attempt', 5000, true);
                        showToast('Perekaman layar tidak diizinkan pada modul ini.');
                        return Promise.reject(new DOMException('Permission denied by module security policy', 'NotAllowedError'));
                    };
                }
            } catch (err) {}

            // ========================================================
            // D. ANTI-COPY, CONTEXT MENU & DRAG RESTRICTIONS
            // ========================================================
            document.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                showToast('Klik kanan dinonaktifkan pada materi modul.');
                return false;
            });

            document.addEventListener('copy', function(e) {
                if (!window.__allowClipboardAction) {
                    e.preventDefault();
                    showToast('Menyalin teks modul tidak diizinkan.');
                }
            });

            document.addEventListener('cut', function(e) {
                e.preventDefault();
            });

            document.addEventListener('dragstart', function(e) {
                if (e.target.tagName === 'IMG') {
                    e.preventDefault();
                }
            });
        })();
    </script>
    @endif

    <!-- Prism Syntax Highlighting -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>

    <!-- Auto-save and draft persistence -->
    <script src="{{ asset('assets/js/form-draft-autosave.js') }}"></script>

    @stack('scripts')
</body>
</html>
