@extends('layouts.app')

@section('content')
  <div class="row g-5 g-xl-10">
    <div class="col-xl-12 mb-8">
      <div class="card card-flush">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
          <div class="card-title">
            <h3 class="card-title align-items-start flex-column">
              <span class="card-label fw-bold fs-3 mb-1">Event</span>
              <span class="text-muted fw-semibold fs-7">Activity List</span>
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
                  <form method="POST" action="{{ route('admin.event.activity.store') }}" class="modal-content" id="form">
                    @csrf
                      <div class="modal-header">
                          <h3 class="modal-title">Add New Activity</h3>
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
                          <label for="exampleFormControlInput1" class="required form-label">Description</label>
                          <textarea name="description" class="form-control form-control-solid @error('description') is-invalid @enderror"  placeholder="Description" rows="3" required>{{ old('description') }}</textarea>
                          @error('description')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                        <div class="mb-3">
                          <label for="exampleFormControlInput1" class="col-form-label required fw-bold fs-6">Type</label>
                          <select class="form-select form-select-solid @error('type') is-invalid @enderror" 
                            name="type" data-control="select2" data-placeholder="Choose type">
                              <option></option>
                              @foreach ($activityType as $item)
                                  <option value="{{ $item->id }}" {{ old('type') == $item->id ? 'selected' : '' }}>
                                      {{ $item->name }}
                                  </option>
                              @endforeach
                          </select>
                          @error('type')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                        <div class="mb-5">
                          <label for="exampleFormControlInput1" class="required form-label">Start Date</label>
                          <input type="datetime-local" name="start" class="form-control form-control-solid @error('start') is-invalid @enderror"  value="{{ old('start') }}" placeholder="start" required/>
                          @error('start')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                        <div class="mb-5">
                          <label for="exampleFormControlInput1" class="required form-label">End Date</label>
                          <input type="datetime-local" name="end" class="form-control form-control-solid @error('end') is-invalid @enderror"  value="{{ old('end') }}" placeholder="end" required/>
                          @error('end')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                        <div class="mb-5">
                          <label for="exampleFormControlInput1" class="required form-label">Max Participant</label>
                          <input type="number" name="max" class="form-control form-control-solid @error('max') is-invalid @enderror"  value="{{ old('max') }}" placeholder="Max Participant" required/>
                          @error('max')
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
                  <th class="min-w-50px">Name</th>
                  <th class="min-w-100px">Description</th>
                  <th class="min-w-50px text-center">Max Participant</th>
                  <th class="min-w-100px">Ongoing date</th>
                  <th class="min-w-100px">Crew</th>
                  <th class="text-end">Action</th>
                </tr>
              </thead>
              <tbody>
                @if ($activity->total() == 0)
                  <tr class="max-w-10px">
                    <td colspan="6" class="text-center">
                      No data available in table
                    </td>
                  </tr>
                @else
                  @foreach ($activity as $item)     
                    <tr>
                      <td>
                        <div class="text-start">
                          <div class="fs-6">
                            <div class="d-flex flex-column">
                            <span class="text-gray-800 fw-bold mb-1">{{ $item->name }}</span>
                            <span class="text-gray-600 fs-8">{{ $item->activityType->name }}</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="text-start">
                          <div class="fs-6">{{ $item->description }}</div>
                        </div>
                      </td>
                      <td>
                        <div class="text-center">
                          <div class="fs-6">{{ $item->max_participant }}</div>
                        </div>
                      </td>
                      <td>
                        <div class="text-start">
                          <div class="fs-6">{{ $item->start }} - {{ $item->end }}</div>
                        </div>
                      </td>
                      <td>
                        <div class="text-start">
                          <div class="symbol-group symbol-hover">
                            @foreach ($item->crewAssignment as $crew)
                              <div class="symbol symbol-circle symbol-50px" data-bs-toggle="tooltip" title="{{ $crew->crew->user->name }}"">
                                <img src="@if($crew->crew->user->photo_path) @else @endif https://ui-avatars.com/api/?background=FFEEF3&color=F8285A&bold=true&name={{ $crew->crew->user->name }}" alt=""/>
                              </div>
                            @endforeach
                        </div>
                        </div>
                      </td>
                      <td class="text-end">
                        <a href="#" class="btn btn-danger btn-sm btn-sm mb-3 mb-md-0" style="white-space: nowrap;">
                          <i class="ki-duotone ki-people">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                          </i>                          
                          Participant
                        </a>
                        <a href="#" class="btn btn-light text-danger btn-sm btn-sm mb-3 mb-md-0">
                          <i class="ki-duotone ki-security-user text-danger">
                            <span class="path1"></span>
                            <span class="path2"></span>
                          </i>                        
                          Crew
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
                Showing {{ $activity->firstItem() }} to {{ $activity->lastItem() }} of {{ $activity->total() }}  records
            </div>
            <ul class="pagination">
              @if ($activity->onFirstPage())
                  <li class="page-item previous">
                      <a href="#" class="page-link disabled"><i class="previous"></i></a>
                  </li>
              @else
                  <li class="page-item previous">
                      <a href="{{ $activity->previousPageUrl() }}" class="page-link bg-light text-hover-danger"><i class="previous"></i></a>
                  </li>
              @endif
      
              @php
                  // Menghitung halaman pertama dan terakhir yang akan ditampilkan
                  $start = max($activity->currentPage() - 2, 1);
                  $end = min($start + 4, $activity->lastPage());
              @endphp
      
              @if ($start > 1)
                  <!-- Menampilkan tanda elipsis jika halaman pertama tidak termasuk dalam tampilan -->
                  <li class="page-item disabled">
                      <span class="page-link">...</span>
                  </li>
              @endif
      
              @foreach ($activity->getUrlRange($start, $end) as $page => $url)
                  <li class="page-item{{ ($page == $activity->currentPage()) ? ' active' : '' }}">
                      <a class="page-link {{ ($page == $activity->currentPage()) ? ' bg-danger' : 'text-hover-danger' }}" href="{{ $url }}">{{ $page }}</a>
                  </li>
              @endforeach
      
              @if ($end < $activity->lastPage())
                  <!-- Menampilkan tanda elipsis jika halaman terakhir tidak termasuk dalam tampilan -->
                  <li class="page-item disabled">
                      <span class="page-link">...</span>
                  </li>
              @endif
      
              @if ($activity->hasMorePages())
                  <li class="page-item next">
                      <a href="{{ $activity->nextPageUrl() }}" class="page-link bg-light text-hover-danger"><i class="next"></i></a>
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

  @foreach ($activity as $item)
<div class="modal fade" tabindex="-1" id="edit{{$item->id}}">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('admin.event.activity.update', $item->id) }}" class="modal-content" id="formUpdate{{$item->id}}">
      @csrf
        <div class="modal-header">
            <h3 class="modal-title">Edit Activity</h3>
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
            <label for="exampleFormControlInput{{$item->id}}" class="required form-label">Description</label>
            <textarea name="description" class="form-control form-control-solid @error('description') is-invalid @enderror"  placeholder="Description" rows="3" required>{{ $item->description }}</textarea>
            @error('description')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="exampleFormControlInput{{$item->id}}" class="col-form-label required fw-bold fs-6">Type</label>
            <select class="form-select form-select-solid @error('type') is-invalid @enderror" name="type" data-control="select2" data-placeholder="Choose type">
              <option></option>
              @foreach ($activityType as $type)
                <option value="{{ $type->id }}" {{ $item->id == $type->id ? 'selected' : '' }}>
                  {{ $type->name }}
                </option>
              @endforeach
            </select>
            @error('type')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>
          <div class="mb-5">
            <label for="start{{$item->id}}" class="required form-label">Start Date</label>
            <input type="datetime-local" id="start{{$item->id}}" name="start" class="form-control form-control-solid @error('start') is-invalid @enderror" value="{{ $item->start }}" placeholder="start" required/>
            @error('start')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>
          <div class="mb-5">
            <label for="end{{$item->id}}" class="required form-label">End Date</label>
            <input type="datetime-local" id="end{{$item->id}}" name="end" class="form-control form-control-solid @error('end') is-invalid @enderror" value="{{ $item->end }}" placeholder="End" required/>
            @error('end')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>
          <div class="mb-5">
            <label for="max{{$item->id}}" class="required form-label">Max Participant</label>
            <input type="number" id="max{{$item->id}}" name="max" class="form-control form-control-solid @error('max') is-invalid @enderror" value="{{ $item->max_participant }}" placeholder="Max Participant" required/>
            @error('max')
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
@endsection