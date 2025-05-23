@extends('layouts.app')

@section('content')
  <div class="row g-5 g-xl-5">
    <div class="col-xl-12">
      <div class="alert alert-dismissible bg-light-danger d-flex flex-column flex-sm-row p-5">
          <i class="ki-duotone ki-notification-bing fs-2hx text-danger me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
          <div class="d-flex flex-column pe-0 pe-sm-10">
            <h4 class="fw-semibold">Important Notice</h4>
            <span>Changes to participant attendance are allowed up to <strong>15 minutes</strong> before the event starts. 
            After this time, no further modifications will be accepted. 
            Please ensure your attendance information is correct in advance.</span>
          </div>
          <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
              <i class="ki-duotone ki-cross fs-1 text-danger"><span class="path1"></span><span class="path2"></span></i>
          </button>
        </div>
    </div>
    @foreach ($activities as $activity)
      <div class="col-xl-12 mb-5">
        <div class="card card-flush">
          <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <div class="card-title">
              <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">{{ $activity->name }}</span>
                <span class="text-muted fw-semibold fs-7">{{ $activity->description }}</span>
              </h3>
            </div>
          </div>
          <div class="card-body pt-0">

            @forelse($activity->activities as $item)
              <div class="d-md-flex justify-content-between align-items-center mb-6">
                <div class="d-flex align-items-center">
                  <span data-kt-element="bullet"
                        class="bullet bullet-vertical d-md-flex align-items-center min-h-150px mh-100 me-4 bg-danger"></span>
                  <div class="flex-grow-1 me-5">
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
                <div class="d-flex justify-content-between">
                  {{-- <span class="fs-6 fw-bolder text-gray-800 d-block mb-2">Participants</span> --}}
                    <div class="symbol-group symbol-hover">
                      @forelse($item->participantAssignment as $assign)
                        @if($assign->participant && $assign->participant->user)
                          <div class="symbol symbol-circle symbol-40px"
                              data-bs-toggle="tooltip"
                              title="{{ $assign->participant->user->name }}">
                            <img src="{{ $assign->participant->user->photo_path
                                          ? Storage::url($assign->participant->user->photo_path)
                                          : 'https://ui-avatars.com/api/?background=FFEEF3&color=F8285A&bold=true&name='
                                            .urlencode($assign->participant->user->name)
                                        }}"
                                alt=""/>
                          </div>
                        @endif
                      @empty
                      @endforelse
                    </div>
                        <a href="#" class="btn btn-sm btn-light btn-active-light-danger btn-flex btn-center" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                          Actions
                          <span class="svg-icon fs-5 m-0 ps-2">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="currentColor" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)"></path>
                              </g>
                            </svg>
                          </span>
                        </a>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                          <div class="menu-item px-3">
                            <a href="{{ route('admin.news.edit', $item->id) }}" class="menu-link px-3 text-hover-danger bg-hover-light">Participant</a>
                          </div>
                          <div class="menu-item px-3">
                            <a id="{{ route('admin.news.destroy', $item->id) }}" class="menu-link px-3 text-hover-danger bg-hover-light btn-del">Attedance</a>
                          </div>
                        </div>
                </div>
              </div>
            @empty
              <p class="text-muted"><em>No data available</em></p>
            @endforelse

          </div>
        </div>
      </div>
    @endforeach

  </div>

{{-- @foreach ($participant as $item)
<div class="modal fade" tabindex="-1" id="detail{{$item->id}}">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" id="formUpdate{{$item->id}}">
        <div class="modal-header">
            <h3 class="modal-title">Participant Detail</h3>
            <div class="btn btn-icon btn-sm btn-active-light-danger ms-2" data-bs-dismiss="modal" aria-label="Close">
                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
            </div>
        </div>
        <div class="card-body">
          <div class="p-5">
            <img src="{{ Storage::url($item->user->photo_path) }}" class="w-100px rounded" alt="">
          </div>
          <div class="table-responsive px-5">
            <table class="table table-bo fw-normal">
              <tbody>
                <tr class="border-bottom border-gray-200">
                  <td>Name</td>
                  <td>:</td>
                  <td>
                    {{ $item->user->name }}
                  </td>
                </tr>
                <tr class="border-bottom border-gray-200">
                  <td>ID</td>
                  <td>:</td>
                  <td>
                    {{ $item->user->member_id }}
                  </td>
                </tr>
                <tr class="border-bottom border-gray-200">
                  <td>Member Type</td>
                  <td>:</td>
                  <td>
                    {{ $item->user->memberType->name }}
                  </td>
                </tr>
                <tr class="border-bottom border-gray-200">
                  <td>Participant Type</td>
                  <td>:</td>
                  <td>
                    {{ $item->participantType->name }}
                  </td>
                </tr>
                <tr class="border-bottom border-gray-200">
                  <td>Birth Place</td>
                  <td>:</td>
                  <td>
                    {{ $item->user->birth_place }}
                  </td>
                </tr>
                <tr class="border-bottom border-gray-200">
                  <td>Birth Date</td>
                  <td>:</td>
                  <td>
                    {{ $item->user->birth_date }}
                  </td>
                </tr>
                <tr class="border-bottom border-gray-200">
                  <td>Email</td>
                  <td>:</td>
                  <td>
                    {{ $item->user->email }}
                  </td>
                </tr>
                <tr class="border-bottom border-gray-200">
                  <td>Phone</td>
                  <td>:</td>
                  <td>
                    {{ $item->user->phone_number }}
                  </td>
                </tr>
                <tr class="border-bottom border-gray-200">
                  <td>Gender</td>
                  <td>:</td>
                  <td>
                    {{ $item->user->gender->name }}
                  </td>
                </tr>
                <tr class="border-bottom border-gray-200">
                  <td>Religion</td>
                  <td>:</td>
                  <td>
                    {{ $item->user->religion->name }}
                  </td>
                </tr>
                <tr class="border-bottom border-gray-200">
                  <td>Blood Type</td>
                  <td>:</td>
                  <td>
                    {{ $item->user->bloodType->name }}
                  </td>
                </tr>
                <tr class="border-bottom border-gray-200">
                  <td>Address</td>
                  <td>:</td>
                  <td>
                    {{ $item->user->address }}
                  </td>
                </tr>
                <tr class="border-bottom border-gray-200">
                  <td>Health Certificate</td>
                  <td>:</td>
                  <td>
                    <a href="{{ Storage::url($item->health_certificate) }}" target="_blank" class="text-danger">View</a>
                  </td>
                </tr>
                <tr class="border-bottom border-gray-200">
                  <td>Assignment Letter</td>
                  <td>:</td>
                  <td>
                    <a href="{{ Storage::url($item->assignment_letter) }}" target="_blank" class="text-danger">View</a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
  </div>
</div>
@endforeach --}}
@endsection

@section('script')
<script>
  document.querySelectorAll('form').forEach(function(form) {
    form.addEventListener('submit', function(event) {
      var submitButton = form.querySelector('button[type="submit"]');
      submitButton.querySelector('.indicator-label').style.display = 'none';
      submitButton.querySelector('.indicator-progress').style.display = 'inline-block';
      submitButton.setAttribute('disabled', 'disabled');
    });
  });
</script>
<script>
  document.getElementById('form').addEventListener('submit', function() {
    var submitButton = document.getElementById('submit');
    submitButton.querySelector('.indicator-label').style.display = 'none';
    submitButton.querySelector('.indicator-progress').style.display = 'inline-block';
    submitButton.setAttribute('disabled', 'disabled');
  });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const memberTypeSelect = document.getElementById('memberType');
        const participantTypeSelect = document.getElementById('participantType');

        const selectedParticipantType = '{{ request('participantType') }}';

        function loadParticipantTypes(memberTypeId, callback) {
          fetch(`/app/member-type/${memberTypeId}/participant-types`)
                .then(res => res.json())
                .then(data => {
                    participantTypeSelect.innerHTML = '<option selected disabled>Select participant type</option>';
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.name;
                        if (selectedParticipantType == item.id) {
                            option.selected = true;
                        }
                        participantTypeSelect.appendChild(option);
                    });

                    if (callback) callback();
                });
        }

        // Trigger when member type changes
        memberTypeSelect.addEventListener('change', function () {
            const selectedId = this.value;
            participantTypeSelect.innerHTML = '<option>Loading...</option>';
            loadParticipantTypes(selectedId);
        });

        // Trigger on first load only if not already loaded by server
        if (memberTypeSelect.value && participantTypeSelect.dataset.loaded === 'false') {
            loadParticipantTypes(memberTypeSelect.value);
        }
    });
</script>

@endsection