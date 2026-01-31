@extends('layout')

@section('content')
    <!-- BANNER -->
    <section class="main-banner">
        <div class="container-full">
            <div class="content">
                <div class="text-left">
                    <h6>WELCOME TO TALENTGROUP</h6>
                    <h1>
                        Raih Ilmu Tanpa <span class="blue">Batas</span> <span class="and">&</span><br />
                        Wujudkan Potensi Digital <span class="blue">Teratas</span>
                    </h1>
                    <p>#TumbuhBersamaTalentGroup untuk menguasai skill digital dan membuka peluang karier terbaikmu.</p>
                </div>
                <div class="image-righ  t">
                    <img src="{{ asset('assets/images/banner-right-image.png') }}" alt="team meeting" />
                </div>
            </div>
        </div>
    </section>

    <section class="carousel-tema">
        <div class="flex justify-center">
            <div id="controls-carousel" class="relative w-full max-w-4xl mx-auto overflow-hidden rounded-lg">
                <div class="relative h-56 md:h-96">
                    @foreach ($slidebanner as $key => $item)
                        <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0 z-0"
                            data-carousel-item>
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}"
                                class="w-full h-full object-contain rounded-lg" alt="Slide {{ $key + 1 }}">
                        </div>
                    @endforeach
                </div>

                <!-- Slider controls -->
                <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 group"
                    data-carousel-prev>
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 hover:bg-white/60">
                        <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 1 1 5l4 4" />
                        </svg>
                    </span>
                </button>
                <button type="button"
                    class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 group"
                    data-carousel-next>
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 hover:bg-white/60">
                        <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                    </span>
                </button>
            </div>
        </div>
    </section>

    <div class="scroll-container">
        <div class="scroll-content" id="scroll-track">
            <div class="card">IoT</div>
            <div class="card">Frontend</div>
            <div class="card">Web Development</div>
            <div class="card">3D Animation</div>
            <div class="card">Digital Marketing</div>
            <div class="card">Artificial Intelligence</div>
            <div class="card">UI/UX</div>
            <div class="card">Programming</div>
            <div class="card">Mobile Development</div>

            <!-- Duplicate for infinite effect -->
            <div class="card">IoT</div>
            <div class="card">Frontend</div>
            <div class="card">Web Development</div>
            <div class="card">3D Animation</div>
            <div class="card">Digital Marketing</div>
            <div class="card">Artificial Intelligence</div>
            <div class="card">UI/UX</div>
            <div class="card">Programming</div>
            <div class="card">Mobile Development</div>
        </div>
    </div>

    <section class="why-dicoding">
        <div class="container">
            <div class="text-section">
                <h2>Kenapa TalentGroup Academy Berbeda</h2>
                <p>
                    Saatnya bijak memilih sumber belajar. Tak hanya materi yang terjamin,<br />
                    TalentGroup Academy juga memiliki reviewer profesional yang akan mengulas kode Anda.
                </p>
                <div class="accordion">
                    <div class="accordion-item active">
                        <button class="accordion-title">Kurikulum standar industri global</button>
                        <div class="accordion-content">
                            <p>Kurikulum dikemba    ngkan bersama perusahaan dan pemilik teknologi dunia sesuai kebutuhan
                                industri terkini.</p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button class="accordion-title">Belajar fleksibel sesuai jadwal Anda</button>
                        <div class="accordion-content">
                            <p>Belajar bisa di mana saja dan kapan saja, sesuai dengan jadwal Anda.</p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button class="accordion-title">Code Review dari Developer Expert</button>
                        <div class="accordion-content">
                            <p>Kode Anda akan ditinjau oleh reviewer berpengalaman di bidangnya.</p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button class="accordion-title">Alumni terpercaya di berbagai perusahaan</button>
                        <div class="accordion-content">
                            <p>Alumni kami telah bekerja di perusahaan teknologi ternama.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="image-section">
                <img src="{{ asset('assets/images/perkumpulan.jpg') }}" alt="Developer" />
                <div class="badge android">📱 Android Development</div>
                <div class="badge web">🌐 Web Development</div>
                <div class="badge cloud">☁️ Cloud Computing</div>
            </div>
        </div>
    </section>

    <script>
        const accordionItems = document.querySelectorAll(".accordion-item");

        accordionItems.forEach(item => {
            const title = item.querySelector(".accordion-title");

            title.addEventListener("click", () => {
                accordionItems.forEach(i => {
                    if (i !== item) i.classList.remove("active");
                });
                item.classList.toggle("active");
            });
        });
    </script>

    <!-- TABS -->
    <div class="tab-buttons">
        <button class="tab-button active" data-tab="freelance">Freelance Academy</button>
        <button class="tab-button" data-tab="mini">Mini Bootcamp</button>
        <button class="tab-button" data-tab="jobready">Job-ready Bootcamp</button>
    </div>

    <!-- TAB CONTENT -->

    <div class="tab-content active" id="freelance">
        <div class="tab-title">Freelance Academy</div>
        <div class="tab-desc">Program freelance untuk kamu yang ingin mulai menghasilkan dari skill digitalmu.</div>
        <div class="card-wrapper">
            @foreach ($bannerCard->where('category', 'freelance') as $item)
                <div class="bootcamp-card">
                    <div class="bootcamp-card-image">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                    </div>
                    <div class="bootcamp-card-content">
                        <h4>{{ $item->title }}</h4>
                        <div class="bootcamp-card-description">
                            {{ $item->description }}
                        </div>
                        <a href="bannercard/{{ $item->create_view }}" class="unggulan-purchase-btn">Lihat Detail</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="tab-content" id="mini">
        <div class="tab-title">Mini Bootcamp</div>
        <div class="tab-desc">Pelatihan singkat untuk membangun portofolio dan dasar karier digital kamu.</div>
        <div class="card-wrapper">
            @foreach ($bannerCard->where('category', 'mini_bootcamp') as $item)
                <div class="bootcamp-card">
                    <div class="bootcamp-card-image">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                    </div>
                    <div class="bootcamp-card-content">
                        <h4>{{ $item->title }}</h4>
                        <div class="bootcamp-card-description">
                            {{ $item->description }}
                        </div>
                        <a href="bannercard/{{ $item->create_view }}" class="unggulan-purchase-btn">Lihat Detail</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="tab-content" id="jobready">
        <div class="tab-title">Job-ready Bootcamp</div>
        <div class="tab-desc">Pelatihan intensif selama 16 minggu untuk persiapan karier Web Dev & UI/UX kamu.</div>
        <div class="card-wrapper">
            @foreach ($bannerCard->where('category', 'ready_bootcamp') as $item)
                <div class="bootcamp-card">
                    <div class="bootcamp-card-image">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                    </div>
                    <div class="bootcamp-card-content">
                        <h4>{{ $item->title }}</h4>
                        <div class="bootcamp-card-description">
                            {{ $item->description }}
                        </div>
                        <a href="bannercard/{{ $item->create_view }}" class="unggulan-purchase-btn">Lihat Detail</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="unggulan-wrapper">
        <div class="unggulan-top-section">
            <h1 class="unggulan-title">Kelas Unggulan</h1>
            <a href="#" class="unggulan-link">Lihat Semua ></a>
        </div>

        <div class="unggulan-slider-box">
            <button class="unggulan-nav-btn unggulan-nav-left" onclick="slideKiri()">‹</button>
            <button class="unggulan-nav-btn unggulan-nav-right" onclick="slideKanan()">›</button>

            <div class="unggulan-cards-track" id="cardTrack">
                @foreach ($slidecard as $card)
                    <div class="unggulan-single-card">
                        <div class="unggulan-card-top">
                            <img src="{{ asset('storage/' . $card->image) }}" alt="{{ $card->title }}"
                                style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; z-index: 1;">
                            @if ($card->best_seller)
                                <div class="unggulan-top-label unggulan-seller-tag" style="z-index: 2;">⭐ Best Seller
                                </div>
                            @endif
                            @if ($card->created_at->diffInDays() <= 7)
                                <div class="unggulan-top-label unggulan-fresh-tag" style="top: 50px; z-index: 2;">✨ Baru
                                </div>
                            @endif
                            <div></div>
                            <div class="unggulan-level-info" style="z-index: 2; position: relative;">
                                <div class="unggulan-level-dot">📚</div>
                                <span>1 Materi</span>
                            </div>
                        </div>
                        <div class="unggulan-card-bottom">
                            <h3 class="unggulan-course-name">{{ $card->title }}</h3>
                            <div class="unggulan-meta-info">
                                <div class="unggulan-info-item unggulan-beginner">
                                    <div class="unggulan-info-dot">🟢</div>
                                    <span>Pemula (1815 Ulasan)</span>
                                </div>
                                <div class="unggulan-info-item unggulan-cert">
                                    @if ($card->certificate == 'ya')
                                        <span>🏆sertifikat</span>
                                    @else
                                        <span>❌ sertifikat</span>
                                    @endif
                                </div>
                            </div>
                            <div class="unggulan-cost-area">
                                <div class="unggulan-cost">{{ $card->price }}</div>
                                <a href="cards/{{ $card->create_view }}" class="unggulan-purchase-btn">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

    <script>
        const slides = document.querySelectorAll('[data-carousel-item]');
        let currentSlide = 0;
        let totalSlides = slides.length;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                if (i === index) {
                    slide.classList.add('opacity-100', 'z-10');
                    slide.classList.remove('opacity-0', 'z-0');
                } else {
                    slide.classList.remove('opacity-100', 'z-10');
                    slide.classList.add('opacity-0', 'z-0');
                }
            });
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            showSlide(currentSlide);
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            showSlide(currentSlide);
        }

        document.querySelector('[data-carousel-next]').addEventListener('click', nextSlide);
        document.querySelector('[data-carousel-prev]').addEventListener('click', prevSlide);

        showSlide(currentSlide);

        // Auto-play every 3 seconds
        setInterval(nextSlide, 3000);
    </script>

    <!-- JAVASCRIPT TABS -->
    <script>
        const buttons = document.querySelectorAll('.tab-button');
        const contents = document.querySelectorAll('.tab-content');

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                buttons.forEach(btn => btn.classList.remove('active'));
                contents.forEach(content => content.classList.remove('active'));

                button.classList.add('active');
                document.getElementById(button.dataset.tab).classList.add('active');
            });
        });
    </script>

    <script>
        let currentPosition = 0;
        const cardTrack = document.getElementById('cardTrack');
        const allCards = document.querySelectorAll('.unggulan-single-card');
        const totalCards = allCards.length;
        const cardWidth = 290 + 20; // Card width + gap

        function calculateMaxPosition() {
            const visibleWidth = document.querySelector('.unggulan-slider-box').offsetWidth;
            const cardsVisible = Math.floor(visibleWidth / cardWidth);
            return Math.max(0, totalCards - cardsVisible);
        }

        function updateTrackPosition() {
            const moveDistance = -currentPosition * cardWidth;
            cardTrack.style.transform = `translateX(${moveDistance}px)`;
        }

        function slideKanan() {
            const maxPosition = calculateMaxPosition();
            if (currentPosition < maxPosition) {
                currentPosition++;
                updateTrackPosition();
            }
        }

        function slideKiri() {
            if (currentPosition > 0) {
                currentPosition--;
                updateTrackPosition();
            }
        }

        // Touch events for mobile
        let touchStartX = 0;
        let touchCurrentX = 0;
        let isTouching = false;

        cardTrack.addEventListener('touchstart', (e) => {
            touchStartX = e.touches[0].clientX;
            isTouching = true;
        });

        cardTrack.addEventListener('touchmove', (e) => {
            if (!isTouching) return;
            touchCurrentX = e.touches[0].clientX;
            const touchDiff = touchStartX - touchCurrentX;

            if (Math.abs(touchDiff) > 50) {
                if (touchDiff > 0) {
                    slideKanan();
                } else {
                    slideKiri();
                }
                isTouching = false;
            }
        });

        cardTrack.addEventListener('touchend', () => {
            isTouching = false;
        });

        // Mouse events for desktop
        let mouseStartX = 0;
        let mouseCurrentX = 0;
        let isMouseDown = false;

        cardTrack.addEventListener('mousedown', (e) => {
            mouseStartX = e.clientX;
            isMouseDown = true;
            cardTrack.style.cursor = 'grabbing';
        });

        cardTrack.addEventListener('mousemove', (e) => {
            if (!isMouseDown) return;
            mouseCurrentX = e.clientX;
            const mouseDiff = mouseStartX - mouseCurrentX;

            if (Math.abs(mouseDiff) > 100) {
                if (mouseDiff > 0) {
                    slideKanan();
                } else {
                    slideKiri();
                }
                isMouseDown = false;
                cardTrack.style.cursor = 'grab';
            }
        });

        cardTrack.addEventListener('mouseup', () => {
            isMouseDown = false;
            cardTrack.style.cursor = 'grab';
        });

        cardTrack.addEventListener('mouseleave', () => {
            isMouseDown = false;
            cardTrack.style.cursor = 'grab';
        });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                slideKiri();
            } else if (e.key === 'ArrowRight') {
                slideKanan();
            }
        });

        // Handle window resize
        window.addEventListener('resize', () => {
            currentPosition = 0;
            updateTrackPosition();
        });

        // Initialize
        cardTrack.style.cursor = 'grab';
        updateTrackPosition();
    </script>

    <script>
        const toggle = document.querySelector('.menu-toggle');
        const nav = document.querySelector('.main-nav');

        toggle.addEventListener('click', () => {
            nav.classList.toggle('active');
        });
    </script>
@endsection
