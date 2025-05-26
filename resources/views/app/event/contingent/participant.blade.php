@extends('layouts.app')

@section('content')
  <div class="row g-5 g-xl-10">
    <div class="col-xl-12 mb-8">
      <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
        <li class="nav-item">
            <a class="nav-link  border-hover-danger text-danger border-danger" href="{{ route('admin.event.contingent.participant', $contingent->id) }}">Participant</a>
        </li>
        <li class="nav-item">
            <a class="nav-link border-hover-danger" href="{{ route('admin.event.contingent.activity', $contingent->id) }}">Activiity</a>
        </li>
    </ul>
      <div class="card card-flush">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
          <div class="card-title d-flex align-items-center gap-5">
            <a href="{{ route('admin.event.contingent') }}" class="btn btn-light btn-icon">
              <i class="ki-duotone ki-arrow-left fs-2">
              <span class="path1"></span>
              <span class="path2"></span>
              </i>
            </a>
            <h3 class="card-title align-items-start flex-column">
              <span class="card-label fw-bold fs-3 mb-1">Participant</span>
              <span class="text-muted fw-semibold fs-7">{{ $contingent->name }}</span>
            </h3>
          </div>
          {{-- <div class="card-toolbar">
            <a href="{{ route('coordinator.participant.add') }}" class="btn btn-primary d-flex align-items-center">
              <i class="ki-duotone ki-file-down fs-2">
              <span class="path1"></span>
              <span class="path2"></span>
              </i>    
               Export
            </a>
          </div> --}}
        </div>
        <div class="card-body pt-0">
          <form method="GET" class="card-title">
            <input type="hidden" name="page" value="{{ request('page', 1) }}">

            <div class="row">
                {{-- Search by Name --}}
                <div class="col mb-5">
                    <input type="text" name="q" class="form-control form-control-lg form-control-solid" placeholder="Search by name" value="{{ request('q') }}" />
                </div>

                {{-- Gender Filter --}}
                <div class="col mb-5">
                    <select class="form-select form-select-solid @error('gender') is-invalid @enderror" name="gender">
                        <option selected disabled>Select gender</option>
                        @foreach ($gender as $item)
                            <option value="{{ $item->id }}" {{ request('gender') == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                {{-- Member Type Filter --}}
                <div class="col mb-5">
                    <select class="form-select form-select-solid @error('memberType') is-invalid @enderror" name="memberType" id="memberType">
                        <option selected disabled>Select member type</option>
                        @foreach ($memberType as $item)
                            <option value="{{ $item->id }}" {{ request('memberType') == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Participant Type (dependent dropdown) --}}
                <div class="col mb-5">
                  <select class="form-select form-select-solid @error('participantType') is-invalid @enderror"
                          name="participantType"
                          id="participantType"
                          data-loaded="{{ request('memberType') ? 'true' : 'false' }}">
                      @if (request('memberType'))
                          <option selected disabled>Select participant type</option>
                          @foreach ($participantTypeList as $item)
                              <option value="{{ $item['id'] }}" {{ request('participantType') == $item['id'] ? 'selected' : '' }}>
                                  {{ $item['name'] }}
                              </option>
                          @endforeach
                      @else
                          <option selected disabled>Select a member type first</option>
                      @endif
                  </select>
                </div>
            </div>

            <div class="row">
                <div class="col-12 d-flex justify-content-end gap-5">
                  <a href="{{ route('coordinator.participant') }}" class="btn btn-light-danger btn-md">
                        <span class="svg-icon svg-icon-3">
                            <i class="ki-duotone ki-arrows-circle fs-4">
                              <span class="path1"></span>
                              <span class="path2"></span>
                            </i>
                            Reset
                        </span>
                    </a>
                    <button class="btn btn-danger btn-md" type="submit" id="button-addon2">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                            </svg>
                            Search
                        </span>
                    </button>
                </div>
            </div>
          </form>

          <div class="table-responsive">
            <table class="table table-row-dashed fs-6 gy-5">
              <thead>
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                  <th class="min-w-200px">Participant</th>
                  <th class="min-w-100px">Gender</th>
                  <th class="min-w-200px">Category</th>
                  <th class="text-end">Action</th>
                </tr>
              </thead>
              <tbody>
                @if ($participant->total() == 0)
                  <tr class="max-w-10px">
                    <td colspan="4" class="text-center">
                      No data available in table
                    </td>
                  </tr>
                @else
                  @foreach ($participant as $item)     
                    <tr>
                      <td class="d-flex align-items-center min-w-150px">
                        <div class="symbol-group symbol-hover me-3">
                          <div class="symbol symbol-45px symbol-circle" data-bs-toggle="tooltip" title="{{ $item->name }}">
                            <img src="{{ $item->user->photo_path ? Storage::url($item->user->photo_path) : 'https://ui-avatars.com/api/?background=FFEEF3&color=F8285A&bold=true&name='.$item->user->name }}" alt="">
                          </div>
                        </div>
                        <div class="d-flex flex-column">
                          <span class="text-gray-800 fw-bold mb-1">{{ $item->user->name }}</span>
                          <span class="text-gray-600 fs-7">{{ $item->user->member_id }}</span>
                        </div>
                        @if ($item->user->secretariat_id)
                        <div>
                          <a href="#" class="ms-2" data-bs-toggle="tooltip" data-bs-placement="right" title="SIAMO Verified">
                            <i class="ki-duotone ki-verify fs-1 text-danger">
                              <span class="path1"></span>
                              <span class="path2"></span>
                            </i>
                          </a>
                        </div>
                        @endif
                      </td>
                      <td>
                        <div class="text-start">
                          <div class="fs-6">{{ $item->user->gender->name }}</div>
                        </div>
                      </td>
                      <td>
                        <div class="text-start">
                          <div class="fs-6">{{ $item->user->memberType->name }} - {{ $item->participantType->name ?? '' }}</div>
                        </div>
                      </td>
                      <td class="text-end">
                        <button class="btn btn-light-danger btn-sm">
                          <i class="ki-outline ki-document"></i>
                          Certificate
                        </button>
                        <button class="btn btn-danger btn-sm">
                          <i class="ki-outline ki-scan-barcode"></i>
                          ID Card
                        </button>
                        <button data-bs-toggle="modal" data-bs-target="#detail{{$item->id}}" class="btn btn-light btn-icon btn-sm">
                          <i class="ki-outline ki-eye"></i>
                        </button>
                      </td>
                    </tr>
                  @endforeach
                @endif
              </tbody>
            </table>
          </div>
          <div class="d-flex flex-stack flex-wrap my-3">
            <div class="fs-6 fw-semibold text-gray-700">
                Showing {{ $participant->firstItem() }} to {{ $participant->lastItem() }} of {{ $participant->total() }}  records
            </div>
            <ul class="pagination">
              @if ($participant->onFirstPage())
                  <li class="page-item previous">
                      <a href="#" class="page-link disabled"><i class="previous"></i></a>
                  </li>
              @else
                  <li class="page-item previous">
                      <a href="{{ $participant->previousPageUrl() }}" class="page-link bg-light text-hover-danger"><i class="previous"></i></a>
                  </li>
              @endif
      
              @php
                  // Menghitung halaman pertama dan terakhir yang akan ditampilkan
                  $start = max($participant->currentPage() - 2, 1);
                  $end = min($start + 4, $participant->lastPage());
              @endphp
      
              @if ($start > 1)
                  <!-- Menampilkan tanda elipsis jika halaman pertama tidak termasuk dalam tampilan -->
                  <li class="page-item disabled">
                      <span class="page-link">...</span>
                  </li>
              @endif
      
              @foreach ($participant->getUrlRange($start, $end) as $page => $url)
                  <li class="page-item{{ ($page == $participant->currentPage()) ? ' active' : '' }}">
                      <a class="page-link {{ ($page == $participant->currentPage()) ? ' bg-danger' : 'text-hover-danger' }}" href="{{ $url }}">{{ $page }}</a>
                  </li>
              @endforeach
      
              @if ($end < $participant->lastPage())
                  <!-- Menampilkan tanda elipsis jika halaman terakhir tidak termasuk dalam tampilan -->
                  <li class="page-item disabled">
                      <span class="page-link">...</span>
                  </li>
              @endif
      
              @if ($participant->hasMorePages())
                  <li class="page-item next">
                      <a href="{{ $participant->nextPageUrl() }}" class="page-link bg-light text-hover-danger"><i class="next"></i></a>
                  </li>
              @else
                  <li class="page-item next">
                      <a href="#" class="page-link disabled"><i class="next"></i></a>
                  </li>
              @endif
          </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

@foreach ($participant as $item)
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
@endforeach
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