@extends('layouts.app')
@section('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
  .nav .nav-item .nav-link.active {
    color: #dc3545 !important;
    border-color: #dc3545 !important;
  }
  .nav .nav-item .nav-link:hover {
    border-color: #dc3545 !important;
  }
</style>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-4 col-12">
    <div class="mb-10 p-0">
      <div id="qr-reader" class="" style="width: 100%;"></div>
      {{-- <div id="qr-result" class="mt-3 text-center fs-6 fw-bold text-success h"></div> --}}
    </div>
  </div>
  <div class="col-lg-8 col-12">
    <div class="card card-flush">
      <div class="card-header pt-5">
        <div class="card-title">
          <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6" role="tablist" id="attendanceTabs">
            <li class="nav-item" role="presentation">
              <a class="nav-link active" id="absent-tab" data-bs-toggle="tab" href="#absent" role="tab" aria-controls="absent" aria-selected="true" data-attendance="false">Absent</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="present-tab" data-bs-toggle="tab" href="#present" role="tab" aria-controls="present" aria-selected="false" data-attendance="true">Present</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="card-body">
        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search participant name...">
        <div class="table-responsive">
          <table class="table table-row-dashed fs-6 gy-5">
            <thead>
              <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th>Participant</th>
                <th>Contingent</th>
                <th>Gender</th>
                <th class="text-center">Attendance</th>
              </tr>
            </thead>
            <tbody id="participantBody">
              <tr>
                <td colspan="4" class="text-center text-muted">Loading data...</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="d-flex flex-row justify-content-between align-items-center">
          <div id="paginationInfo" class="text-muted fs-7 mt-2 text-center"></div>
          <div id="paginationLinks" class="mt-3 text-center"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="loadingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="loadingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered bg-transparent shadow-none">
    <div class="modal-content bg-transparent shadow-none">
      <div class="modal-body text-center">
        <div class="spinner-border text-danger" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-3">Please wait...</p>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
  let isProcessing = false;

  async function onScanSuccess(decodedText, decodedResult) {
    if (isProcessing) return;
    isProcessing = true;

    console.log(`QR Code scanned: ${decodedText}`);

    const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
    loadingModal.show();

    await html5QrcodeScanner.clear();

    try {
      const res = await fetch('/crew/assignment/{{$activity->id}}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ memberId: decodedText })
      });

      const data = await res.json();

      if (!res.ok) {
        throw new Error(data.message || 'Network response was not ok');
      }

      Swal.fire({
        text: 'Scan sukses & data berhasil dikirim!',
        icon: "success",
        buttonsStyling: false,
        confirmButtonText: "Ok",
        customClass: {
          confirmButton: "btn btn-success"
        }
      });
    } catch (err) {
      Swal.fire({
        text: err.message,
        icon: "error",
        buttonsStyling: false,
        confirmButtonText: "Ok, got it!",
        customClass: {
          confirmButton: "btn btn-danger"
        }
      });
    } finally {
      loadingModal.hide();
      isProcessing = false;

      html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    }
  }

  function onScanFailure(error) {
    // Bisa diabaikan
  }

  const html5QrcodeScanner = new Html5QrcodeScanner(
    "qr-reader", { fps: 10, qrbox: 250 }
  );

  html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const currentActivityId = {{$activity->id}};
  let currentPage = 1;
  let searchQuery = '';
  let currentAttendance = document.querySelector('#attendanceTabs .nav-link.active').dataset.attendance === 'true';

  const tbody = document.getElementById('participantBody');
  const pagination = document.getElementById('paginationLinks');
  const paginationInfo = document.getElementById('paginationInfo');
  const table = tbody.closest('table');
  const searchInput = document.getElementById('searchInput');
  const tabs = document.querySelectorAll('#attendanceTabs .nav-link');

  function loadParticipants(activityId, page = 1, search = '', attendance = true) {
    table.style.opacity = 0.5;
    pagination.innerHTML = '';
    paginationInfo.innerHTML = '';

    fetch(`/app/activity/${activityId}?page=${page}&q=${encodeURIComponent(search)}&attendance=${attendance}`)
      .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
      })
      .then(data => {
        table.style.opacity = 1;
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
                    <img src="${photo}" alt="Participant photo" />
                  </div>
                  <div>
                    <span class="text-gray-800 fw-bold">${p.name}</span><br />
                    <span class="text-gray-600 fs-7">${p.memberId ?? '-'}</span><br />
                  </div>
                  ${isVerified}
                </td>
                <td class="min-w-150px">
                  <div class="d-flex flex-column">
                    <span class="text-gray-800 fw-bold">${p.contingent}</span>
                    <span class="text-gray-600 fs-7"> ${p.memberType} - ${p.participantType}</span>
                  </div>
                </td>
                <td>${p.gender}</td>
                <td class="text-center">
                  ${hasAttendance ? `<span class="badge badge-primary">${formattedDate}</span><br>` : '-'}
                </td>
              </tr>`;
          });
        }

        // Pagination logic tetap sama
        if (data.last_page > 1) {
          let html = '';
          const current = data.current_page;
          const last = data.last_page;

          if (current > 1) {
            html += `<button class="btn btn-sm btn-light mx-1" data-page="${current - 1}">&laquo;</button>`;
          }

          if (current > 2) {
            html += `<button class="btn btn-sm btn-light mx-1" data-page="1">1</button>`;
            if (current > 3) {
              html += `<span class="mx-1 text-muted">...</span>`;
            }
          }

          const start = Math.max(current - 1, 1);
          const end = Math.min(current + 1, last);

          for (let i = start; i <= end; i++) {
            html += `<button class="btn btn-sm ${i === current ? 'btn-danger' : 'btn-light'} mx-1" data-page="${i}">${i}</button>`;
          }

          if (current < last - 1) {
            if (current < last - 2) {
              html += `<span class="mx-1 text-muted">...</span>`;
            }
            html += `<button class="btn btn-sm btn-light mx-1" data-page="${last}">${last}</button>`;
          }

          if (current < last) {
            html += `<button class="btn btn-sm btn-light mx-1" data-page="${current + 1}">&raquo;</button>`;
          }

          pagination.innerHTML = html;

          pagination.querySelectorAll('button').forEach(btn => {
            btn.addEventListener('click', function () {
              currentPage = parseInt(this.dataset.page);
              loadParticipants(currentActivityId, currentPage, searchQuery, currentAttendance);
            });
          });
        } else {
          pagination.innerHTML = '';
        }

        const start = (data.current_page - 1) * data.per_page + 1;
        const end = start + data.data.length - 1;
        paginationInfo.textContent = `Showing ${start} to ${end} of ${data.total} records`;

        // Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl);
        });
      })
      .catch(err => {
        table.style.opacity = 1;
        tbody.innerHTML = `<tr><td colspan="4" class="text-center text-danger">Error loading data.</td></tr>`;
        console.error('Fetch error:', err);
      });
  }

  // Load data awal
  loadParticipants(currentActivityId, currentPage, searchQuery, currentAttendance);

  // Search event
  searchInput.addEventListener('input', function () {
    searchQuery = this.value;
    currentPage = 1;
    loadParticipants(currentActivityId, currentPage, searchQuery, currentAttendance);
  });

  // Tab click event: ganti attendance param & reload data
  tabs.forEach(tab => {
    tab.addEventListener('shown.bs.tab', function (e) {
      currentAttendance = this.dataset.attendance === 'true';
      currentPage = 1;
      searchQuery = '';
      searchInput.value = '';
      loadParticipants(currentActivityId, currentPage, searchQuery, currentAttendance);
    });
  });

  setInterval(() => {
    loadParticipants(currentActivityId, currentPage, searchQuery, currentAttendance);
  }, 5000);
});
</script>
@endsection
