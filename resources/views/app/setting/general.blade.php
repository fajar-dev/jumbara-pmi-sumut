@extends('layouts.app')

@section('content')
  <div class="row g-5 g-xl-10">
    <div class="col-xl-12 mb-8">
      <div class="card card-flush mb-5 mb-xl-10">
        <div class="card-header border-0 cursor-pointer">
          <div class="card-title m-0">
            <h3 class="fw-bold m-0">General</h3>
          </div>
        </div>
        <div>
          <form method="POST" id="form" action="{{ route('admin.setting.general.update') }}" enctype="multipart/form-data" class="form">
            @csrf
            <div class="card-body border-top p-9">
              <div class="row mb-6">
                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Logo</label>
                <div class="col-lg-8 fv-row">
                  <style>.image-input-placeholder { background-image: url("{{ Storage::url($general->logo) }}"); } [data-bs-theme="dark"] .image-input-placeholder { background-image: url('{{ Storage::url($general->logo) }}'); }</style>
                  <div class="image-input image-input-empty image-input-outline image-input-placeholder" data-kt-image-input="true">
                    <div class="image-input-wrapper w-125px h-125px"></div>
                    <label class="btn btn-icon btn-circle btn-active-color-danger w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                      <i class="ki-outline ki-pencil fs-7"></i>
                      <input type="file" name="logo" accept=".png, .jpg, .jpeg" />
                      <input type="hidden" name="avatar_remove" />
                    </label>
                    <span class="btn btn-icon btn-circle btn-active-color-danger w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                      <i class="ki-outline ki-cross fs-2"></i>
                    </span>
                    <span class="btn btn-icon btn-circle btn-active-color-danger w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                      <i class="ki-outline ki-cross fs-2"></i>
                    </span>
                  </div>
                  <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                  @error('logo')
                  <div class="text-sm text-danger">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-6">
                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Title</label>
                <div class="col-lg-8 fv-row">
                  <input type="text" name="title" class="form-control form-control-lg form-control-solid @error('title') is-invalid @enderror" value="{{ old('title') ?? $general->title }}" />
                  @error('title')
                  <div class="text-sm text-danger">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-6">
                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Sub Title</label>
                <div class="col-lg-8 fv-row">
                  <input type="text" name="subtitle" class="form-control form-control-lg form-control-solid @error('subtitle') is-invalid @enderror" value="{{ old('subtitle') ?? $general->subtitle }}" />
                  @error('subtitle')
                  <div class="text-sm text-danger">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-6">
                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Location</label>
                <div class="col-lg-8 fv-row">
                  <input type="text" name="location" class="form-control form-control-lg form-control-solid @error('location') is-invalid @enderror" value="{{ old('location') ?? $general->location }}" />
                  @error('location')
                  <div class="text-sm text-danger">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-6">
                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Event date</label>
                <div class="col-lg-8 fv-row">
                  <div class="row">
                    <div class="col">
                      <input type="date" name="eventStart" class="form-control form-control-lg form-control-solid @error('eventStart') is-invalid @enderror" value="{{ old('eventStart') ?? $general->event_start }}" />
                      @error('eventStart')
                      <div class="text-sm text-danger">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                    <div class="col">
                      <input type="date" name="eventEnd" class="form-control form-control-lg form-control-solid @error('eventEnd') is-invalid @enderror" value="{{ old('eventEnd') ?? $general->event_end }}" />
                      @error('eventEnd')
                      <div class="text-sm text-danger">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
              <div class="row mb-6">
                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Last Registration</label>
                <div class="col-lg-8 fv-row">
                  <input type="datetime-local" name="lastRegistration" class="form-control form-control-lg form-control-solid @error('lastRegistration') is-invalid @enderror" value="{{ old('lastRegistration') ?? $general->last_registration }}" />
                  @error('lastRegistration')
                  <div class="text-sm text-danger">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-6">
                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Guide Book</label>
                <div class="col-lg-8 fv-row">
                  <input type="file" name="guidebook" class="form-control form-control-lg form-control-solid @error('guidebook') is-invalid @enderror" value="{{ old('guidebook') ?? $general->guidebook }}" />
                  <span>file: <a href="{{ Storage::url($general->guidebook) }}" target="_blank" class="text-danger">{{ $general->guidebook }}</a></span>
                  @error('guidebook')
                  <div class="text-sm text-danger">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="card-body border-top p-9">
              <div class="row mb-6">
                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Email Address</label>
                <div class="col-lg-8 fv-row">
                  <input type="email" name="email" class="form-control form-control-lg form-control-solid @error('email') is-invalid @enderror" value="{{ old('email') ?? $general->email }}" />
                  @error('email')
                  <div class="text-sm text-danger">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-6">
                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Phone Number</label>
                <div class="col-lg-8 fv-row">
                  <input type="text" name="phone" class="form-control form-control-lg form-control-solid @error('phone') is-invalid @enderror" value="{{ old('phone') ?? $general->phone }}" />
                  @error('phone')
                  <div class="text-sm text-danger">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-6">
                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Instagram</label>
                <div class="col-lg-8 fv-row">
                  <input type="text" name="instagram" class="form-control form-control-lg form-control-solid @error('instagram') is-invalid @enderror" value="{{ old('instagram') ?? $general->instagram }}" />
                  @error('instagram')
                  <div class="text-sm text-danger">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-6">
                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Facebook</label>
                <div class="col-lg-8 fv-row">
                  <input type="text" name="facebook" class="form-control form-control-lg form-control-solid @error('facebook') is-invalid @enderror" value="{{ old('facebook') ?? $general->facebook }}" />
                  @error('facebook')
                  <div class="text-sm text-danger">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-6">
                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Youtube</label>
                <div class="col-lg-8 fv-row">
                  <input type="text" name="youtube" class="form-control form-control-lg form-control-solid @error('youtube') is-invalid @enderror" value="{{ old('youtube') ?? $general->youtube }}" />
                  @error('youtube')
                  <div class="text-sm text-danger">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-6">
                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Tiktok</label>
                <div class="col-lg-8 fv-row">
                  <input type="text" name="tiktok" class="form-control form-control-lg form-control-solid @error('tiktok') is-invalid @enderror" value="{{ old('tiktok') ?? $general->tiktok }}" />
                  @error('tiktok')
                  <div class="text-sm text-danger">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-6">
                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Website</label>
                <div class="col-lg-8 fv-row">
                  <input type="text" name="website" class="form-control form-control-lg form-control-solid @error('website') is-invalid @enderror" value="{{ old('website') ?? $general->website }}" />
                  @error('website')
                  <div class="text-sm text-danger">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
              <button type="submit" id="submit" class="btn btn-danger">
                <span class="indicator-label">Save</span>
                <span class="indicator-progress" style="display: none;">Loading... 
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script src="{{ asset('app/js/custom/account/settings/signin-methods.js') }}"></script>
<script>
  document.getElementById('form').addEventListener('submit', function() {
    var submitButton = document.getElementById('submit');
    submitButton.querySelector('.indicator-label').style.display = 'none';
    submitButton.querySelector('.indicator-progress').style.display = 'inline-block';
    submitButton.setAttribute('disabled', 'disabled');
  });
</script>
@endsection
