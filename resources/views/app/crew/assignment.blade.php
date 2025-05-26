@extends('layouts.app')

@section('content')
  <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
    @foreach ($assignment as $index => $item)
      @php
        $startTime = \Carbon\Carbon::parse($item->activity->start)->format('Y-m-d\TH:i:s');
        $endTime = \Carbon\Carbon::parse($item->activity->end)->format('Y-m-d\TH:i:s');
      @endphp
      <div class="col">
        <div class="card h-100">
          <div class="card-header h-200px">
            <div class="card-title d-flex flex-column pt-10">
               <div class="d-flex flex-column pb-10 justify-content-end">                
                  <span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">{{ $item->activity->participantAssignment->count() }}</span>
                  <span class="text-gray-500 pt-1 fw-semibold fs-6">Participant</span>
              </div> 
              <h3 class="fw-bold fs-3 mb-1">{{ $item->activity->name }}</h3>
              <div class="text-muted fs-7">
                {{ \Carbon\Carbon::parse($item->activity->start)->format('F d, Y h.iA') }} –
                {{ \Carbon\Carbon::parse($item->activity->end)->format('F d, Y h.iA') }}
              </div>
            </div>
          </div>
          <div class="card-body">
            <a href="{{ route('crew.assignment.attendance', $item->activity->id) }}" id="startBtn-{{ $index }}" class="btn btn-danger disabled w-100">
              Loading...
            </a>
          </div>
        </div>
      </div>

      <script>
        document.addEventListener('DOMContentLoaded', function () {
          const startBtn = document.getElementById('startBtn-{{ $index }}');
          const startTimeOriginal = new Date('{{ $startTime }}').getTime();
          const endTime = new Date('{{ $endTime }}').getTime();
          // 15 minutes before start
          const startTime = startTimeOriginal - 15 * 60 * 1000;

          const timer = setInterval(() => {
            const now = new Date().getTime();

            if (now > endTime) {
              // Activity ended, disable button and show expired
              clearInterval(timer);
              startBtn.innerHTML = 'Expired';
              startBtn.classList.add('disabled');
              return;
            }

            if (now >= startTime) {
              // Within active time, enable start button
              clearInterval(timer);
              startBtn.innerHTML = 'Start';
              startBtn.classList.remove('disabled');
              return;
            }

            // Before start time, show countdown
            const distance = startTime - now;
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            startBtn.innerHTML = `Starts in: ${days}d ${hours}h ${minutes}m ${seconds}s`;
            startBtn.classList.add('disabled');
          }, 1000);
        });
      </script>
    @endforeach
  </div>
@endsection

@section('script')
@endsection
