@extends('layout')

@section('content')
<!-- BANNER -->
{{-- 
    <section class="blog-banner">
        <div class="text">
            <h1>Temukan Insight Baru<br><span>dari Blog Skilvul</span></h1>
            <p>Baca blog inspiratif dari Skilvul dan perluas wawasanmu tentang dunia teknologi, desain, dan pengembangan
                diri.</p>
        </div>
        <div class="image">
            <img src="{{ asset('assets/images/banner-background.svg') }}" alt="Blog Illustration" />
        </div>
    </section> --}}


    {{-- <section class="blog-cards">
        <div class="card">
            <div class="card-img">
                <img src={{ asset('assets/images/6bahasa.png') }} alt="Blog 1" />
            </div>
            <div class="card-content">
                <p class="author">Alfi Istiqomah | Selasa, 03 Desember 2024</p>
                <h3>6 Bahasa Pemrograman Populer yang Wajib Dipelajari Pemula</h3>
                <p class="desc">Bahasa pemrograman adalah sekumpulan instruksi kepada komputer untuk melakukan tugas
                    tertentu...</p>
                <a href="#" class="btn">Baca Selengkapnya</a>
            </div>
        </div>

        <div class="card">
            <div class="card-img">
                <img src="https://skilvul.com/_next/image?url=https%3A%2F%2Fcdn.skilvul.com%2Fblog%2Fui-card-design.jpg&w=640&q=75"
                    alt="Blog 2" />
            </div>
            <div class="card-content">
                <p class="author">Alfi Istiqomah | Kamis, 29 Agustus 2024</p>
                <h3>Cara Membuat Desain UI Card yang Ramah Pengguna</h3>
                <p class="desc">Desain UI Card adalah elemen grafis penting dalam UI/UX Design. Simak cara menyusunnya
                    di sini.</p>
                <a href="#" class="btn">Baca Selengkapnya</a>
            </div>
        </div>

        <div class="card">
            <div class="card-img">
                <img src="https://skilvul.com/_next/image?url=https%3A%2F%2Fcdn.skilvul.com%2Fblog%2Fmentor-skilvul.jpg&w=640&q=75"
                    alt="Blog 3" />
            </div>
            <div class="card-content">
                <p class="author">Ida Kholifatur Rohmah | Kamis, 29 Agustus 2024</p>
                <h3>Jadi Mentor di Skilvul: Ubah Kompetensi Jadi Dampak Lintas Generasi</h3>
                <p class="desc">Skilvul menciptakan ekosistem mentor-mentee yang tumbuh bersama. Baca cerita
                    lengkapnya.</p>
                <a href="#" class="btn">Baca Selengkapnya</a>
            </div>
        </div>

        <div class="card">
            <div class="card-img">
                <img src="https://via.placeholder.com/640x360" alt="Blog 4" />
            </div>
            <div class="card-content">
                <p class="author">John Doe | Jumat, 01 November 2024</p>
                <h3>Tips Menjadi Frontend Developer Profesional</h3>
                <p class="desc">Frontend Developer adalah profesi penting dalam teknologi. Pelajari bagaimana
                    memulainya.</p>
                <a href="#" class="btn">Baca Selengkapnya</a>
            </div>
        </div>

        <!-- Tambahkan card tambahan di bawah sini jika dibutuhkan -->
    </section> --}}

    <section class="blog-section-cards">
        @foreach ($slideblogger as $item)
        <div class="blog-card">
            <div class="blog-card-img">
                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" />
            </div>
            <div class="blog-card-content">
                <p class="blog-author">{{ $item->blog_author}} | {{ $item->created_at }}</p>
                <h3 class="blog-title">{{ $item->title }}</h3>
                <p class="blog-desc">{{ $item->description }}</p>
                <a href="slideblogger/{{ $item->create_view }}" class="blog-btn">Baca Selengkapnya</a>
            </div>
        </div>
        @endforeach
    </section>
@endsection