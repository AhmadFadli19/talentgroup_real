@extends('layout')

@section('content')
    <section class="ln-latest-news-section">
        <div class="ln-container">
          <!-- Heading -->
          <div class="ln-row ln-align-items-center ln-mb-5">
            <div class="ln-col-lg-6">
              <div class="ln-section-heading">
                <h2>
                  Check Out What Is <em>Trending</em> In Our Latest <span>News</span>
                </h2>
              </div>
            </div>
          </div>
      
          <!-- Main Content -->
          <div class="ln-row ln-gy-4">
            <!-- Left Banner -->
            @foreach ($kolaborasi->where('category', 'Upbanner') as $item)
            <div class="ln-col-lg-6">
              <div class="ln-left-image-card">
                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" />
                <div class="ln-info-box">
                  <ul class="ln-meta-info">
                    <li><i class="fa fa-calendar"></i> 24 Mar 2021</li>
                    <li><i class="fa fa-users"></i> TemplateMo</li>
                    <li><i class="fa fa-folder"></i> Branding</li>
                  </ul>
                  <h4>SEO Agency &amp; Digital Marketing</h4>
                  <p>Lorem ipsum dolor sit amet, consectetur and sed doer ket eismod tempor incididunt ut labore et dolore magna...</p>
                  <a href="#" class="ln-main-btn">Discover More</a>
                </div>
              </div>
            </div>
            @endforeach
      
            <!-- Right Blog List -->
            <div class="ln-col-lg-6">
              <div class="ln-blog-list">
                <!-- Blog Item -->
                @foreach ($kolaborasi->where('category', 'Downbanner') as $item)
                <div class="ln-blog-item">
                  <div class="ln-content">
                    <span><i class="fa fa-calendar"></i> 18 Mar 2021</span>
                    <h5><a href="kolaborasi/{{ $item->create_view }}">New Websites &amp; Backlinks</a></h5>
                    <p>Lorem ipsum dolor sit amsecteturii and sed doer ket eismod...</p>
                  </div>
                  <div class="ln-thumb">
                    <img src="{{ asset('storage/' . $item->image ) }}" alt="Blog Image" />
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </section>
      
    
    <div style="margin-top: 200px;">
        <section class="skilvul-section">
            <div class="container">
                <div class="content">
                    <div class="image-wrapper">
                        <img src="{{ asset('assets/images/Perkumpulan.jpg') }}" alt="talentgruop Image" />
                    </div>
                    <div class="text-wrapper">
                        <h1>
                            TalentGroup Percaya Bahwa Pendidikan Adalah Kunci Bagi <br />
                            Kemajuan Indonesia
                        </h1>
                        <p>
                            TalentGroup memiliki mimpi yang sedang direalisasikan untuk mencetak
                            <strong>1 Juta Talenta Digital</strong> yang kompeten, kreatif, dan
                            berdaya saing tinggi, siap untuk menghadapi tantangan dan peluang di era digital.
                        </p>
                        <div class="stats">
                            <div class="stat">
                                <h2>136K+</h2>
                                <p>Talenta Digital</p>
                            </div>
                            <div class="divider"></div>
                            <div class="stat">
                                <h2>74</h2>
                                <p>Total Partner</p>
                            </div>
                            <div class="divider"></div>
                            <div class="stat">
                                <h2>44</h2>
                                <p>Total Program</p>
                            </div>
                            <div class="divider"></div>
                            <div class="stat">
                                <h2>33</h2>
                                <p>Total Kelas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection

