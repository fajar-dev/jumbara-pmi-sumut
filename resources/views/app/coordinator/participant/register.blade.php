@extends('layouts.app')

@section('content')
  <div class="row g-5 g-xl-10 justify-content-center">
    <div class="col-xl-8 mb-8">
      <div class="card card-flush">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
          <div class="card-title">
            <h3 class="card-title align-items-start flex-column">
              <span class="card-label fw-bold fs-3 mb-1">Registered Participants</span>
              <span class="text-muted fw-semibold fs-7">{{ $coordinator->contingent->name }}</span>
            </h3>
          </div>
        </div>
        <form method="POST" id="form" action="{{ route('coordinator.participant.register.store') }}" enctype="multipart/form-data" class="form">
            @csrf
            <div class="card-body border-top p-9">
              <div class="row mb-6">
                <label class="required fw-semibold fs-6">Photo</label>
                <div class="col-lg-8 fv-row">
                  <style>.image-input-placeholder { background-image: url("{{ asset('app/media/svg/avatars/blank.svg') }}"); } [data-bs-theme="dark"] .image-input-placeholder { background-image: url("{{ asset('app/media/svg/avatars/blank.svg') }}"); }</style>
                  <div class="image-input image-input-empty image-input-outline image-input-placeholder" data-kt-image-input="true">
                    <div class="image-input-wrapper w-125px h-125px"></div>
                    <label class="btn btn-icon btn-circle btn-active-color-danger w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                      <i class="ki-outline ki-pencil fs-7"></i>
                      <input type="file" name="photo" required accept=".png, .jpg, .jpeg" />
                      <input type="hidden" name="avatar_remove" />
                    </label>
                    <span class="btn btn-icon btn-circle btn-active-color-danger w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                      <i class="ki-outline ki-cross fs-2"></i>
                    </span>
                    <span class="btn btn-icon btn-circle btn-active-color-danger w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                      <i class="ki-outline ki-cross fs-2"></i>
                    </span>
                  </div>
                  <div class="form-text">Allowed file types: png, jpg, jpeg. Maximum file 2mb</div>
                  @error('photo')
                  <div class="text-sm text-danger">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-6">
                <label class="required fw-semibold fs-6">Name</label>
                  <input type="text" name="name" class="form-control form-control-lg form-control-solid @error('name') is-invalid @enderror" placeholder="Full Name" value="{{ old('name') }}" required />
                  @error('name')
                  <div class="text-sm text-danger">
                    {{ $message }}
                  </div>
                  @enderror
              </div>
              <div class="row mb-6">
                <div class="col-md mb-6 mb-md-0">
                  <label class="required fw-semibold fs-6">Member Type</label>
                  <select class="form-select form-select-solid @error('memberType') is-invalid @enderror" name="memberType" required>
                    <option selected disabled>Select member type</option>
                    @foreach ($memberType as $item)       
                      <option value="{{ $item->id }}" {{ old('memberType') == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                      </option>
                    @endforeach
                  </select>
                  @error('memberType')
                  <div class="text-sm text-danger">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="col-md mb-6 mb-md-0">
                  <label class="required fw-semibold fs-6">Participant Type</label>
                  <select class="form-select form-select-solid @error('participantType') is-invalid @enderror" name="participantType" id="participantType" required>
                    <option selected disabled>select a member type first</option>
                  </select>
                  @error('participantType')
                  <div class="text-sm text-danger">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <input type="hidden" id="oldParticipantType" value="{{ old('participantType') }}">
              </div>
              <div class="row mb-6">
                <div class="col-md mb-6 mb-md-0">
                  <label class="required fw-semibold fs-6">Birth Place</label>
                  <input type="text" name="birthPlace" class="form-control form-control-lg form-control-solid @error('birthPlace') is-invalid @enderror" placeholder="e.g. Medan" value="{{ old('birthPlace') }}" required/>
                  @error('birthPlace')
                  <div class="text-sm text-danger">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="col-md">
                  <label class="required fw-semibold fs-6">Birth Date</label>
                  <input type="date" name="birthDate" class="form-control form-control-lg form-control-solid @error('birthDate') is-invalid @enderror" value="{{ old('birthDate') }}" required/>
                  @error('birthDate')
                  <div class="text-sm text-danger">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-6">
                <div class="col-md mb-6 mb-md-0">
                  <label class="required fw-semibold fs-6">Email</label>
                  <input type="email" name="email" class="form-control form-control-lg form-control-solid @error('email') is-invalid @enderror" placeholder="Email Address" value="{{ old('email') }}" required/>
                  @error('email')
                  <div class="text-sm text-danger">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="col-md">
                  <label class="required fw-semibold fs-6">Phone</label>
                  <input type="number" name="phone" class="form-control form-control-lg form-control-solid @error('phone') is-invalid @enderror" placeholder="Phone Number" value="{{ old('phone') }}" required/>
                  @error('phone')
                  <div class="text-sm text-danger">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-6">
                <div class="col-md mb-6 mb-md-0">
                  <label class="required fw-semibold fs-6">Gender</label>
                  <select class="form-select form-select-solid @error('gender') is-invalid @enderror" name="gender" required>
                    <option selected disabled>Select gender</option>
                    @foreach ($gender as $item)       
                      <option value="{{ $item->id }}" {{ old('gender') == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                      </option>
                    @endforeach
                  </select>
                  @error('gender')
                  <div class="text-sm text-danger">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="col-md mb-6 mb-md-0">
                  <label class="required fw-semibold fs-6">Religion</label>
                  <select class="form-select form-select-solid @error('religion') is-invalid @enderror" name="religion" required>
                    <option selected disabled>Select Religion</option>
                    @foreach ($religion as $item)       
                      <option value="{{ $item->id }}" {{ old('religion') == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                      </option>
                    @endforeach
                  </select>                  
                  @error('religion')
                  <div class="text-sm text-danger">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="col-md">
                  <label class="required fw-semibold fs-6">Blood Type</label>
                  <select class="form-select form-select-solid @error('bloodType') is-invalid @enderror" name="bloodType" required>
                    <option selected disabled>Select Blood Type</option>
                    @foreach ($bloodType as $item)       
                      <option value="{{ $item->id }}" {{ old('bloodType') == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                      </option>
                    @endforeach
                  </select>                  
                  @error('bloodType') {{-- Perbaikan: sebelumnya tertulis 'religion' --}}
                  <div class="text-sm text-danger">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-6">
                <label class="required fw-semibold fs-6">Address</label>
                <textarea class="form-control form-control form-control-solid @error('address') is-invalid @enderror" data-kt-autosize="true" placeholder="Full Addrress" name="address" required>{{ old('address') }}</textarea>
                  @error('address')
                  <div class="text-sm text-danger">
                    {{ $message }}
                  </div>
                  @enderror
              </div>
              <div class="row mb-6">
                <label class="required fw-semibold fs-6">Health Certificate</label>
                  <input type="file" name="health" class="form-control form-control-lg form-control-solid @error('health') is-invalid @enderror" required/>
                  <div class="form-text">Allowed file types: pdf, Maximum file 2mb</div>
                  @error('health')
                  <div class="text-sm text-danger">
                    {{ $message }}
                  </div>
                  @enderror
              </div>
              <div class="row mb-6">
                <label class="required fw-semibold fs-6">Assignment Letter</label>
                  <input type="file" name="assignment" class="form-control form-control-lg form-control-solid @error('assignment') is-invalid @enderror" required/>
                  <div class="form-text">Allowed file types: pdf, Maximum file 2mb</div>
                  @error('assignment')
                  <div class="text-sm text-danger">
                    {{ $message }}
                  </div>
                  @enderror
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

@endsection

@section('script')
<script>
    // Handle form submission for the first form
    document.getElementById('form').addEventListener('submit', function() {
        var submitButton = document.getElementById('submit');
        submitButton.querySelector('.indicator-label').style.display = 'none';
        submitButton.querySelector('.indicator-progress').style.display = 'inline-block';
        submitButton.setAttribute('disabled', 'disabled');
    });

    // Handle form submission for the second form
    document.getElementById('member').addEventListener('submit', function() {
        var submitButton = document.getElementById('submit');
        submitButton.setAttribute('disabled', 'disabled');

        var submitButton = document.getElementById('submit-member');
        submitButton.querySelector('.indicator-label-member').style.display = 'none';
        submitButton.querySelector('.indicator-progress-member').style.display = 'inline-block';
        submitButton.setAttribute('disabled', 'disabled');
    });
</script>
<script>
$(document).ready(function() {
    function loadParticipantTypes(memberTypeId, selectedId = null) {
        $('#participantType').html('<option>Loading...</option>');

        $.ajax({
            url: '/app/member-type/' + memberTypeId + '/participant-types',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#participantType').empty();
                $('#participantType').append('<option selected disabled>Select participant type</option>');

                $.each(data, function(key, value) {
                    let isDisabled = value.disabled ? 'disabled' : '';
                    let isSelected = selectedId && selectedId == value.id ? 'selected' : '';

                    $('#participantType').append(
                        '<option value="' + value.id + '" ' + isSelected + ' ' + isDisabled + '>' +
                        value.name + ' (' + value.available + ' available slot)</option>'
                    );
                });
            },
            error: function() {
                $('#participantType').html('<option selected disabled>Error loading data</option>');
            }
        });
    }

    let oldMemberType = $('select[name="memberType"]').val();
    let oldParticipantType = $('#oldParticipantType').val();

    if (oldMemberType) {
        loadParticipantTypes(oldMemberType, oldParticipantType);
    }

    // Jika berubah
    $('select[name="memberType"]').on('change', function() {
        let selectedId = null;
        loadParticipantTypes($(this).val(), selectedId);
    });
});
</script>


@endsection