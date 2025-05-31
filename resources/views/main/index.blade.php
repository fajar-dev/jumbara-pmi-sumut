@extends('layouts.main')

@section('seo')
  <meta
  name="keywords"
  content="pmi, palang merah indonesia, palang merah, pmr, pmr sumut, pmi sumut, jumpa bakti gembira, jumbara, jumbara v, jumbara v pmi sumut, ifrc, icrc" />
  <meta name="author" content="PMI Provinsi Sumatera Utara" />
  <meta name="description" content="JUMPA BAKTI GEMBIRA V PMR-PMI PROVINSI SUMATERA UTARA Tahun 2025" />

  <!-- Open Graph Meta Tags -->
  <meta property="og:url" content="{{ route('home') }}" />
  <meta property="og:title" content="JUMBARA V PMI SUMUT | {{ $title }} @if($subTitle) - {{ $subTitle }} @endif" />
  <meta property="og:type" content="article" />
  <meta property="og:image" content="{{ asset('icon/selamat-datang.png') }}" />
  <meta
    property="og:description"
    content="JUMPA BAKTI GEMBIRA V PMR-PMI PROVINSI SUMATERA UTARA Tahun 2025"
  />
  <meta property="og:locale" content="id_ID" />

  <!-- Twitter Card Meta Tags -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="JUMBARA V PMI SUMUT | {{ $title }} @if($subTitle) - {{ $subTitle }} @endif" />
  <meta
    name="twitter:description"
    content="JUMPA BAKTI GEMBIRA V PMR-PMI PROVINSI SUMATERA UTARA Tahun 2025"
  />
  <meta name="twitter:image" content="{{ asset('icon/selamat-datang.png') }}" />

  <!-- Additional SEO Meta Tags -->
  <meta name="distribution" content="global" />
  <meta name="revisit-after" content="7 days" />
  <meta name="rating" content="general" />
  <meta name="language" content="Indonesian" />
  <meta name="geo.region" content="ID" />
  <meta name="geo.placename" content="Langkat" />

  <!-- Canonical Tag -->
  <link rel="canonical" href="{{ route('home') }}" />
@endsection

@section('content')
  <div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
      <div class="px-xxl-20 mx-xxl-20">
        <div class="row g-5 mb-20">
          <div class="col-xl-12">
            <div class="h-md-100 card bg-light-danger" dir="ltr">
              <div class="card-body d-flex justify-content-center">
                <div class="d-md-flex align-items-center">
                  <div class="pe-xl-10 pt-10 pt-md-0">
                    <img src="{{ Storage::url($setting->logo) }}" class="w-lg-600px w-100 w-md-300px" alt="" />
                  </div>
                  <div class=" text-center text-md-start">
                    <h1 class="fs-lg-4hx fs-1hx fw-bolder text-danger">{{ $setting->title }}
                    </h1>
                    <span class="fw-semibold fs-lg-2hx fs-md-2 fs-5 fw-bold">{!! $setting->subtitle !!}</span> <br>
                    {{-- @php
                        use Illuminate\Support\Carbon;

                        $start = Carbon::parse($setting->event_start);
                        $end = Carbon::parse($setting->event_end);
                    @endphp

                    <span class="fw-semibold fs-2 text-gray-700">
                        {{ ucfirst(strtolower($setting->location)) }}, {{ $start->day }} - {{ $end->day }} {{ $end->translatedFormat('F Y') }}
                    </span> --}}
                    <div class="mb-1 mt-5">
                      <a href="{{ Storage::url($setting->guidebook) }}" target="_blank" class="btn btn-xl btn-danger me-2">
                        <i class="ki-duotone ki-exit-down fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        </i>
                        Unduh Juknis
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row mb-20">
            <div class="col-lg-4 col-md-4 mt-5">
              <div class="card card-flush h-xl-100" style="background-color: #7239EA;background-image:url('{{ asset('app/media/svg/shapes/wave-bg-purple.svg') }}')">
                <div class="card-body">
                    <div class="fw-bold text-white text-end py-2">
                        <span class="fs-3hx d-block">{{ number_format($participantCount) }}</span>
                        <span>Total Peserta</span>
                    </div>          
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 mt-5">
              <div class="card card-flush h-xl-100" style="background-color: #F6C000;background-image:url('{{ asset('app/media/svg/shapes/wave-bg-yellow.svg') }}')">
                <div class="card-body">
                    <div class="fw-bold text-white text-end py-2">
                        <span class="fs-3hx d-block">{{ number_format( $contingentCount) }}</span>
                        <span>Total Kontingent</span>
                    </div>          
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 mt-5">
              <div class="card card-flush h-xl-100" style="background-color: #17C653;background-image:url('{{ asset('app/media/svg/shapes/wave-bg-green.svg') }}')">
                <div class="card-body">
                    <div class="fw-bold text-white text-end py-2">
                        <span class="fs-3hx d-block">{{ number_format($activityCount) }}</span>
                <span>Total Kegiatan</span>
            </div>          
        </div>
      </div>
    </div>
  </div>

        <div class="row" id="kegiatan" data-kt-scroll-offset="{default: 100, lg: 150}">
          <div class="col-12">
            <div class="mb-17">
              <div class="text-center mb-17">
                <h3 class="fs-2hx text-gray-900 mb-2">
                  Kegiatan
                </h3>
                {{-- <div class="fs-5 text-muted fw-bold"></div> --}}
              </div>
              {{-- <div class="separator separator-dashed mb-9"></div> --}}
              <div class="row scroll h-600px">
                @foreach ($activity as $item)
                    <div class="col-md-12 col-lg-6 mb-10 d-flex">
                        <div class="d-flex flex-grow-1 align-items-lg-center rounded w-100
                            @if($item->activity_type_id == 1)
                                bg-light-success
                            @elseif($item->activity_type_id == 2)
                                bg-light-warning
                            @elseif($item->activity_type_id == 3)
                                bg-light-info
                            @endif
                        " style="min-height: 200px;">
                            <span data-kt-element="bullet" class="bullet bullet-vertical d-md-flex align-items-center min-h-200px mh-100 me-4 bg-danger"></span>
                            <div class="flex-grow-1 me-5 py-5">
                                <div class="text-gray-600 fw-semibold fs-5">
                                    {{ \Carbon\Carbon::parse($item->start)->format('F d, Y h.iA') }}
                                    –
                                    {{ \Carbon\Carbon::parse($item->end)->format('F d, Y h.iA') }}
                                </div>
                                <div class="text-gray-700 fw-bold fs-2">
                                    {{ $item->name }}
                                </div>
                                <div class="text-gray-500 fs-7">
                                    {!! $item->description !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
              </div>

            </div>
          </div>
        </div>

        <div class="row justify-content-center mb-20"  id="faq" data-kt-scroll-offset="{default: 100, lg: 150}">
          <div class="col-lg-6">
            <div class="mb-17">
              <div class="text-center mb-17">
                <h3 class="fs-2hx text-gray-900 mb-2">
                  F.A.Q
                </h3>
                <div class="fs-5 text-muted fw-bold">Frequently Asked Questions</div>
              </div>
              {{-- <div class="separator separator-dashed mb-9"></div> --}}
              <!--begin::Accordion-->
              <div class="accordion" id="kt_accordion_1">
                @foreach ($faq as $item)                 
                  <div class="accordion-item">
                      <h2 class="accordion-header" id="kt_accordion_1_header_{{ $item->id }}">
                          <button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_{{ $item->id }}" aria-expanded="true" aria-controls="kt_accordion_1_body_{{ $item->id }}">
                              {{ $item->title }}
                          </button>
                      </h2>
                      <div id="kt_accordion_1_body_{{ $item->id }}" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_{{ $item->id }}" data-bs-parent="#kt_accordion_{{ $item->id }}  ">
                          <div class="accordion-body">
                            {{ $item->content }}
                          </div>
                      </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>

        {{-- <div class="d-flex flex-stack flex-wrap flex-md-nowrap card-rounded shadow p-8 p-lg-12 mb-10 bg-danger mb-17">
          <div class="my-2 me-5">
            <div class="fs-1 fs-lg-2qx fw-bold text-white mb-2">Mari sukseskan pelaksanaan JUMBARA V PMI SUMUT <br> Universitas Malikussaleh</div>
          </div>
          <a href="{{ route('survey') }}" class="btn btn-lg btn-outline border-2 btn-outline-white text-white flex-shrink-0 my-2">Isi Survey</a>
        </div> --}}

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
                        <iframe class="rounded w-100 h-100" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3981.9495187685106!2d98.68354939999999!3d3.5990408!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x303131bf9573b8b5%3A0xae94317183e1f307!2sPMI%20Provinsi%20Sumatera%20Utara!5e0!3m2!1sen!2sid!4v1748594995267!5m2!1sen!2sid" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
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
