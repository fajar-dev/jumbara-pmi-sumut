@extends('layouts.app')

@section('content')
  <div class="row g-5 g-xl-10">
    <div class="col-xl-12 mb-8">
      <div class="card card-flush">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
          <div class="card-title">
            <h3 class="card-title align-items-start flex-column">
              <span class="card-label fw-bold fs-3 mb-1">Event</span>
              <span class="text-muted fw-semibold fs-7">Contingent List</span>
            </h3>
          </div>
          <div class="card-toolbar">
            <form method="GET" class="card-title">
              <input type="hidden" name="page" value="{{ request('page', 1) }}">
              <div class="input-group d-flex align-items-center position-relative my-1">
                <input type="text"  class="form-control form-control-solid rounded-start-3 ps-5 rounded-0" name="q" value="{{ request('q') }}" placeholder="Search" />
                <button class="btn btn-danger btn-icon" type="submit" id="button-addon2">
                  <span class="svg-icon svg-icon-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                      <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                    </svg>
                  </span>
                </button>
              </div>
              <!--end::Search-->
            </form>
            <button data-bs-toggle="modal" data-bs-target="#add"  class="btn btn-danger d-flex align-items-center"><i class="ki-duotone ki-plus fs-2"></i>
              Add
            </button>
            <div class="modal fade" tabindex="-1" id="add">
              <div class="modal-dialog">
                  <form method="POST" action="{{ route('admin.event.contingent.store') }}" class="modal-content" id="form">
                    @csrf
                      <div class="modal-header">
                          <h3 class="modal-title">Add New Contingent</h3>
                          <div class="btn btn-icon btn-sm btn-active-light-danger ms-2" data-bs-dismiss="modal" aria-label="Close">
                              <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                          </div>
                      </div>
                      <div class="modal-body">
                        <div class="mb-5">
                          <label for="exampleFormControlInput1" class="required form-label">Name</label>
                          <input type="text" name="name" class="form-control form-control-solid @error('name') is-invalid @enderror"  value="{{ old('name') }}" placeholder="Name" required/>
                          @error('name')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                        <div class="mb-5">
                          <label for="exampleFormControlInput1" class="required form-label">Province ID</label>
                          <input type="text" name="provinceId" class="form-control form-control-solid @error('provinceId') is-invalid @enderror"  value="{{ old('provinceId') }}" placeholder="Province ID" required/>
                          @error('provinceId')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                        <div class="mb-5">
                          <label for="exampleFormControlInput1" class="required form-label">City ID</label>
                          <input type="text" name="cityId" class="form-control form-control-solid @error('cityId') is-invalid @enderror"  value="{{ old('cityId') }}" placeholder="City ID" required/>
                          @error('cityId')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                        
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
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
        <div class="card-body pt-0">
          <div class="table-responsive">
            <table class="table table-row-dashed fs-6 gy-5">
              <thead>
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                  <th class="min-w-100px">Name</th>
                  <th class="min-w-50px text-center">Province ID</th>
                  <th class="min-w-50px text-center">city ID</th>
                  <th class="min-w-100px">Coordinator</th>
                  <th class="text-end">Action</th>
                </tr>
              </thead>
              <tbody>
                @if ($contingent->total() == 0)
                  <tr class="max-w-10px">
                    <td colspan="6" class="text-center">
                      No data available in table
                    </td>
                  </tr>
                @else
                  @foreach ($contingent as $item)     
                    <tr>
                      <td>
                        <div class="text-start">
                          <div class="fs-6 fw-bold">
                            <div class="fs-6 fw-bold">{{ $item->name }}</div>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="text-center">
                          <div class="fs-6">{{ $item->administrative_area_level_1 }}</div>
                        </div>
                      </td>
                      <td>
                        <div class="text-center">
                          <div class="fs-6">{{ $item->administrative_area_level_2 }}</div>
                        </div>
                      </td>
                      <td class="d-flex align-items-center min-w-100px">
                        @if ($item->coordinator)
                          <div class="symbol-group symbol-hover me-3">
                            <div class="symbol symbol-45px symbol-circle" data-bs-toggle="tooltip" title="{{ $item->coordinator->user->name }}">
                              <img src="{{ $item->coordinator->user->photo_path ? Storage::url($item->coordinator->user->photo_path) : 'https://ui-avatars.com/api/?background=FFEEF3&color=F8285A&bold=true&name='.$item->coordinator->user->name }}" alt="">
                            </div>
                          </div>
                          <div class="d-flex flex-column">
                            <span class="text-gray-800 fw-bold mb-1">{{ $item->coordinator->user->name }}</span>
                            <span class="text-gray-600 fs-8">{{ $item->coordinator->user->member_id }}</span>
                            <span class="text-gray-600 fs-8">{{ $item->coordinator->user->email }}</span>
                          </div>
                          <button data-bs-toggle="modal" data-bs-target="#coordinator{{$item->id}}" class="btn text-danger btn-sm">
                            <i class="ki-duotone ki-pencil fs-2 text-danger">
                              <span class="path1"></span>
                              <span class="path2"></span>
                            </i>
                          </button>
                        @else
                        <div class="text-start">
                          <div class="fs-6">
                            <button data-bs-toggle="modal" data-bs-target="#coordinator{{$item->id}}" class="btn text-danger btn-sm">
                              <i class="ki-duotone ki-plus fs-2 text-danger">
                                <span class="path1"></span>
                                <span class="path2"></span>
                              </i>
                              Add Coordinator
                            </button>
                          </div>
                        </div>
                        @endif
                        
                      </td>
                      <td class="text-end">
                        <a href="{{ route('admin.event.contingent.participant', $item->id) }}" class="btn btn-danger btn-sm mb-3 mb-md-0" style="white-space: nowrap;">
                          <i class="ki-duotone ki-people">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                          </i>                          
                          Participant
                        </a>
                        <a href="{{ route('admin.event.contingent.activity', $item->id) }}" class="btn btn-light-danger btn-sm mb-3 mb-md-0">
                          <i class="ki-duotone ki-flag">
                            <span class="path1"></span>
                            <span class="path2"></span>
                          </i>                          
                          Activity
                        </a>
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
                            <a data-bs-toggle="modal" data-bs-target="#edit{{$item->id}}"class="menu-link text-hover-danger bg-hover-light px-3">Edit</a>
                          </div>
                          <div class="menu-item px-3">
                            <a id="{{ route('admin.event.contingent.destroy', $item->id) }}" class="menu-link text-hover-danger bg-hover-light px-3 btn-del">Delete</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                @endif
              </tbody>
            </table>
          </div>
          <div class="d-flex flex-stack flex-wrap my-3">
            <div class="fs-6 fw-semibold text-gray-700">
                Showing {{ $contingent->firstItem() }} to {{ $contingent->lastItem() }} of {{ $contingent->total() }}  records
            </div>
            <ul class="pagination">
              @if ($contingent->onFirstPage())
                  <li class="page-item previous">
                      <a href="#" class="page-link disabled"><i class="previous"></i></a>
                  </li>
              @else
                  <li class="page-item previous">
                      <a href="{{ $contingent->previousPageUrl() }}" class="page-link bg-light text-hover-danger"><i class="previous"></i></a>
                  </li>
              @endif
      
              @php
                  // Menghitung halaman pertama dan terakhir yang akan ditampilkan
                  $start = max($contingent->currentPage() - 2, 1);
                  $end = min($start + 4, $contingent->lastPage());
              @endphp
      
              @if ($start > 1)
                  <!-- Menampilkan tanda elipsis jika halaman pertama tidak termasuk dalam tampilan -->
                  <li class="page-item disabled">
                      <span class="page-link">...</span>
                  </li>
              @endif
      
              @foreach ($contingent->getUrlRange($start, $end) as $page => $url)
                  <li class="page-item{{ ($page == $contingent->currentPage()) ? ' active' : '' }}">
                      <a class="page-link {{ ($page == $contingent->currentPage()) ? ' bg-danger' : 'text-hover-danger' }}" href="{{ $url }}">{{ $page }}</a>
                  </li>
              @endforeach
      
              @if ($end < $contingent->lastPage())
                  <!-- Menampilkan tanda elipsis jika halaman terakhir tidak termasuk dalam tampilan -->
                  <li class="page-item disabled">
                      <span class="page-link">...</span>
                  </li>
              @endif
      
              @if ($contingent->hasMorePages())
                  <li class="page-item next">
                      <a href="{{ $contingent->nextPageUrl() }}" class="page-link bg-light text-hover-danger"><i class="next"></i></a>
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

@foreach ($contingent as $item)
<div class="modal fade" tabindex="-1" id="edit{{$item->id}}">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('admin.event.contingent.update', $item->id) }}" class="modal-content" id="formUpdate{{$item->id}}">
      @csrf
        <div class="modal-header">
            <h3 class="modal-title">Edit Contingent</h3>
            <div class="btn btn-icon btn-sm btn-active-light-danger ms-2" data-bs-dismiss="modal" aria-label="Close">
                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
            </div>
        </div>
        <div class="modal-body">
          <div class="mb-5">
            <label for="name{{$item->id}}" class="required form-label">Name</label>
            <input type="text" id="name{{$item->id}}" name="name" class="form-control form-control-solid @error('name') is-invalid @enderror" value="{{ $item->name }}" placeholder="Name" required/>
            @error('name')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>
          <div class="mb-5">
            <label for="province{{$item->id}}" class="required form-label">Province ID</label>
            <input type="text" id="province{{$item->id}}" name="provinceId" class="form-control form-control-solid @error('provinceId') is-invalid @enderror" value="{{ $item->administrative_area_level_1 }}" placeholder="provinceId" required/>
            @error('provinceId')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>
          <div class="mb-5">
            <label for="city{{$item->id}}" class="required form-label">City ID</label>
            <input type="text" id="city{{$item->id}}" name="cityId" class="form-control form-control-solid @error('cityId') is-invalid @enderror" value="{{ $item->administrative_area_level_2 }}" placeholder="cityId" required/>
            @error('cityId')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger" id="submit{{$item->id}}">
              <span class="indicator-label">Save</span>
              <span class="indicator-progress" style="display: none;">Loading... 
              <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </form>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="coordinator{{$item->id}}" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <form method="POST" action="{{ route('admin.event.contingent.coordinator.store', $item->id) }}" class="modal-content" id="formUpdate{{$item->id}}">
      @csrf
      <div class="modal-header">
          <h3 class="modal-title">Coordinator</h3>
          <div class="btn btn-icon btn-sm btn-active-light-danger ms-2" data-bs-dismiss="modal" aria-label="Close">
              <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
          </div>
      </div>
      <div class="modal-body">
        <div class="mb-5">
          <label class="form-label">Search Member</label>
          <div class="row">
            <div class="col-10">
              <input type="number" class="form-control form-control-solid" id="memberSearch{{$item->id}}" placeholder="Member ID" required/>
            </div>
            <div class="col-1 ms-0 ps-lg-0">
              <button type="button" class="btn btn-light-danger btn-icon search-btn" data-id="{{$item->id}}">
                <i class="ki-duotone ki-magnifier search-icon fs-2">
                  <span class="path1"></span>
                  <span class="path2"></span>
                </i>
              </button>
            </div>
          </div>
          <div class="mt-2">
            <div id="coordinator-info{{$item->id}}" class="mt-3 p-2 rounded bg-light border small text-muted" style="min-height: 40px;">
              <em>Coordinator info will appear here...</em>            
            </div>
          </div>

          {{-- Hidden fields --}}
          <input type="hidden" name="memberId" id="hidden-memberId{{ $item->id }}">
          <input type="hidden" name="json" id="hidden-json{{ $item->id }}">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light btn-cancel" data-id="{{ $item->id }}" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger disabled" id="submit-coor{{$item->id}}">
            <span class="indicator-label">Save</span>
            <span class="indicator-progress" style="display: none;">Loading... 
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
      </div>
    </form>
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
      // Handle Search button click
      document.querySelectorAll('.search-btn').forEach(button => {
          button.addEventListener('click', function () {
              const id = this.dataset.id;
              const input = document.getElementById(`memberSearch${id}`);
              const memberId = input.value;
              const info = document.getElementById(`coordinator-info${id}`);
              const submitBtn = document.getElementById(`submit-coor${id}`);
  
              // Hidden fields
              const hiddenMemberId = document.getElementById(`hidden-memberId${id}`);
              const hiddenJson = document.getElementById(`hidden-json${id}`);
  
              if (!memberId) {
                  info.innerHTML = `<em class="text-danger">Member ID is required.</em>`;
                  submitBtn.classList.add('disabled');
                  return;
              }
  
              info.innerHTML = `<em>Searching...</em>`;
              submitBtn.classList.add('disabled');
  
              fetch(`{{ route('service') }}?memberId=${memberId}`)
                  .then(response => response.json())
                  .then(data => {
                      const d = data.data || data; // fleksibel untuk response nested atau flat
  
                      if (d?.memberId) {
                          info.innerHTML = `
                              <strong>${d.name}</strong> <br/> ${d.email}<br>
                              <strong>${d.category?.name}</strong> - ${d.membership?.name}<br>
                          `;
                          submitBtn.classList.remove('disabled');
  
                          hiddenMemberId.value = d.memberId || '';
                          hiddenJson.value = JSON.stringify(d);
                      } else {
                          info.innerHTML = `<em class="text-warning">No data found.</em>`;
                          submitBtn.classList.add('disabled');
  
                          hiddenMemberId.value = '';
                          hiddenJson.value = '';
                      }
                  })
                  .catch(() => {
                      info.innerHTML = `<em class="text-danger">Failed to fetch data.</em>`;
                      submitBtn.classList.add('disabled');
                  });
          });
      });
  
      // Cancel button reset
      document.querySelectorAll('.btn-cancel').forEach(button => {
          button.addEventListener('click', function () {
              const id = this.dataset.id;
              document.getElementById(`memberSearch${id}`).value = '';
              document.getElementById(`coordinator-info${id}`).innerHTML = `<em>Coordinator info will appear here...</em>`;
              document.getElementById(`submit${id}`).classList.add('disabled');
  
              document.getElementById(`hidden-memberId${id}`).value = '';
              document.getElementById(`hidden-json${id}`).value = '';
          });
      });
  
      // Prevent form submit if button has 'disabled' class
      document.querySelectorAll('form[id^="formUpdate"]').forEach(form => {
          form.addEventListener('submit', function (e) {
              const submitButton = this.querySelector('button[type="submit"]');
              if (submitButton.classList.contains('disabled')) {
                  e.preventDefault();
              }
          });
      });
  });
  </script>
  
@endsection