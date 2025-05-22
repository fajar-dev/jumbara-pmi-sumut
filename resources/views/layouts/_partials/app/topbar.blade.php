<div id="kt_app_header" class="app-header">
  <div class="app-container container-fluid d-flex align-items-stretch flex-stack" id="kt_app_header_container">
    <div class="d-flex align-items-center d-block d-lg-none ms-n3" title="Show sidebar menu">
      <div class="btn btn-icon btn-active-color-danger w-35px h-35px me-2" id="kt_app_sidebar_mobile_toggle">
        <i class="ki-outline ki-abstract-14 fs-2"></i>
      </div>
      <a href="{{ route('dashboard') }}">
        <img alt="Logo" src="{{ asset('icon/logo-jumbara.png') }}" class="h-50px" />
      </a>
    </div>
    <div class="app-navbar flex-lg-grow-1" id="kt_app_header_navbar">
      <div class="app-navbar-item d-flex align-items-stretch flex-lg-grow-1">
        <div id="kt_header_search" class="header-search d-flex align-items-center w-lg-300px" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-search-responsive="true" data-kt-menu-trigger="auto" data-kt-menu-permanent="true" data-kt-menu-placement="bottom-start">
          <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
            <h1 class="d-flex flex-column justify-content-center fw-bold fs-3 m-0">{{ $title }}</h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
              <li class="breadcrumb-item text-muted">
                <i class="ki-duotone ki-home text-gray-400"></i>
              </li>
              <li class="breadcrumb-item">
                <span class="bullet bg-gray-300 w-5px h-2px"></span>
              </li>
              <li class="breadcrumb-item text-muted">
                <a href="#" class="text-muted text-hover-danger">{{ $title }}</a>
              </li>
              @if ($subTitle)
              <li class="breadcrumb-item">
                <span class="bullet bg-gray-500 w-5px h-2px"></span>
              </li>
              <li class="breadcrumb-item text-muted">{{ $subTitle }}</li>
              @endif
            </ul>
          </div>
        </div>
      </div>
      <div class="app-navbar-item me-2">
        <div class="btn btn-icon bg-gray-200 btn-icon-gray-700 btn-active-light btn-active-color-danger w-35px h-35px w-lg-40px h-lg-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="45px, -40px">
          <span class="menu-title position-relative ps-6">
            <span class="ms-5 position-absolute  translate-middle-y top-50 end-0">
              <i class="ki-duotone ki-night-day theme-light-show fs-2">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
                <span class="path4"></span>
                <span class="path5"></span>
                <span class="path6"></span>
                <span class="path7"></span>
                <span class="path8"></span>
                <span class="path9"></span>
                <span class="path10"></span>
              </i>
              <i class="ki-duotone ki-moon theme-dark-show fs-2">
                <span class="path1"></span>
                <span class="path2"></span>
              </i>
            </span></span>
        </div>
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
          <div class="menu-item px-3 text-hover-danger text-active-danger my-0">
            <a href="#" class="menu-link px-3 py-2 text-hover-danger text-active-danger" data-kt-element="mode" data-kt-value="light">
              <span class="menu-icon" data-kt-element="icon">
                <i class="ki-duotone ki-night-day fs-2">
                  <span class="path1"></span>
                  <span class="path2"></span>
                  <span class="path3"></span>
                  <span class="path4"></span>
                  <span class="path5"></span>
                  <span class="path6"></span>
                  <span class="path7"></span>
                  <span class="path8"></span>
                  <span class="path9"></span>
                  <span class="path10"></span>
                </i>
              </span>
              <span class="menu-title text-hover-danger text-active-danger">Light</span>
            </a>
          </div>
          <div class="menu-item px-3 my-0 text-hover-danger text-active-danger">
            <a href="#" class="menu-link  text-hover-danger text-active-danger px-3 py-2" data-kt-element="mode" data-kt-value="dark">
              <span class="menu-icon" data-kt-element="icon">
                <i class="ki-duotone ki-moon fs-2">
                  <span class="path1"></span>
                  <span class="path2"></span>
                </i>
              </span>
              <span class="menu-title text-hover-danger text-active-danger">Dark</span>
            </a>
          </div>
          <div class="menu-item px-3 my-0  text-hover-danger text-active-danger">
            <a href="#" class="menu-link px-3 py-2  text-hover-danger text-active-danger" data-kt-element="mode" data-kt-value="system">
              <span class="menu-icon" data-kt-element="icon">
                <i class="ki-duotone ki-screen fs-2">
                  <span class="path1"></span>
                  <span class="path2"></span>
                  <span class="path3"></span>
                  <span class="path4"></span>
                </i>
              </span>
              <span class="menu-title  text-hover-danger text-active-danger">System</span>
            </a>
          </div>
        </div>
      </div>
      <div class="app-navbar-item ms-1 ms-md-3" id="kt_header_user_menu_toggle">
        <div class="cursor-pointer symbol symbol-circle symbol-35px symbol-md-45px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
          <img src="{{ Auth::user()->photo_path ? Storage::url(Auth::user()->photo_path) : 'https://ui-avatars.com/api/?background=FFEEF3&color=F8285A&bold=true&name='.Auth::user()->name }}" alt="user" />
        </div>
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
          <div class="menu-item px-3">
            <div class="menu-content d-flex align-items-center px-3">
              <div class="symbol symbol-50px me-5">
                <img alt="Logo" src="{{ Auth::user()->photo_path ? Storage::url(Auth::user()->photo_path) : 'https://ui-avatars.com/api/?background=FFEEF3&color=F8285A&bold=true&name='.Auth::user()->name }}" />
              </div>
              <div class="d-flex flex-column">
                <div class="fw-bold d-flex align-items-center fs-5">{{ Auth::user()->name }}</div>
                <a href="#" class="fw-semibold text-muted text-hover-danger fs-7">{{ Auth::user()->member_id }}</a>
              </div>
              @if (Auth::user()->secretariat_id)
                <div>
                  <a href="#" class="ms-2" data-bs-toggle="tooltip" data-bs-placement="top" title="SIAMO Verified">
                    <i class="ki-duotone ki-verify fs-1 text-danger">
                      <span class="path1"></span>
                      <span class="path2"></span>
                    </i>
                  </a>
                </div>
              @endif
            </div>
          </div>
          <div class="separator my-2"></div>
          <div class="menu-item px-5">
            <a href="{{ route('app.profile') }}" class="menu-link text-hover-danger px-5">My Profile</a>
          </div>
          <div class="menu-item px-5">
            <a href="{{ route('logout') }}" class="menu-link text-hover-danger px-5">Sign Out</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>