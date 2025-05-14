@extends('layouts.auth')

@section('content')
<div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
  <div class="d-flex flex-center flex-column flex-lg-row-fluid">
    <div class="w-lg-500px  w-100 p-10">
      <form class="form w-100" action="{{ route('change.submit') }}" method="POST" id="loginForm">
        @csrf
        <div class="mb-11">
          <h1 class="text-gray-900 fw-bolder mb-3 fs-3qx">Change Password</h1>
          <div class="text-gray-500 fw-semibold fs-5">Please change your default password </div>
        </div>

        <div class="fv-row mb-8">
          <div class="alert alert-dismissible bg-light-dark border border-dashed border-danger border-2 d-flex align-items-center flex-row">
            <div class="symbol-label">
              <div class="symbol symbol-circle symbol-40px overflow-hidden me-5">
                  <div class="symbol-label">
                    <img src="{{ Auth::user()->photo_path ? Storage::url(Auth::user()->photo_path) : 'https://ui-avatars.com/api/?background=FFEEF3&color=F8285A&bold=true&name='.Auth::user()->name }}" alt="" class="w-100">
                  </div>
              </div>
            </div>
            <div class="d-flex flex-column pe-0 pe-sm-10">
                <h4 class="mb-1 fs-6">{{ Auth::user()->name }}</h4>
                <span class="text-muted fs-7">{{ Auth::user()->member_id }}</span>
            </div>
          </div>
        </div>

        <div class="fv-row mb-8">
          <input type="password" placeholder="New Password" name="password" autocomplete="off" class="form-control bg-transparent @error('password') is-invalid @enderror" value="{{ old('password') }}" />
          @error('password')
          <div class="text-sm text-danger">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="d-grid mb-3">
          <button type="submit" id="kt_sign_in_submit" class="btn btn-danger">
            <span class="indicator-label">Change Password</span>
            <span class="indicator-progress" style="display: none;">Loading... 
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
          </button>
        </div>
        <div>
          <a href="{{ route('dashboard') }}" class="btn btn-light w-100">Not now</a>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('script')
<script>
  document.getElementById('loginForm').addEventListener('submit', function() {
    var submitButton = document.getElementById('kt_sign_in_submit');
    submitButton.querySelector('.indicator-label').style.display = 'none';
    submitButton.querySelector('.indicator-progress').style.display = 'inline-block';
    submitButton.setAttribute('disabled', 'disabled');
  });
</script>
@endsection
