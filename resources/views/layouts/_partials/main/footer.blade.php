<div id="kt_app_footer" class="app-footer pt-10 mt-20 pb-5 bg-light">
  <div class="app-container container-fluid ">
    <div class="px-lg-20 mx-lg-20">
      <div class="row g-10 mb-10">
        <div class="col-sm-5">
          <img src="{{ asset('icon/logo.png') }}" class="h-90px theme-light-show my-2 p-3" alt="">
          <img src="{{ asset('icon/logo.png') }}" class="h-90px theme-dark-show bg-white my-2 p-3" alt="">

          <div>
            <div class="fs-3 fw-semibold text-gray-700 pt-10">{!! $setting->address !!}</div>
            <div class="text-gray-500 fw-semibold pt-5 fs-5">{{ $setting->phone }}<br>{{ $setting->email }}</div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="separator separator-dashed mb-9"></div>
        <div class="col-12 d-md-flex justify-content-between">
          <div class="text-gray-900 order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">2025 &copy;</span>
            <a href="https://pmisumut.org target="_blank" class="text-gray-800 text-hover-danger">PMI Provinsi Sumatera Utara </a>
          </div>
          <ul class="menu menu-gray-600 menu-hover-danger fw-semibold order-1">
            <li class="menu-item px-2">
              <img src="{{ asset('app/media/svg/brand-logos/facebook-4.svg') }}" class="h-20px" alt="">
            </li>
            <li class="menu-item px-2">
              <img src="{{ asset('app/media/svg/brand-logos/twitter.svg') }}" class="h-20px" alt="">
            </li>
            <li class="menu-item px-2">
              <img src="{{ asset('app/media/svg/brand-logos/instagram-2-1.svg') }}" class="h-20px" alt="">
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>