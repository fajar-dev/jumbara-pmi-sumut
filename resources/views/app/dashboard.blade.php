@extends('layouts.app')

@section('content')
  <div class="row g-5 g-xl-10">
    <div class="col-xxl-12 mb-10">
      <div class="card bgi-no-repeat bgi-position-x-end bgi-size-cover" style="background-size: auto 100%; background-image: url('https://preview.keenthemes.com/metronic8/demo4/assets/media/misc/taieri.svg')">
        <div class="card-body pt-9 pb-0">
          <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
            <div class="flex-grow-1">
              <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                <div class="d-flex flex-column">
                  <div class="d-flex align-items-center mb-2">
                    <a href="#" class="text-gray-900 text-hover-danger fs-1 fw-bolder me-1">Hi!, {{ Auth::user()->name }}</a>
                  </div>
                  <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                    <span class="d-flex align-items-center text-gray-400 me-5 mb-2">
                      Have a nice day
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@if ((Auth::user()->crew OR Auth::user()->admin) OR Auth::user()->coordinator)
  <div class="row g-5 g-xl-8">
    <div class="col-xl-12 mb-8">
      <form method="GET" class="d-md-flex flex-row-fluid justify-content-end align-items-center gap-5">
        <label class="fw-bold fs-5" for="">Filter:</label>
        <select name="contingentId" class="form-control form-select  w-100 mw-250px">
          @if (Auth::user()->crew OR Auth::user()->admin)
            <option value="" selected>All</option>
            @foreach ($contingent as $item)
              <option value="{{ $item->id }}" @if($selectedContingentId == $item->id) selected  @endif>{{ $item->name }}</option>
            @endforeach
          @elseif(Auth::user()->coordinator)
            <option value="{{ Auth::user()->contingent_id }}" selected>{{ Auth::user()->contingent->name }}</option>
          @endif
        </select>
        <button type="submit" class="btn btn-danger">Submit</button>
      </form>
    </div>
  </div>

  <div class="row g-5 g-5">
    <div class="col-lg-4 col-md-6 col-12">
      <div class="card card-flush">
        <div class="card-header">
          <h3 class="card-title">Member Type</h3>
        </div>
        <div class="card-body pt-9 pb-0" id="memberTypeChart"></div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 col-12">
      <div class="card card-flush">
        <div class="card-header">
          <h3 class="card-title">Participant Type</h3>
        </div>
        <div class="card-body pt-9 pb-0" id="participantTypeChart"></div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 col-12">
      <div class="card card-flush">
        <div class="card-header">
          <h3 class="card-title">Siamo Verified</h3>
        </div>
        <div class="card-body pt-9 pb-0" id="siamoVerifiedChart"></div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 col-12">
      <div class="card card-flush">
        <div class="card-header">
          <h3 class="card-title">Gender</h3>
        </div>
        <div class="card-body pt-9 pb-0" id="genderChart"></div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 col-12">
      <div class="card card-flush">
        <div class="card-header">
          <h3 class="card-title">Religion</h3>
        </div>
        <div class="card-body pt-9 pb-0" id="religionChart"></div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 col-12">
      <div class="card card-flush">
        <div class="card-header">
          <h3 class="card-title">Blood Type</h3>
        </div>
        <div class="card-body pt-9 pb-0" id="bloodTypeChart"></div>
      </div>
    </div>

    <div class="col-12">
      <div class="card card-flush">
        <div class="card-header">
          <h3 class="card-title">Activity</h3>
        </div>
        <div class="card-body pt-9 pb-0" id="activityChartContainer"></div>
      </div>
    </div>
  </div>
@endif
@endsection

@section('script')
@if ((Auth::user()->crew OR Auth::user()->admin) OR Auth::user()->coordinator)
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      function createPieChart(ctx, labels, data) {
        return new Chart(ctx, {
          type: 'pie',
          data: {
            labels: labels,
            datasets: [{
              data: data,
              backgroundColor: [
                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                '#FF9F40', '#8A2BE2', '#00CED1', '#FF4500', '#32CD32'
              ],
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                position: 'bottom',
              }
            }
          }
        });
      }

      function createBarChart(ctx, labels, datasets) {
        return new Chart(ctx, {
          type: 'bar',
          data: {
            labels: labels,
            datasets: datasets
          },
          options: {
            responsive: true,
            scales: {
              y: {
                beginAtZero: true,
                precision: 0
              }
            },
            plugins: {
              legend: {
                position: 'top',
              }
            }
          }
        });
      }

      // Pie charts data
      const memberTypeData = @json(array_values($memberTypeCounts));
      const memberTypeLabels = @json(array_keys($memberTypeCounts));

      const participantTypeData = @json(array_values($participantTypeCounts));
      const participantTypeLabels = @json(array_keys($participantTypeCounts));

      const siamoVerifiedData = [
        {{ $siamoVerified['verified'] }},
        {{ $siamoVerified['notVerified'] }}
      ];
      const siamoVerifiedLabels = ['Verified', 'Not Verified'];

      const genderData = @json(array_values($genderCounts));
      const genderLabels = @json(array_keys($genderCounts));

      const religionData = @json(array_values($religionCounts));
      const religionLabels = @json(array_keys($religionCounts));

      const bloodTypeData = @json(array_values($bloodTypeCounts));
      const bloodTypeLabels = @json(array_keys($bloodTypeCounts));

      // Activity bar chart data
      const activityLabels = @json($activity->pluck('name'));
      const activityAttendanceData = @json($activity->pluck('attendance'));
      const activityNotAttendanceData = @json($activity->pluck('notAttendance'));

      const activityDatasets = [
        {
          label: 'Attendance',
          data: activityAttendanceData,
          backgroundColor: '#36A2EB'
        },
        {
          label: 'Not Attendance',
          data: activityNotAttendanceData,
          backgroundColor: '#FF6384'
        }
      ];

      // Render pie charts
      const chartsConfig = [
        { containerId: 'memberTypeChart', labels: memberTypeLabels, data: memberTypeData },
        { containerId: 'participantTypeChart', labels: participantTypeLabels, data: participantTypeData },
        { containerId: 'siamoVerifiedChart', labels: siamoVerifiedLabels, data: siamoVerifiedData },
        { containerId: 'genderChart', labels: genderLabels, data: genderData },
        { containerId: 'religionChart', labels: religionLabels, data: religionData },
        { containerId: 'bloodTypeChart', labels: bloodTypeLabels, data: bloodTypeData },
      ];

      chartsConfig.forEach(({containerId, labels, data}) => {
        const container = document.getElementById(containerId);
        if (!container) return;

        const canvas = document.createElement('canvas');
        container.appendChild(canvas);

        createPieChart(canvas.getContext('2d'), labels, data);
      });

      // Render activity bar chart
      const activityContainer = document.getElementById('activityChartContainer');
      if (activityContainer) {
        const canvas = document.createElement('canvas');
        activityContainer.appendChild(canvas);

        createBarChart(canvas.getContext('2d'), activityLabels, activityDatasets);
      }
    });
  </script>
@endif

@endsection
