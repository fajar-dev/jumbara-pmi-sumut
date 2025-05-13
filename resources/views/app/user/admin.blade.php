@extends('layouts.app')

@section('content')
  <div class="row g-5 g-xl-10">
    <div class="col-xl-12 mb-8">
      <div class="card card-flush">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
          <div class="card-title">
            <h3 class="card-title align-items-start flex-column">
              <span class="card-label fw-bold fs-3 mb-1">User</span>
              <span class="text-muted fw-semibold fs-7">Admin List</span>
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
            <button data-bs-toggle="modal" data-bs-target="#add" class="btn btn-danger d-flex align-items-center"><i class="ki-duotone ki-plus fs-2"></i>
              Add
            </button>
            <div class="modal fade" tabindex="-1" id="add">
              <div class="modal-dialog">
                  <form method="POST" action="{{ route('admin.user.admin.store') }}" class="modal-content" id="form">
                    @csrf
                      <div class="modal-header">
                          <h3 class="modal-title">Add New Admin</h3>
                          <div class="btn btn-icon btn-sm btn-active-light-danger ms-2" data-bs-dismiss="modal" aria-label="Close">
                              <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                          </div>
                      </div>
                      <div class="modal-body">
                        <div class="mb-5">
                          <label class="form-label">Search Member</label>
                          <div class="row">
                            <div class="col-10">
                              <input type="number" class="form-control form-control-solid" id="memberSearch" placeholder="Member ID" required/>
                            </div>
                            <div class="col-1 ms-0 ps-lg-0">
                              <button type="button" class="btn btn-light-danger btn-icon search-btn" data-id="">
                                <i class="ki-duotone ki-magnifier search-icon fs-2">
                                  <span class="path1"></span>
                                  <span class="path2"></span>
                                </i>
                              </button>
                            </div>
                          </div>
                          <div class="mt-2">
                            <div id="coordinator-info" class="mt-3 p-2 rounded bg-light border small text-muted" style="min-height: 40px;">
                              <em>Member info will appear here...</em>            
                            </div>
                          </div>

                          {{-- Hidden fields --}}
                          <input type="hidden" name="memberId" id="hidden-memberId">
                          <input type="hidden" name="json" id="hidden-json">
                        </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                          <button type="submit" id="submit" class="btn btn-danger disabled">
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
                  <th class="min-w-100px">User</th>
                  <th class="min-w-100px">Email</th>
                  <th class="min-w-100px">Secretariat</th>
                  <th class="text-end">Action</th>
                </tr>
              </thead>
              <tbody>
                @if ($admin->total() == 0)
                  <tr class="max-w-10px">
                    <td colspan="6" class="text-center">
                      No data available in table
                    </td>
                  </tr>
                @else
                  @foreach ($admin as $item)     
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
                      </td>
                      <td>
                        <div class="text-start">
                          {{ $item->user->email }}
                        </div>
                      </td>
                      <td>
                        <div class="text-start">
                          {{ $item->user->memberType->name }} - {{ $item->user->secretariat->name }}
                        </div>
                      </td>
                      <td class="text-end">
                        <button class="btn btn-dark btn-icon btn-sm btn-del" id="{{ route('admin.user.admin.destroy', $item->id) }}">
                          <i class="ki-outline ki-trash btn-del" id="{{ route('admin.user.admin.destroy', $item->id) }}">
                          </i>
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
                Showing {{ $admin->firstItem() }} to {{ $admin->lastItem() }} of {{ $admin->total() }}  records
            </div>
            <ul class="pagination">
              @if ($admin->onFirstPage())
                  <li class="page-item previous">
                      <a href="#" class="page-link disabled"><i class="previous"></i></a>
                  </li>
              @else
                  <li class="page-item previous">
                      <a href="{{ $admin->previousPageUrl() }}" class="page-link bg-light text-hover-danger"><i class="previous"></i></a>
                  </li>
              @endif
      
              @php
                  // Menghitung halaman pertama dan terakhir yang akan ditampilkan
                  $start = max($admin->currentPage() - 2, 1);
                  $end = min($start + 4, $admin->lastPage());
              @endphp
      
              @if ($start > 1)
                  <!-- Menampilkan tanda elipsis jika halaman pertama tidak termasuk dalam tampilan -->
                  <li class="page-item disabled">
                      <span class="page-link">...</span>
                  </li>
              @endif
      
              @foreach ($admin->getUrlRange($start, $end) as $page => $url)
                  <li class="page-item{{ ($page == $admin->currentPage()) ? ' active' : '' }}">
                      <a class="page-link {{ ($page == $admin->currentPage()) ? ' bg-danger' : 'text-hover-danger' }}" href="{{ $url }}">{{ $page }}</a>
                  </li>
              @endforeach
      
              @if ($end < $admin->lastPage())
                  <!-- Menampilkan tanda elipsis jika halaman terakhir tidak termasuk dalam tampilan -->
                  <li class="page-item disabled">
                      <span class="page-link">...</span>
                  </li>
              @endif
      
              @if ($admin->hasMorePages())
                  <li class="page-item next">
                      <a href="{{ $admin->nextPageUrl() }}" class="page-link bg-light text-hover-danger"><i class="next"></i></a>
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
              const input = document.getElementById(`memberSearch`);
              const memberId = input.value;
              const info = document.getElementById(`coordinator-info`);
              const submitBtn = document.getElementById(`submit`);
  
              // Hidden fields
              const hiddenMemberId = document.getElementById(`hidden-memberId`);
              const hiddenJson = document.getElementById(`hidden-json`);
  
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
                      const d = data.data || data;
  
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
              document.getElementById(`memberSearch`).value = '';
              document.getElementById(`coordinator-info`).innerHTML = `<em>Coordinator info will appear here...</em>`;
              document.getElementById(`submit`).classList.add('disabled');
  
              document.getElementById(`hidden-memberId`).value = '';
              document.getElementById(`hidden-json`).value = '';
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