<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kelas Kotlin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap"
      rel="stylesheet"
    />
    <style>
      body {
        font-family: "Inter", sans-serif;
      }
      .scrollbar-hide::-webkit-scrollbar {
        display: none;
      }
      .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
      }
    </style>
  </head>
  <body class="bg-gray-100 text-gray-800">
    <!-- BANNER SECTION -->
    <section class="bg-white rounded-lg shadow p-6 mb-10 mt-4">
      <div
        class="max-w-6xl mx-auto flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 px-4 lg:px-6"
      >
        <div class="flex flex-col lg:flex-row gap-6">
          <img
            src="{{ asset('storage/' . $kolaborasi->image) }}"
            alt="banner"
            class="w-64 rounded-md object-cover"
          />

          <div>
            <div class="flex items-center text-sm text-gray-500 space-x-2">
              <span class="text-yellow-500 font-bold">★ 4.84</span>
              <span>•</span>
              <a href="#" class="text-blue-600 underline">Android</a>
              <span>Learning Path</span>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mt-2">
              {{ $kolaborasidetail->judul }}
            </h2>
            <div class="flex items-center space-x-2 mt-2">
              <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded"
                >Android</span
              >
              <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded"
                >Flutter</span
              >
            </div>
            <div
              class="flex flex-wrap items-center text-sm text-gray-600 mt-2 space-x-4"
            >
              <div class="flex items-center">
                <span class="text-blue-600">📘</span>
                <span class="ml-1">Level: Dasar</span>
              </div>
              <div class="flex items-center">
                <span>🕒</span>
                <span class="ml-1">50 Jam Belajar</span>
              </div>
              <div class="flex items-center">
                <span>👤</span>
                <span class="ml-1">70.650 Siswa Terdaftar</span>
              </div>
            </div>
            <p class="text-gray-700 text-sm mt-3 max-w-xl">
              {{ $kolaborasidetail->topic }}
            </p>
            <div class="mt-4">
              <img
                src="https://developers.google.com/site-assets/images/developers-social-media.png"
                alt="Google Developers"
                class="w-36"
              />
            </div>
          </div>
        </div>

        <!-- Sidebar action -->
        <div class="bg-white border rounded-lg p-4 shadow-md w-full lg:w-56">
          <button onclick="window.location.href='{{ route('login') }}'"
            class="bg-blue-700 text-white w-full py-2 rounded font-semibold hover:bg-blue-600"
          >
            Belajar Sekarang
          </button>
          <button class="w-full mt-2 py-2 border rounded hover:bg-gray-100">
            Informasi kelas
          </button>
          <button class="w-full mt-2 py-2 border rounded hover:bg-gray-100">
            Lihat silabus
          </button>
        </div>
      </div>
    </section>

    <!-- KONTEN DETAIL -->
    <section class="bg-white p-6">
      <div
        class="max-w-6xl mx-auto flex flex-col lg:flex-row gap-8 px-4 lg:px-6"
      >
        <!-- KONTEN KIRI -->
        <div class="lg:w-3/4 space-y-10">
          <!-- Deskripsi -->
          <section>
            <h2 class="text-2xl font-semibold mb-3">Deskripsi</h2>
            <p class="text-justify">
              {{ $kolaborasidetail->judul_description }}
            </p>
            <ul class="list-disc pl-5 mt-3 space-y-1">
              <li>
                {{ $kolaborasidetail->description_kelas }}
              </li>
            </ul>
          </section>

          <!-- Target dan Sasaran -->
          <!-- Deskripsi -->
          <section>
            <h2 class="text-2xl font-semibold mb-3">Target & Sasaran</h2>
            <p class="text-justify">
              {{ $kolaborasidetail->target }}
            </p>
            <ul class="list-disc pl-5 mt-3 space-y-1">
              <li>
                {{ $kolaborasidetail->sasaran }}
              </li>
            </ul>
          </section>
        </div>

        <!-- KONTEN KANAN -->
        <div class="lg:w-1/4 space-y-6 text-sm">
          <!-- Peralatan -->
          <div>
            <h3 class="font-bold mb-1">Peralatan Belajar</h3>
            <p>
              <strong>🖥️ Processor</strong><br />Intel Core i3 (Rekomendasi Core
              i5 ke atas)
            </p>
            <p class="mt-2">
              <strong>🛠️ IntelliJ IDEA Community</strong><br />Cara instalasi
              akan dijelaskan pada kelas ini.
            </p>
            <a href="#" class="text-blue-600 underline mt-2 inline-block"
              >Lihat semua peralatan belajar</a
            >
          </div>

          <!-- Metode Ajar -->
          <div>
            <h3 class="font-bold mb-1">Metode Ajar</h3>
            <p><strong>Online self-learning</strong></p>
            <ol class="list-decimal pl-5 mt-2">
              <li>Total jam belajar : 50 jam</li>
              <li>Rekomendasi waktu belajar : 10 jam per minggu</li>
            </ol>
            <a href="#" class="text-blue-600 underline mt-2 inline-block"
              >Lihat semua metode ajar</a
            >
          </div>
        </div>
      </div>

      <div class="max-w-6xl mx-auto mt-10 space-y-6">
        <!-- Materi Section -->
        <div class="bg-white shadow-sm">
          <h2 class="text-red-600 font-semibold text-lg p-4 border-b">
            Materi
          </h2>
          <ul class="divide-y">
            <li class="p-4 bg-gray-100">1. Tentang Kelas</li>
            <li class="p-4 bg-gray-100">2. UX Research Basics</li>
            <li class="p-4 bg-gray-100">3. Research Brief</li>
            <li class="p-4 bg-gray-100">4. Research Plan</li>
            <li class="p-4 bg-gray-100">5. Collect Research Data</li>
            <li class="p-4 bg-gray-100">6. Synthesis and Analysis</li>
            <li class="p-4 bg-gray-100">7. Research Report</li>
            <li class="p-4 bg-gray-100">8. Research Impact Tracking</li>
            <li class="p-4 bg-gray-100">9. Highlight & Summary</li>
          </ul>
        </div>

        <!-- Persiapan Kelas Section -->
        <div class="bg-white border rounded-lg shadow-sm p-6">
          <h2 class="text-red-600 font-semibold text-lg mb-2">
            Persiapan Kelas
          </h2>
          <p class="mb-3">
            Untuk memudahkan kamu dalam mengikuti kelas ini, kamu diharapkan
            <strong>sudah cukup tahu</strong> konsep dasar dari
            <strong>proses design thinking</strong>.
          </p>
          <p class="mb-3">
            Kamu juga direkomendasikan, untuk dapat mengikuti kelas
            <a href="#" class="text-blue-600 hover:underline font-semibold"
              >UI/UX Design Mastery</a
            >
            di Skilvul sebelumnya — untuk bisa menambah wawasan kamu di dunia
            UI/UX Design.
          </p>
          <p class="mb-2">
            Terdapat beberapa <em>tools</em> yang perlu diperhatikan peserta
            kelas UX Research Mastery ini, antara lain:
          </p>
          <ul class="list-disc pl-6 text-blue-600 space-y-1">
            <li><a href="#" class="hover:underline">Figma</a></li>
            <li><a href="#" class="hover:underline">Google Spreadsheet</a></li>
            <li><a href="#" class="hover:underline">Google Docs</a></li>
            <li><a href="#" class="hover:underline">Google Slide</a></li>
            <li><a href="#" class="hover:underline">Google Form</a></li>
          </ul>
        </div>
      </div>
    </section>
  </body>
</html>
