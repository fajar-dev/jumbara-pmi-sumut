@extends('layouts.app')

@section('content')
  <div class="row g-5 g-xl-10 justify-content-center">
    <div class="col-xl-8 mb-8">
      <div class="card card-flush">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
          <div class="card-title">
            <h3 class="card-title align-items-start flex-column">
              <span class="card-label fw-bold fs-3 mb-1">Add Participant</span>
              <span class="text-muted fw-semibold fs-7">{{ $coordinator->contingent->name }}</span>
            </h3>
          </div>
        </div>
        <div class="card-body min-h-150px">
          <form method="POST" action="{{ route('coordinator.participant.check', ['provinceId' => $coordinator->contingent->administrative_area_level_1, 'cityId' => $coordinator->contingent->administrative_area_level_2 ]) }}" class="modal-content" id="form">
              @csrf
              <div class="input-group d-flex align-items-center position-relative my-1">
                  <input type="number" class="form-control form-control-solid rounded-start-3 ps-5 rounded-0" name="memberId" value="{{ old('memberId') }}" placeholder="Member ID" required />
                  <button class="btn btn-danger" type="submit" id="submit">
                      <span class="svg-icon svg-icon-3 indicator-label">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search me-5" viewBox="0 0 16 16">
                              <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                          </svg>
                          Search
                      </span>
                      <span class="indicator-progress" style="display: none;">Loading... 
                      <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                      </span>
                  </button>
              </div>
            </form>
            @if (session()->has('found'))
                @php
                    $member = json_decode(session('found')); // Ambil seluruh data member dari session
                @endphp
                <form action="{{ route('coordinator.participant.store', $coordinator->contingent->id) }}" method="POST" id="member">
                  @csrf
                    <div class="alert alert-dismissible bg-light-primary d-flex flex-column flex-sm-row p-5 mb-10 mt-5">
                        <div class="d-flex flex-column pe-0 pe-sm-10">
                            <h4 class="fw-semibold">{{ $member->name }}</h4>
                            <span><strong>{{ $member->category->name }}</strong> - {{ $member->membership->name }}</span>
                        </div>
                        <button type="submit" id="submit-member" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-light ms-sm-auto">
                            <span class="indicator-label-member">Next</span>
                            <span class="indicator-progress-member" style="display: none;">Loading... 
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                        <input type="hidden" name="json" value="{{session('found')}}">
                    </div>
                </form>
            @endif
        </div>
        <div class="card-footer text-center">
          Don't have an Member ID? <a href="{{ route('coordinator.participant.register') }}" class="fw-bold text-danger"> Click Here</a>
        </div>
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
@endsection