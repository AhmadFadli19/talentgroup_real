@extends('layouts.app')

@section('title', 'Katalog Kursus | TalentGroup')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-6">
    
    <!-- Hero Header Section -->
    <div class="cyber-card mb-8 border border-[var(--border)] bg-white p-6 sm:p-8" style="background: linear-gradient(135deg, #ffffff, #f0f7ff);">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <p class="text-xs font-mono font-bold uppercase tracking-wider text-[var(--blue)] mb-1">
                    KELAS TERSEDIA
                </p>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[var(--ink)] tracking-tight">
                    Katalog Kursus Pemrograman
                </h1>
                <p class="text-xs sm:text-sm text-[var(--text2)] mt-1 max-w-2xl">
                    Tingkatkan skill pemrograman Anda dengan kurikulum berbasis industri mulai dari dasar hingga tingkat mahir.
                </p>
            </div>

            <!-- Stats Counters -->
            <div class="grid grid-cols-3 gap-2 sm:gap-4 w-full md:w-auto">
                <div class="px-2.5 sm:px-4 py-2 sm:py-3 rounded-xl bg-white border border-[var(--border)] text-center shadow-sm">
                    <div class="text-lg sm:text-xl font-black text-[var(--ink)] font-mono">{{ $courses->total() }}</div>
                    <div class="text-[10px] uppercase font-bold text-[var(--muted)] truncate">Total Kursus</div>
                </div>
                <div class="px-2.5 sm:px-4 py-2 sm:py-3 rounded-xl bg-white border border-[var(--border)] text-center shadow-sm">
                    <div class="text-lg sm:text-xl font-black text-emerald-600 font-mono">{{ \App\Models\Course::where('is_active', true)->where('price', 0)->count() }}</div>
                    <div class="text-[10px] uppercase font-bold text-emerald-600 truncate">Gratis</div>
                </div>
                <div class="px-2.5 sm:px-4 py-2 sm:py-3 rounded-xl bg-white border border-[var(--border)] text-center shadow-sm">
                    <div class="text-lg sm:text-xl font-black text-[var(--blue)] font-mono">{{ \App\Models\Course::where('is_active', true)->where('price', '>', 0)->count() }}</div>
                    <div class="text-[10px] uppercase font-bold text-[var(--blue)] truncate">Premium</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="cyber-card mb-8 bg-white border border-[var(--border)] p-5">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
            <!-- Category Filter -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-[var(--muted)] mb-2.5">
                    <i class="fas fa-filter text-[var(--blue)] mr-1.5"></i> Kategori Bahasa
                </label>
                <div class="flex flex-wrap gap-2" id="categoryPills">
                    <button class="px-3.5 py-1.5 text-xs font-bold rounded-lg border transition-all active bg-[var(--blue)] text-white border-[var(--blue)]" data-category="">
                        Semua
                    </button>
                    @foreach($categories as $category)
                    <button class="px-3.5 py-1.5 text-xs font-bold rounded-lg border transition-all bg-white text-[var(--text2)] border-[var(--border)] hover:border-[var(--blue)] hover:text-[var(--blue)]" data-category="{{ $category }}">
                        {{ $category }}
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- Search Bar -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-[var(--muted)] mb-2.5">
                    <i class="fas fa-search text-[var(--blue)] mr-1.5"></i> Cari Kursus
                </label>
                <div class="flex gap-2">
                    <input type="text" id="searchInput" class="cyber-input text-xs" placeholder="Ketik nama kursus atau topik pembahasan...">
                    <button id="searchBtn" class="btn btn-gradient px-5"><i class="fas fa-search"></i></button>
                    <button id="clearBtn" class="btn btn-outline" style="display: none;"><i class="fas fa-times"></i></button>
                </div>
            </div>
        </div>
    </div>

    @if ($courses->isEmpty())
        <!-- Empty State -->
        <div class="empty-prototype-box py-16 px-6 text-center shadow-sm">
            <div class="w-16 h-16 rounded-2xl empty-icon-wrap flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-[var(--blue)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                    <path d="M8 7h8"/>
                    <path d="M8 11h6"/>
                </svg>
            </div>
            <h2 class="text-lg font-bold text-[var(--ink)] mb-2">Kursus Tidak Ditemukan</h2>
            <p class="text-xs text-[var(--text2)] mb-6 max-w-md mx-auto">
                Tidak ada kursus yang sesuai dengan kata kunci atau filter pencarian Anda.
            </p>
            <button class="btn btn-outline" onclick="resetFilters()">
                <i class="fas fa-redo mr-2"></i> Reset Pencarian
            </button>
        </div>
    @else
        <!-- Active Filters Display -->
        <div id="activeFilters" class="mb-6 p-3 rounded-xl border border-[var(--border)] bg-blue-50/50 flex justify-between items-center" style="display: none;">
            <div class="flex items-center gap-2 flex-wrap">
                <span class="text-xs font-bold text-[var(--muted)]">Filter Aktif:</span>
                <div id="filterTags" class="flex gap-2 flex-wrap"></div>
            </div>
            <button class="text-xs font-bold text-rose-600 hover:underline" onclick="resetFilters()">
                Hapus Filter <i class="fas fa-times-circle ml-1"></i>
            </button>
        </div>

        <!-- Courses Grid matching tg-website card style -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            @foreach ($courses as $index => $course)
                <article class="course-card flex flex-col justify-between bg-white border border-[var(--border)] rounded-2xl overflow-hidden hover:border-[var(--blue)] transition-all shadow-sm">
                    
                    <div>
                        <!-- Cover Image & Badge -->
                        <div class="course-cover relative h-48 bg-slate-100 flex items-center justify-center overflow-hidden">
                            @if($course->image)
                                <img src="{{ $course->image_url }}" class="w-full h-full object-cover" alt="{{ $course->title }}" onerror="this.src='{{ asset('tg/assets/60-2-img-ssda.png') }}'">
                            @else
                                <img src="{{ asset('tg/assets/60-2-img-ssda.png') }}" class="w-full h-full object-cover" alt="{{ $course->title }}">
                            @endif

                            @if ($course->price < 1)
                                <span class="pill success-outline" style="position: absolute; top: 12px; right: 12px; font-weight: 800;">
                                    FREE
                                </span>
                            @else
                                <span class="pill solid" style="position: absolute; top: 12px; right: 12px; font-weight: 800;">
                                    PREMIUM
                                </span>
                            @endif
                        </div>

                        <!-- Card Body -->
                        <div class="p-5 flex flex-col gap-2">
                            <p class="text-[11px] font-mono font-bold uppercase tracking-wider text-[var(--blue)]">
                                Course Module
                            </p>
                            <h2 class="text-base font-extrabold text-[var(--ink)] line-clamp-2 leading-snug min-h-[44px]" title="{{ $course->title }}">
                                {{ $course->title }}
                            </h2>
                            <p class="text-xs text-[var(--text2)] line-clamp-2 leading-relaxed">
                                {{ $course->description }}
                            </p>
                            
                            <div class="flex items-center gap-2 text-xs text-[var(--muted)] font-medium pt-2">
                                <span><i class="fas fa-book-open text-[var(--blue)] mr-1"></i> {{ $course->questions_count ?? 1 }} Materi</span>
                                <span>·</span>
                                <span>{{ ucfirst($course->level ?? 'Semua Level') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="p-5 pt-3 border-t border-[var(--border)] flex items-center justify-between gap-3 bg-[var(--bg3)]">
                        <div>
                            <span class="text-[10px] uppercase font-bold text-[var(--muted)] block">Harga</span>
                            @if ($course->price < 1)
                                <strong class="text-base font-black text-emerald-600 font-mono">GRATIS</strong>
                            @else
                                <strong class="text-base font-black text-[var(--blue-dark)] font-mono">Rp {{ number_format($course->price, 0, ',', '.') }}</strong>
                            @endif
                        </div>
                        
                        <a href="{{ route('user.courses.show', $course->id) }}" class="btn btn-small btn-gradient">
                            Lihat Detail <i class="fas fa-arrow-right text-[10px] ml-1"></i>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Pagination -->
        @if ($courses->hasPages())
        <div class="flex justify-center items-center mt-8 gap-4 font-mono">
            {{ $courses->links() }}
        </div>
        @endif
    @endif
</div>

<script>
    // Filtering logic
    const categoryButtons = document.querySelectorAll('#categoryPills button');
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const clearBtn = document.getElementById('clearBtn');
    const courseCards = document.querySelectorAll('.course-card');
    
    let activeCategory = '';

    function filterCourses() {
        const query = searchInput.value.toLowerCase().trim();
        let visibleCount = 0;

        courseCards.forEach(card => {
            const title = card.querySelector('h2').textContent.toLowerCase();
            const desc = card.querySelector('p.text-xs').textContent.toLowerCase();
            
            const matchesQuery = !query || title.includes(query) || desc.includes(query);
            const matchesCategory = !activeCategory || title.includes(activeCategory.toLowerCase()) || desc.includes(activeCategory.toLowerCase());

            if (matchesQuery && matchesCategory) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (clearBtn) clearBtn.style.display = query ? 'inline-flex' : 'none';
    }

    categoryButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            categoryButtons.forEach(b => {
                b.classList.remove('bg-[var(--blue)]', 'text-white', 'active');
                b.classList.add('bg-white', 'text-[var(--text2)]');
            });
            btn.classList.add('bg-[var(--blue)]', 'text-white', 'active');
            btn.classList.remove('bg-white', 'text-[var(--text2)]');
            activeCategory = btn.dataset.category;
            filterCourses();
        });
    });

    if (searchInput) searchInput.addEventListener('input', filterCourses);
    if (searchBtn) searchBtn.addEventListener('click', filterCourses);
    if (clearBtn) {
        clearBtn.addEventListener('click', () => {
            searchInput.value = '';
            filterCourses();
        });
    }

    function resetFilters() {
        if (searchInput) searchInput.value = '';
        activeCategory = '';
        categoryButtons[0].click();
    }
</script>
@endsection
