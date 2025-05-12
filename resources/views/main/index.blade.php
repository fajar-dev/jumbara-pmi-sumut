@extends('layouts.main')

@section('seo')
  <meta
  name="keywords"
  content="tracer, study, university, malikussaleh, unimal, universitas, bkk, upt, alumni, mahasiswa, dosen, survey, kuisioner"
  />
  <meta name="author" content="Universitas Malikussaleh" />
  <meta name="description" content="Selamat Datang Di Website Tracer Study Universitas Malikussaleh" />

  <!-- Open Graph Meta Tags -->
  <meta property="og:url" content="{{ route('home') }}" />
  <meta property="og:title" content="Tracer Study | {{ $title }} @if($subTitle) - {{ $subTitle }} @endif" />
  <meta property="og:type" content="article" />
  <meta property="og:image" content="{{ asset('icon/selamat-datang.png') }}" />
  <meta
    property="og:description"
    content="Selamat Datang Di Website Tracer Study Universitas Malikussaleh"
  />
  <meta property="og:locale" content="id_ID" />

  <!-- Twitter Card Meta Tags -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="Tracer Study | {{ $title }} @if($subTitle) - {{ $subTitle }} @endif" />
  <meta
    name="twitter:description"
    content="Selamat Datang Di Website Tracer Study Universitas Malikussaleh"
  />
  <meta name="twitter:image" content="{{ asset('icon/selamat-datang.png') }}" />

  <!-- Additional SEO Meta Tags -->
  <meta name="distribution" content="global" />
  <meta name="revisit-after" content="7 days" />
  <meta name="rating" content="general" />
  <meta name="language" content="Indonesian" />
  <meta name="geo.region" content="ID" />
  <meta name="geo.placename" content="Lhokseumawe" />

  <!-- Canonical Tag -->
  <link rel="canonical" href="{{ route('home') }}" />
@endsection

@section('content')
  <div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
      <div class="px-lg-20 mx-lg-20">
        <div class="row g-5 mb-20">
          <div class="col-xl-12">
            <div class="card bg-danger bg-opacity-15 h-md-100" dir="ltr">
              <div class="card-body d-flex justify-content-center">
                <div class="d-md-flex align-items-center pe-lg-5">
                  <div class="pe-lg-20">
                    <h1 class="fw-semibold text-gray-800 fs-lg-3hx fs-md-2hx">Jumbara XXI PMR-PMI
                      <br />
                      <span class="fw-bolder">Provinsi Sumatera Utara</span>
                    </h1>
                    <div class="mb-1 mt-5">
                      <a class="btn btn-lg btn-danger me-2" data-bs-target="#kt_modal_create_app" data-bs-toggle="modal">Isi Survey</a>
                    </div>
                  </div>
                  <div class="ps-lg-20">
                    <img src="{{ asset('app/media/svg/illustrations/easy/9.svg') }}" class="w-lg-400px w-md-300px" alt="" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xl-12">
            <div class="mb-17">
              <div class="d-flex flex-stack mb-5">
                <h1 class="text-gray-900 fs-2qx">News & Article</h1>
                <a href="{{ route('news') }}" class="fs-6 fw-semibold link-danger">See More</a>
              </div>
              <div class="separator separator-dashed mb-9"></div>
              <div class="row">
                @foreach ($news as $index => $item)
                    @if ($index == 0)
                        <div class="col-md-6 pb-10">
                            <div class="card-xl-stretch me-md-6">
                                <div class="d-block bgi-no-repeat bgi-size-cover bgi-position-center card-rounded position-relative min-h-350px mb-5" style="background-image:url('{{ Storage::url($item->thumbnail_path) }}')" data-fslightbox="lightbox-video-tutorials" href="https://www.youtube.com/embed/btornGtLwIo">
                                </div>
                                <div class="m-0">
                                    <a href="{{ route('news.show', $item->slug) }}" class="fs-1 text-gray-900 fw-bold text-hover-danger text-gray-900 lh-base">{{ $item->title }}</a>
                                    <div class="fw-semibold fs-5 text-gray-600 text-gray-900 my-4 d-none d-md-block">
                                        {!! Str::limit(strip_tags($item->content), 300) !!}
                                    </div>
                                    <div class="d-flex flex-stack flex-wrap">    
                                        <div class="d-flex align-items-center pe-2">
                                            <div class="symbol symbol-35px symbol-circle me-3">
                                                <img alt="" src="{{ optional($item->user)->photo_path ? Storage::url($item->user->photo_path) : 'https://ui-avatars.com/api/?background=DFFFEA&color=04B440&bold=true&name='. (optional($item->user)->name ?? 'admin') }}" />
                                            </div>           
                                            <div class="fs-5 fw-bold">
                                                <span class="text-gray-700">{{ optional($item->user)->name ?? 'admin' }}</span>
                                                <span class="text-muted">on {{ \Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</span>                   
                                            </div>
                                        </div>
                                        <span class="badge badge-light-danger fw-bold my-2">{{ $item->newsCategory->name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

                <div class="col-md-6">
                    <div class="row">
                        @foreach ($news as $index => $item)
                            @if ($index >= 1)
                                <div class="col-md-6 pb-10">
                                    <div class="card-xl-stretch me-md-6">
                                        <div class="d-block bgi-no-repeat bgi-size-cover bgi-position-center card-rounded position-relative min-h-175px mb-5" style="background-image:url('{{ Storage::url($item->thumbnail_path) }}')" data-fslightbox="lightbox-video-tutorials" href="https://www.youtube.com/embed/btornGtLwIo">
                                        </div>
                                        <div class="m-0">
                                            <a href="{{ route('news.show', $item->slug) }}" class="fs-4 text-gray-900 fw-bold text-hover-danger text-gray-900 lh-base">{{ $item->title }}</a>
                                            <div class="d-flex flex-stack flex-wrap">    
                                                <div class="d-flex align-items-center pe-2">
                                                    <div class="symbol symbol-35px symbol-circle me-3">
                                                        <img alt="" src="{{ optional($item->user)->photo_path ? Storage::url($item->user->photo_path) : 'https://ui-avatars.com/api/?background=FFEEF3&color=F8285A&bold=true&name='. (optional($item->user)->name ?? 'admin') }}" />
                                                    </div>           
                                                    <div class="fs-5 fw-bold">
                                                        <span class="text-gray-700">{{ optional($item->user)->name ?? 'admin' }}</span>
                                                        <span class="text-muted">on {{ \Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</span>                   
                                                    </div>
                                                </div>
                                                <span class="badge badge-light-danger fw-bold my-2">{{ $item->newsCategory->name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="d-flex flex-stack flex-wrap flex-md-nowrap card-rounded shadow p-8 p-lg-12 mb-10 bg-danger mb-17">
          <div class="my-2 me-5">
            <div class="fs-1 fs-lg-2qx fw-bold text-white mb-2">Mari sukseskan pelaksanaan Tracer Study <br> Universitas Malikussaleh</div>
          </div>
          <a href="{{ route('survey') }}" class="btn btn-lg btn-outline border-2 btn-outline-white text-white flex-shrink-0 my-2">Isi Survey</a>
        </div>
        <div class="row">
          <div class="col-xl-12">
            <div class="mb-17">
              <div class="card">
                <div class="card-body p-lg-17">
                  <div class="row">
                    <div class="col-md-6 pe-lg-10">
                      <form action="{{ route('message.store') }}" class="form mb-15" method="post" id="kt_contact_form">
                        @csrf
                        <h1 class="fw-bold text-gray-900 mb-9">Send Us Email</h1>
                        <div class="d-flex flex-column mb-5 fv-row">
                          <label class="fs-5 fw-semibold mb-2">Name</label>
                          <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{ old('name') }}" />
                          @error('name')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                        <div class="d-flex flex-column mb-5 fv-row">
                          <label class="fs-5 fw-semibold mb-2">Email</label>
                          <input class="form-control form-control-solid" placeholder="" type="email" name="email" value="{{ old('email') }}" />
                          @error('email')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                        <div class="d-flex flex-column mb-10 fv-row">
                          <label class="fs-6 fw-semibold mb-2">Message</label>
                          <textarea class="form-control form-control-solid" rows="6" name="message" placeholder="">{{ old('message') }}</textarea>
                          @error('message')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                        <button type="submit" class="btn btn-danger" id="kt_contact_submit_button">
                          <span class="indicator-label">Send Feedback</span>
                          <span class="indicator-progress">Please wait... 
                          <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                      </form>
                    </div>
                    <div class="col-md-6 ps-lg-10">
                      <div id="kt_contact_map" class="w-100 rounded mb-2 mb-lg-0 mt-2" style="height: 486px">
                        <iframe class="rounded w-100 h-100" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d470.97490614644727!2d97.14745739462784!3d5.181807610174127!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x304783320edfc2af%3A0xc2aa2701354d56cc!2sCareer%20Development%20Center%20(CDC)%20Universitas%20Malikussaleh!5e0!3m2!1sid!2sid!4v1734506639893!5m2!1sid!2sid" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                      </div>
                    </div>
                  </div>
                  <div class="row g-5 mb-5 ">     
                    <div class="col-sm-6 pe-lg-10">
                        <div class="bg-light card-rounded d-flex flex-column flex-center flex-center p-10 h-100">     
                            <i class="ki-outline ki-briefcase fs-3tx text-danger"></i> 
                            <h1 class="text-gray-900 fw-bold my-5">
                                Narahubung
                            </h1>
                            <div class="text-gray-700 fw-semibold fs-2">
                                1 (833) 597-7538
                            </div>
                        </div>
                    </div>
                
                    <div class="col-sm-6 ps-lg-10">
                        <div class="text-center bg-light card-rounded d-flex flex-column flex-center p-10 h-100">     
                            <i class="ki-outline ki-geolocation fs-3tx text-danger"></i>                
                            <h1 class="text-gray-900 fw-bold my-5">
                                Sekretriat
                            </h1>
                            <div class="text-gray-700 fs-3 fw-semibold">
                                Churchill-laan 16 II, 1052 CD, Amsterdam
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
