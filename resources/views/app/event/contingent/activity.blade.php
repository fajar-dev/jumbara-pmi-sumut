@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-xl-12 ">
      <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
        <li class="nav-item">
            <a class="nav-link  border-hover-danger" href="{{ route('admin.event.contingent.participant', $contingent->id) }}">Participant</a>
        </li>
        <li class="nav-item">
            <a class="nav-link border-hover-danger text-danger border-danger" href="{{ route('admin.event.contingent.activity', $contingent->id) }}">Activiity</a>
        </li>
      </ul>
    </div>
    <div class="col-xl-12 mb-5">
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
              <span class="card-label fw-bold fs-3 mb-1">Activity</span>
              <span class="text-muted fw-semibold fs-7">{{ $contingent->name }}</span>
            </h3>
          </div>
        </div>
        <div class="card-body pt-0">
            @foreach ($activities as $activity)

            @forelse($activity->activities as $item)
              <div class="d-md-flex justify-content-between align-items-center mb-10">
                <div class="d-flex align-items-lg-center w-md-50">
                  <span data-kt-element="bullet"
                        class="bullet bullet-vertical d-md-flex align-items-center min-h-150px mh-100 me-4 bg-danger"></span>
                  <div class="flex-grow-1 me-5">
                    <div class="text-gray-700 fw-bold fs-2">
                      {{ $item->name }}
                    </div>
                    <div class="text-gray-600 fw-semibold fs-5">
                      ( {{ $item->activityType->name }} )
                    </div>
                    <div class="text-gray-500 fs-7">
                      {!! $item->description !!}
                    </div>
                  </div>
                </div>
                <div class="d-flex flex-column flex-lg-row align-items-lg-center @if ($item->activityParticipations->count() > 0) justify-content-between @else justify-content-end @endif  w-md-50 w-100 w-lg-500px ">
                  @if ($item->activityParticipations->count() > 0)
                  @php
                    $totalAssigned = $item->total_participant_count ?? 0;
                    $maxParticipantSum = $item->activityParticipations->sum('max_participant');
                    $maxParticipant = $maxParticipantSum > 0 ? $maxParticipantSum : 1; // biar gak nol
                    $percentage = round(($totalAssigned / $maxParticipant) * 100);
                  @endphp

                    <div class="d-flex align-items-center flex-column mt-3 w-100 w-md-200px justify-content-end">
                      <div class="d-flex justify-content-between fw-bold fs-6 text-danger opacity-75 w-100 mt-auto mb-2">
                          <span>{{ $totalAssigned }} Assigned</span>
                          <span>{{ $percentage }}%</span>
                      </div>

                      <div class="h-8px mx-3 w-100 bg-danger bg-opacity-50 rounded">
                          <div class="bg-danger rounded h-8px" role="progressbar"
                              style="width: {{ $percentage }}%;"
                              aria-valuenow="{{ $percentage }}"
                              aria-valuemin="0" aria-valuemax="100">
                          </div>
                      </div>

                    </div>
                  @endif
                  <div class="d-flex justify-content-between align-items-center w-lg-50 w-100">
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
                        @if ($item->total_participant_count > 4)
                          @php
                            $remaining = $item->total_participant_count - 4;
                          @endphp
                          <div class="symbol symbol-circle symbol-40px">
                            <span class="symbol-label bg-danger text-inverse-danger fw-bold"> +{{ $remaining }} </span>                        </div>
                        @endif
                      </div>
                    </div>
                    <div>
                      <button class="btn btn-danger btn-icon btn-sm"
                              data-bs-toggle="modal"
                              data-bs-target="#attendance"
                              data-bs-id="{{ $item->id }}"
                              data-bs-name="{{ $item->name }}">
                        <i class="ki-duotone ki-fingerprint-scanning fs-2">
                          <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                          <span class="path4"></span><span class="path5"></span>
                        </i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            @empty
              <p class="text-muted"><em>No data available</em></p>
            @endforelse
            @endforeach
          </div>
        </div>
      </div>
  </div>

<div class="modal fade" tabindex="-1" id="attendance">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div>
          <h3 class="modal-title">Attendance</h3>
          <small class="text-gray-700" id="activityName"></small>
        </div>
        <div class="btn btn-icon btn-sm btn-active-light-danger ms-2" data-bs-dismiss="modal" aria-label="Close">
          <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
        </div>
      </div>
      <div class="modal-body">
        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search participant name...">
        <div class="table-responsive">
          <table class="table table-row-dashed fs-6 gy-5">
            <thead>
              <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th>Participant</th>
                <th>Gender</th>
                <th>Category</th>
                <th class="text-center">Attendance</th>
              </tr>
            </thead>
            <tbody id="participantBody">
              <tr><td colspan="2" class="text-center text-muted">Select an activity to view data.</td></tr>
            </tbody>
          </table>
        </div>
        <div id="paginationLinks" class="mt-3 text-center"></div>
        <div id="paginationInfo" class="text-muted fs-7 mt-2 text-center"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('attendance');
  let currentActivityId = null;
  let currentPage = 1;
  let searchQuery = '';

  function loadParticipants(activityId, page = 1, search = '') {
    const tbody = document.getElementById('participantBody');
    const pagination = document.getElementById('paginationLinks');
    const paginationInfo = document.getElementById('paginationInfo');

    tbody.innerHTML = `<tr><td colspan="4" class="text-center">Loading...</td></tr>`;
    pagination.innerHTML = '';
    paginationInfo.innerHTML = '';

    fetch(`/app/activity/${activityId}?page=${page}&q=${encodeURIComponent(search)}&contingentId={{ $contingent->id }}`)
      .then(response => response.json())
      .then(data => {
        tbody.innerHTML = '';

        if (data.data.length === 0) {
          tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">No participants found</td></tr>`;
        } else {
          data.data.forEach(p => {
            const photo = p.photoPath || `https://ui-avatars.com/api/?background=FFEEF3&color=F8285A&bold=true&name=${encodeURIComponent(p.name)}`;
            const hasAttendance = p.attendance && p.attendance[0]?.attendance;
            const attendanceDate = p.attendance && p.attendance[0]?.attendanceDate;
            const formattedDate = attendanceDate
              ? new Date(attendanceDate).toLocaleString('en-US', {
                  month: 'long',
                  day: 'numeric',
                  year: 'numeric',
                  hour: 'numeric',
                  minute: '2-digit',
                  hour12: true
                }).replace(':', '.')
              : 'Not attended';
            const isVerified = p.isVerified ? `
                <div>
                  <a href="#" class="ms-2" data-bs-toggle="tooltip" data-bs-placement="right" title="SIAMO Verified">
                    <i class="ki-duotone ki-verify fs-1 text-danger">
                      <span class="path1"></span>
                      <span class="path2"></span>
                    </i>
                  </a>
                </div>
              ` : '';

            tbody.innerHTML += `
              <tr>
                <td class="d-flex align-items-center min-w-150px">
                  <div class="symbol symbol-45px symbol-circle me-3">
                    <img src="${photo}" alt="">
                  </div>
                  <div>
                    <span class="text-gray-800 fw-bold">${p.name}</span><br>
                    <span class="text-gray-600 fs-7">${p.memberId ?? '-'}</span><br>
                  </div>
                  ${isVerified}
                </td>
                <td>
                  ${p.gender}
                </td>
                <td>
                  ${p.memberType} - ${p.participantType}
                </td>
                <td class="text-center">
                  ${hasAttendance ? `<span class="badge badge-primary">${formattedDate}</span><br>` : '-'}
                </td>
              </tr>`;
          });
        }

        // Pagination buttons
        if (data.last_page > 1) {
        let html = '';

        const current = data.current_page;
        const last = data.last_page;

        // Previous button
        if (current > 1) {
          html += `<button class="btn btn-sm btn-light mx-1" data-page="${current - 1}">&laquo;</button>`;
        }

        // First page
        if (current > 2) {
          html += `<button class="btn btn-sm btn-light mx-1" data-page="1">1</button>`;
          if (current > 3) {
            html += `<span class="mx-1 text-muted">...</span>`;
          }
        }

        // Current, before, and after
        const start = Math.max(current - 1, 1);
        const end = Math.min(current + 1, last);

        for (let i = start; i <= end; i++) {
          html += `<button class="btn btn-sm ${i === current ? 'btn-danger' : 'btn-light'} mx-1" data-page="${i}">${i}</button>`;
        }

        // Last page
        if (current < last - 1) {
          if (current < last - 2) {
            html += `<span class="mx-1 text-muted">...</span>`;
          }
          html += `<button class="btn btn-sm btn-light mx-1" data-page="${last}">${last}</button>`;
        }

        // Next button
        if (current < last) {
          html += `<button class="btn btn-sm btn-light mx-1" data-page="${current + 1}">&raquo;</button>`;
        }

        pagination.innerHTML = html;

        pagination.querySelectorAll('button').forEach(btn => {
          btn.addEventListener('click', function () {
            currentPage = parseInt(this.dataset.page);
            loadParticipants(currentActivityId, currentPage, searchQuery);
          });
        });
      }


        // Showing x to y of z records
        const start = (data.current_page - 1) * data.per_page + 1;
        const end = start + data.data.length - 1;
        paginationInfo.textContent = `Showing ${start} to ${end} of ${data.total} records`;
      });
  }

  modal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const name = button.getAttribute('data-bs-name');
    currentActivityId = button.getAttribute('data-bs-id');
    currentPage = 1;
    searchQuery = '';
    modal.querySelector('#activityName').textContent = name;
    document.getElementById('searchInput').value = '';
    loadParticipants(currentActivityId);
  });

  document.getElementById('searchInput').addEventListener('input', function () {
    searchQuery = this.value;
    currentPage = 1;
    loadParticipants(currentActivityId, currentPage, searchQuery);
  });
});
</script>
@endsection