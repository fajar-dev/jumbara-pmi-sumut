<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
  <div class="app-sidebar-header d-flex flex-stack d-none d-lg-flex pt-8 pb-2" id="kt_app_sidebar_header">
    <a href="{{ route('dashboard') }}" class="app-sidebar-logo">
      <img alt="Logo" src="{{ asset('icon/logo.png') }}" class="h-60px d-none d-sm-inline app-sidebar-logo-default theme-light-show" />
      <img alt="Logo" src="{{ asset('icon/logo.png') }}" class="h-60px h-lg-25px theme-dark-show" />
    </a>
    <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-sm btn-icon bg-light btn-color-gray-700 btn-active-color-danger d-none d-lg-flex rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
      <i class="ki-outline ki-text-align-right rotate-180 fs-1"></i>
    </div>
  </div>
  <div class="app-sidebar-navs flex-column-fluid py-6" id="kt_app_sidebar_navs">
    <div id="kt_app_sidebar_navs_wrappers" class="app-sidebar-wrapper hover-scroll-y my-2" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_header" data-kt-scroll-wrappers="#kt_app_sidebar_navs" data-kt-scroll-offset="5px">
      <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false" class="app-sidebar-menu-primary menu menu-column menu-rounded menu-sub-indention menu-state-bullet-danger">
        <div class="menu-item mb-8">
          <a class="menu-link active bg-danger" href="{{ route('home') }}">
            <span class="menu-icon">
              <i class="ki-outline ki-arrow-left fs-2 text-white"></i>
              </span>
            </span>
            <span class="menu-title">
              Back to Home               
            </span>
          </a>
        </div>
        <div class="menu-item mb-2">
          <div class="menu-heading text-uppercase fs-7 fw-bold">Menu</div>
          <div class="app-sidebar-separator separator separator-dashed"></div>
        </div>
        <div class="menu-item">
          <a class="menu-link  @if($title == 'Dashboard') active bg-danger @endif" href="{{ route('dashboard') }}">
            <span class="menu-icon">
              <i class="ki-outline ki-home-2 fs-2"></i>
            </span>
            <span class="menu-title">Dashboard</span>
          </a>
        </div>
        <div data-kt-menu-trigger="click" class="menu-item @if($title == 'Master Data') here show @endif menu-accordion">
          <span class="menu-link">
            <span class="menu-icon">
              <i class="ki-outline ki-book fs-2"></i>
            </span>
            <span class="menu-title">Master Data</span>
            <span class="menu-arrow"></span>
          </span>
          <div class="menu-sub menu-sub-accordion">
            <div class="menu-item">
              <a class="menu-link  @if($subTitle == 'Member Type') active bg-danger bg-danger @endif" href="{{ route('admin.master-data.member') }}">
                <span class="menu-bullet">
                  <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Member Type</span>
              </a>
            </div>
            <div class="menu-item">
              <a class="menu-link @if($subTitle == 'Participant Type') active bg-danger @endif" href="{{ route('admin.master-data.participant') }}">
                <span class="menu-bullet">
                  <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Participant Type</span>
              </a>
            </div>
            <div class="menu-item">
              <a class="menu-link @if($subTitle == 'Activity Type') active bg-danger @endif" href="{{ route('admin.master-data.activity') }}">
                <span class="menu-bullet">
                  <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Activity Type</span>
              </a>
            </div>
          </div>
        </div>
        <div data-kt-menu-trigger="click" class="menu-item @if($title == 'Event') here show @endif menu-accordion">
          <span class="menu-link">
            <span class="menu-icon">
              <i class="ki-outline ki-medal-star fs-2"></i>
            </span>
            <span class="menu-title">Event</span>
            <span class="menu-arrow"></span>
          </span>
          <div class="menu-sub menu-sub-accordion">
            <div class="menu-item">
              <a class="menu-link  @if($subTitle == 'Contingent') active bg-danger bg-danger @endif" href="{{ route('admin.event.contingent') }}">
                <span class="menu-bullet">
                  <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Contingent</span>
              </a>
            </div>
            <div class="menu-item">
              <a class="menu-link @if($subTitle == 'Activity') active bg-danger @endif" href="{{ route('admin.event.activity') }}">
                <span class="menu-bullet">
                  <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Activity</span>
              </a>
            </div>
          </div>
        </div>
        <div class="menu-item">
          <a class="menu-link  @if($title == 'Survey') active bg-danger @endif" href="{{ route('admin.survey') }}">
            <span class="menu-icon">
              <i class="ki-outline ki-questionnaire-tablet fs-2"></i>
            </span>
            <span class="menu-title">Survey</span>
          </a>
        </div>
        <div data-kt-menu-trigger="click" class="menu-item @if($title == 'News') here show @endif menu-accordion">
          <span class="menu-link">
            <span class="menu-icon">
              <i class="ki-outline ki-message-text fs-2"></i>
            </span>
            <span class="menu-title">News</span>
            <span class="menu-arrow"></span>
          </span>
          <div class="menu-sub menu-sub-accordion">
            <div class="menu-item">
              <a class="menu-link  @if($subTitle == 'Category') active bg-danger bg-danger @endif" href="{{ route('admin.category') }}">
                <span class="menu-bullet">
                  <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Category</span>
              </a>
            </div>
            <div class="menu-item">
              <a class="menu-link @if($subTitle == 'List') active bg-danger @endif" href="{{ route('admin.news') }}">
                <span class="menu-bullet">
                  <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">List</span>
              </a>
            </div>
          </div>
        </div>
        <div class="menu-item">
          <a class="menu-link @if($title == 'Announcement') active bg-danger @endif menu-accordion"" href="{{ route('admin.announcement') }}">
            <span class="menu-icon">
              <i class="ki-outline ki-tablet-book fs-2"></i>
            </span>
            <span class="menu-title">Announcement</span>
          </a>
        </div>
        <div class="menu-item">
          <a class="menu-link @if($title == 'Message') active bg-danger @endif menu-accordion"" href="{{ route('admin.message') }}">
            <span class="menu-icon">
              <i class="ki-outline ki-sms fs-2"></i>
            </span>
            <span class="menu-title">Message</span>
          </a>
        </div>
        <div class="menu-item">
          <a class="menu-link @if($title == 'User') active bg-danger @endif menu-accordion"" href="{{ route('admin.user') }}">
            <span class="menu-icon">
              <i class="ki-outline ki-profile-user fs-2"></i>
            </span>
            <span class="menu-title">User</span>
          </a>
        </div>
        <div data-kt-menu-trigger="click" class="menu-item @if($title == 'Setting') here show @endif menu-accordion">
          <span class="menu-link">
            <span class="menu-icon">
              <i class="ki-outline ki-gear fs-2"></i>
            </span>
            <span class="menu-title">Setting</span>
            <span class="menu-arrow"></span>
          </span>
          <div class="menu-sub menu-sub-accordion">
            <div class="menu-item">
              <a class="menu-link  @if($subTitle == 'FAQ') active bg-danger bg-danger @endif" href="{{ route('admin.setting.faq') }}">
                <span class="menu-bullet">
                  <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">FAQ</span>
              </a>
            </div>
            <div class="menu-item">
              <a class="menu-link @if($subTitle == 'List') active bg-danger @endif" href="{{ route('admin.news') }}">
                <span class="menu-bullet">
                  <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">General</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>