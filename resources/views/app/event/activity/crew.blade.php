@extends('layouts.app')

@section('content')
  <div class="row g-5 g-xl-10">
    <div class="col-xl-12 mb-8">
      <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
        <li class="nav-item">
            <a class="nav-link border-hover-danger" href="{{ route('admin.event.activity.participant', $activity->id) }}">Participant</a>
        </li>
        <li class="nav-item">
            <a class="nav-link border-hover-danger text-danger border-danger" href="{{ route('admin.event.activity.crew', $activity->id) }}">Crew</a>
        </li>
    </ul>
      <div class="card card-flush">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
          <div class="card-title d-flex align-items-center gap-5">
            <a href="{{ route('admin.event.activity') }}" class="btn btn-light btn-icon">
              <i class="ki-duotone ki-arrow-left fs-2">
              <span class="path1"></span>
              <span class="path2"></span>
              </i>
            </a>
            <h3 class="card-title align-items-start flex-column">
              <span class="card-label fw-bold fs-3 mb-1">Crew</span>
              <span class="text-muted fw-semibold fs-7">{{ $activity->name }}</span>
            </h3>
          </div>
        </div>
        <div class="card-body pt-0">
          <form method="GET" class="card-title">
            <input type="hidden" name="page" value="{{ request('page', 1) }}">

            <div class="row">
                {{-- Search by Name --}}
                <div class="col mb-5">
                    <input type="text" name="q" class="form-control form-control-lg form-control-solid" placeholder="Search by name" value="{{ request('q') }}" />
                </div>
            </div>

            <div class="row">
                <div class="col-12 d-flex justify-content-end gap-5">
                  <a href="{{ route('admin.event.activity.participant', $activity->id) }}" class="btn btn-light-danger btn-md">
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
                   <th class="min-w-100px">User</th>
                  <th class="min-w-100px">Email</th>
                  <th class="min-w-100px">Secretariat</th>
                </tr>
              </thead>
              <tbody>
                @if ($crew->total() == 0)
                  <tr class="max-w-10px">
                    <td colspan="3" class="text-center">
                      No data available in table
                    </td>
                  </tr>
                @else
                  @foreach ($crew as $item)     
                    <tr>
                     <td class="d-flex align-items-center min-w-150px">
                        <div class="symbol-group symbol-hover me-3">
                          <div class="symbol symbol-45px symbol-circle">
                            <img src="{{ $item->crew->user->photo_path ? Storage::url($item->crew->user->photo_path) : 'https://ui-avatars.com/api/?background=FFEEF3&color=F8285A&bold=true&name='.$item->crew->user->name }}" alt="">
                          </div>
                        </div>
                        <div class="d-flex flex-column">
                          <span class="text-gray-800 fw-bold mb-1">{{ $item->crew->user->name }}</span>
                          <span class="text-gray-600 fs-7">{{ $item->crew->user->member_id }}</span>
                        </div>
                      </td>
                      <td>
                        <div class="text-start">
                          {{ $item->crew->user->email }}
                        </div>
                      </td>
                      <td>
                        <div class="text-start">
                          {{ $item->crew->user->memberType->name }} - {{ $item->crew->user->secretariat->name }}
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
                Showing {{ $crew->firstItem() }} to {{ $crew->lastItem() }} of {{ $crew->total() }}  records
            </div>
            <ul class="pagination">
              @if ($crew->onFirstPage())
                  <li class="page-item previous">
                      <a href="#" class="page-link disabled"><i class="previous"></i></a>
                  </li>
              @else
                  <li class="page-item previous">
                      <a href="{{ $crew->previousPageUrl() }}" class="page-link bg-light text-hover-danger"><i class="previous"></i></a>
                  </li>
              @endif
      
              @php
                  // Menghitung halaman pertama dan terakhir yang akan ditampilkan
                  $start = max($crew->currentPage() - 2, 1);
                  $end = min($start + 4, $crew->lastPage());
              @endphp
      
              @if ($start > 1)
                  <!-- Menampilkan tanda elipsis jika halaman pertama tidak termasuk dalam tampilan -->
                  <li class="page-item disabled">
                      <span class="page-link">...</span>
                  </li>
              @endif
      
              @foreach ($crew->getUrlRange($start, $end) as $page => $url)
                  <li class="page-item{{ ($page == $crew->currentPage()) ? ' active' : '' }}">
                      <a class="page-link {{ ($page == $crew->currentPage()) ? ' bg-danger' : 'text-hover-danger' }}" href="{{ $url }}">{{ $page }}</a>
                  </li>
              @endforeach
      
              @if ($end < $crew->lastPage())
                  <!-- Menampilkan tanda elipsis jika halaman terakhir tidak termasuk dalam tampilan -->
                  <li class="page-item disabled">
                      <span class="page-link">...</span>
                  </li>
              @endif
      
              @if ($crew->hasMorePages())
                  <li class="page-item next">
                      <a href="{{ $crew->nextPageUrl() }}" class="page-link bg-light text-hover-danger"><i class="next"></i></a>
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
@endsection