@extends('layouts.app')

@section('title', 'Daftar Kursus')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    
    <!-- Hero Section -->
    <div class="cyber-card mb-8 relative overflow-hidden" style="border-color: var(--accent);">
        <div class="absolute inset-0 opacity-10" style="background: repeating-linear-gradient(45deg, transparent, transparent 10px, var(--accent) 10px, var(--accent) 20px);"></div>
        <div class="relative text-center z-10 py-4">
            <div class="text-6xl animate-pulse mb-4">📚</div>
            <h1 class="text-3xl font-bold mb-3" style="color: var(--accent); font-family: 'Outfit', sans-serif;">
                Course Catalog
            </h1>
            <p style="color: var(--text2); font-family: 'Fira Code', monospace; font-size: 0.9rem;">
                Discover training modules to upgrade your skills.
            </p>
            
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8 max-w-3xl mx-auto">
                <div class="p-4 border rounded-lg" style="background: rgba(0,0,0,0.2); border-color: var(--border);">
                    <div class="text-2xl mb-2">🎓</div>
                    <div class="text-2xl font-bold" style="color: var(--text); font-family: 'Fira Code', monospace;">{{ $courses->total() }}</div>
                    <div class="text-xs uppercase tracking-widest mt-1" style="color: var(--text3);">Total Modules</div>
                </div>
                <div class="p-4 border rounded-lg" style="background: rgba(0,0,0,0.2); border-color: var(--green);">
                    <div class="text-2xl mb-2">⭐</div>
                    <div class="text-2xl font-bold" style="color: var(--green); font-family: 'Fira Code', monospace;">{{ \App\Models\Course::where('is_active', true)->where('price', 0)->count() }}</div>
                    <div class="text-xs uppercase tracking-widest mt-1" style="color: var(--text3);">Free Access</div>
                </div>
                <div class="p-4 border rounded-lg" style="background: rgba(0,0,0,0.2); border-color: var(--yellow);">
                    <div class="text-2xl mb-2">💎</div>
                    <div class="text-2xl font-bold" style="color: var(--yellow); font-family: 'Fira Code', monospace;">{{ \App\Models\Course::where('is_active', true)->where('price', '>', 0)->count() }}</div>
                    <div class="text-xs uppercase tracking-widest mt-1" style="color: var(--text3);">Premium Access</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="cyber-card mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Category Filter -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-widest mb-3" style="color: var(--text);">
                    <i class="fas fa-filter mr-2" style="color: var(--accent);"></i> Category Filter
                </label>
                <div class="flex flex-wrap gap-3" id="categoryPills">
                    <button class="px-4 py-2 text-xs font-bold rounded border transition-all active" style="background: var(--accent); color: white; border-color: var(--accent);" data-category="">
                        All
                    </button>
                    @foreach($categories as $category)
                    <button class="px-4 py-2 text-xs font-bold rounded border transition-all hover:bg-white/5" style="background: var(--bg); color: var(--text); border-color: var(--border);" data-category="{{ $category }}">
                        {{ $category }}
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- Search Bar -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-widest mb-3" style="color: var(--text);">
                    <i class="fas fa-search mr-2" style="color: var(--accent);"></i> Search Query
                </label>
                <div class="flex gap-2">
                    <input type="text" id="searchInput" class="flex-1 px-4 py-3 text-sm rounded border outline-none transition-all" style="background: var(--bg); color: var(--text); border-color: var(--border); font-family: 'Fira Code', monospace;" placeholder="Enter module name or topic...">
                    <button id="searchBtn" class="cyber-btn px-6"><i class="fas fa-search"></i></button>
                    <button id="clearBtn" class="cyber-btn" style="display: none; border-color: #ff4444; color: #ff4444;"><i class="fas fa-times"></i></button>
                </div>
            </div>
        </div>
    </div>

    @if ($courses->isEmpty())
        <!-- Empty State -->
        <div class="cyber-card py-16 text-center">
            <div class="text-6xl mb-6 animate-bounce opacity-50">📭</div>
            <h3 class="text-xl font-bold mb-3" style="color: var(--text);">No Modules Found</h3>
            <p class="text-sm mb-6 max-w-md mx-auto" style="color: var(--text2); font-family: 'Fira Code', monospace;">
                No matching modules found for your query. Adjust your filters or search terms.
            </p>
            <button class="cyber-btn" onclick="resetFilters()">
                <i class="fas fa-redo mr-2"></i> Reset Parameters
            </button>
        </div>
    @else
        <!-- Active Filters Display -->
        <div id="activeFilters" class="mb-6 p-4 rounded border flex justify-between items-center" style="display: none; background: rgba(0,212,255,0.05); border-color: var(--border);">
            <div class="flex items-center gap-3 flex-wrap">
                <span class="text-xs font-bold uppercase tracking-widest" style="color: var(--text3);">Active Filters:</span>
                <div id="filterTags" class="flex gap-2 flex-wrap"></div>
            </div>
            <button class="text-xs hover:underline" style="color: #ff4444; font-family: 'Fira Code', monospace;" onclick="resetFilters()">
                Clear All <i class="fas fa-times-circle ml-1"></i>
            </button>
        </div>

        <!-- Courses Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            @foreach ($courses as $index => $course)
                <div class="cyber-card flex flex-col p-0 transition-all hover:-translate-y-2 hover:shadow-[0_0_20px_rgba(0,212,255,0.2)]">
                    
                    <!-- Card Header -->
                    <div class="p-5 border-b flex justify-between items-start" style="border-color: var(--border); background: rgba(255,255,255,0.02);">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-lg border overflow-hidden flex-shrink-0" style="border-color: var(--border); background: var(--bg);">
                                @if($course->image)
                                    <img src="{{ $course->image_url }}" class="w-full h-full object-cover" alt="{{ $course->title }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-2xl">
                                        {{ ['🎨', '💻', '📊', '🎯', '🚀', '⚡', '🎮', '📱'][($index % 8)] }}
                                    </div>
                                @endif
                            </div>
                            @php
                                preg_match('/^([A-Z]\d+)/', $course->title, $matches);
                                $level = $matches[1] ?? null;
                            @endphp
                            @if($level)
                            <div class="px-2 py-1 rounded text-xs font-bold border" style="background: rgba(0,212,255,0.1); color: var(--accent); border-color: var(--accent);">
                                {{ $level }}
                            </div>
                            @endif
                        </div>
                        
                        @if ($course->price < 1)
                            <div class="px-2 py-1 rounded text-[10px] font-bold border uppercase tracking-widest" style="background: rgba(0,255,136,0.1); color: var(--green); border-color: var(--green);">
                                <i class="fas fa-star mr-1"></i> Free
                            </div>
                        @else
                            <div class="px-2 py-1 rounded text-[10px] font-bold border uppercase tracking-widest" style="background: rgba(255,215,0,0.1); color: var(--yellow); border-color: var(--yellow);">
                                <i class="fas fa-gem mr-1"></i> Premium
                            </div>
                        @endif
                    </div>

                    <!-- Card Body -->
                    <div class="p-5 flex-1 flex flex-col gap-4">
                        <h2 class="text-lg font-bold leading-tight" style="color: var(--text);">{{ $course->title }}</h2>
                        <p class="text-xs flex-1" style="color: var(--text2); font-family: 'Fira Code', monospace; line-height: 1.6;">
                            {{ Str::limit($course->description, 100) }}
                        </p>
                        
                        <!-- Course Info -->
                        <div class="flex flex-col gap-2 pt-3 border-t" style="border-color: var(--border);">
                            <div class="flex items-center gap-2 text-xs" style="color: var(--text3);">
                                <i class="fas fa-book" style="color: var(--accent);"></i> Full Material Access
                            </div>
                            <div class="flex items-center gap-2 text-xs" style="color: var(--text3);">
                                <i class="fas fa-certificate" style="color: var(--accent);"></i> Certificate Provided
                            </div>
                            @if($course->userCourses_count > 0)
                            <div class="flex items-center gap-2 text-xs" style="color: var(--text3);">
                                <i class="fas fa-users" style="color: var(--accent);"></i> {{ $course->userCourses_count }} Users Enrolled
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="p-5 border-t flex flex-col gap-4" style="border-color: var(--border); background: rgba(0,0,0,0.2);">
                        <div class="flex justify-between items-center">
                            <span class="text-xs uppercase tracking-widest" style="color: var(--text3);">Cost</span>
                            @if ($course->price < 1)
                                <span class="text-lg font-bold" style="color: var(--green); font-family: 'Fira Code', monospace;">FREE</span>
                            @else
                                <span class="text-lg font-bold" style="color: var(--yellow); font-family: 'Fira Code', monospace;">Rp {{ number_format($course->price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        
                        <a href="{{ route('user.courses.show', $course->id) }}" class="cyber-btn text-center flex justify-between items-center w-full">
                            <span>Initialize View</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if ($courses->hasPages())
        <div class="flex justify-center items-center mt-8 gap-4 font-mono">
            {{ $courses->links() }}
        </div>
        <style>
            /* Quick style override for Laravel pagination in Tailwind */
            nav[role="navigation"] div.hidden.sm\:flex-1 { display: flex; justify-content: center; }
            nav[role="navigation"] p { color: var(--text3); font-size: 0.8rem; }
            nav[role="navigation"] span.relative.inline-flex, nav[role="navigation"] a.relative.inline-flex { 
                background: var(--bg) !important; color: var(--text) !important; border-color: var(--border) !important;
            }
            nav[role="navigation"] span[aria-current="page"] span {
                background: var(--accent) !important; color: white !important; border-color: var(--accent) !important;
            }
        </style>
        @endif
    @endif
</div>

<script>
    // JS Logic for filters and search
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const currentCategory = urlParams.get('category') || '';
        const currentSearch = urlParams.get('search') || '';

        // Category Pills
        const pills = document.querySelectorAll('.category-pill');
        pills.forEach(pill => {
            const pillCat = pill.getAttribute('data-category');
            if (pillCat === currentCategory) {
                pills.forEach(p => {
                    p.style.background = 'var(--bg)';
                    p.style.color = 'var(--text)';
                    p.style.borderColor = 'var(--border)';
                });
                pill.style.background = 'var(--accent)';
                pill.style.color = 'white';
                pill.style.borderColor = 'var(--accent)';
            }
            
            pill.addEventListener('click', () => {
                const category = pill.getAttribute('data-category');
                updateFilters(category, document.getElementById('searchInput').value);
            });
        });

        // Search
        const searchInput = document.getElementById('searchInput');
        const searchBtn = document.getElementById('searchBtn');
        const clearBtn = document.getElementById('clearBtn');
        
        if (currentSearch) {
            searchInput.value = currentSearch;
            clearBtn.style.display = 'block';
        }

        searchBtn.addEventListener('click', () => {
            updateFilters(currentCategory, searchInput.value);
        });

        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                updateFilters(currentCategory, searchInput.value);
            }
        });

        clearBtn.addEventListener('click', () => {
            searchInput.value = '';
            updateFilters(currentCategory, '');
        });

        // Update active filters display
        const activeFilters = document.getElementById('activeFilters');
        const filterTags = document.getElementById('filterTags');
        
        if (currentCategory || currentSearch) {
            activeFilters.style.display = 'flex';
            
            if (currentCategory) {
                const tag = document.createElement('div');
                tag.className = 'px-3 py-1 bg-blue-900 border border-blue-500 text-blue-300 text-xs font-bold rounded flex items-center gap-2';
                tag.innerHTML = `Category: ${currentCategory} <i class="fas fa-times cursor-pointer hover:text-white" onclick="updateFilters('', '${currentSearch}')"></i>`;
                filterTags.appendChild(tag);
            }
            
            if (currentSearch) {
                const tag = document.createElement('div');
                tag.className = 'px-3 py-1 bg-purple-900 border border-purple-500 text-purple-300 text-xs font-bold rounded flex items-center gap-2';
                tag.innerHTML = `Search: "${currentSearch}" <i class="fas fa-times cursor-pointer hover:text-white" onclick="updateFilters('${currentCategory}', '')"></i>`;
                filterTags.appendChild(tag);
            }
        }
    });

    function updateFilters(category, search) {
        const url = new URL(window.location.href);
        if (category) url.searchParams.set('category', category);
        else url.searchParams.delete('category');
        
        if (search) url.searchParams.set('search', search);
        else url.searchParams.delete('search');
        
        url.searchParams.delete('page'); // Reset to page 1
        
        window.location.href = url.toString();
    }

    function resetFilters() {
        window.location.href = window.location.pathname;
    }
</script>
@endsection
