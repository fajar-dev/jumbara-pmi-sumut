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
              <div class="d-md-flex justify-content-between align-items-center mb-10">
                <div class="d-flex align-items-lg-center">
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
                <div class="d-flex justify-content-between align-items-center">
                  <div class="d-flex flex-column me-5">
                    <span class="fs-6 fw-bolder text-gray-800 d-block mb-2">Assigned to:</span>
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
                      -
                      @endforelse
                    </div>
                  </div>
                  <div>
                    @if (now()->lessThan(Carbon\Carbon::parse($item->start)->subMinutes(15)))
                      <button class="btn btn-light-danger btn-icon btn-sm">
                        <i class="ki-duotone ki-people fs-5">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                        <span class="path4"></span>
                        <span class="path5"></span>
                        </i>
                      </button>
                    @endif
                    <button class="btn btn-danger btn-icon btn-sm">
                      <i class="ki-duotone ki-fingerprint-scanning fs-5">
                      <span class="path1"></span>
                      <span class="path2"></span>
                      <span class="path3"></span>
                      <span class="path4"></span>
                      <span class="path5"></span>
                      </i>
                    </button>
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

@endsection