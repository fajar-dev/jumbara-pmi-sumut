@extends('layouts.app')
@section('style')

@endsection

@section('content')
<div class="row">
  <div class="col-lg-4 col-12">
    <div class="mb-10 p-0">
      <div class="card min-h-100">
        <div id="pdfViewer" style="border:1px solid #ccc; overflow:auto;">
          <canvas id="pdf-canvas" style="width: 100%; height: 100%;"></canvas>
        </div>
        <div class="p-5">
          <button id="download-pdf" class="btn btn-danger w-100 mb-3">Download ID Card</button>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-8 col-12">
    <div class="card card-flush">
      <div class="card-header pt-5">
        <div class="card-title">
          <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold fs-3">My Activity</span>
          </h3>
        </div>
      </div>
      <div class="card-body">
          <div class="table-responsive">
            <table class="table table-row-dashed fs-6 gy-5">
              <thead>
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                  <th class="min-w-200px">Activity</th>
                  <th class="min-w-100px text-center">Attendance</th>
                  <th class="text-end min-w-150px"></th>
                </tr>
              </thead>
              <tbody>
                @forelse ($activity as $item)
                    <tr>
                      <td>
                        <div class="text-start">
                          <div class="d-flex flex-column">
                            <span class="fs-6 fw-bold">{{ $item->activity->name }}</span>
                            <span class="fs-7 text-gray-600">
                              {{ \Carbon\Carbon::parse($item->activity->start)->format('F d, Y h.iA') }}
                              –
                              {{ \Carbon\Carbon::parse($item->activity->end)->format('F d, Y h.iA') }}
                            </span>
                          </div>
                        </div>
                      </td>
                      <td class="text-center">
                        @if ($item->activityAttendance)
                          <span class="badge badge-primary">
                            {{ \Carbon\Carbon::parse($item->activityAttendance->created_at)->format('F d, Y h.iA') }}
                          </span>
                        @else
                          -
                        @endif
                      </td>
                      <td class="text-end">
                        @if ($item->activityAttendance)
                          <button class="btn btn-light-danger btn-sm">
                            <i class="ki-outline ki-document"></i>
                            Certificate
                          </button>
                        @endif
                      </td>
                    </tr>
                @empty
                  <tr class="max-w-10px">
                    <td colspan="4" class="text-center">
                      No data available in table
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
      </div>
    </div>
  </div>
</div>


@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
<script>
  document.getElementById('download-pdf').addEventListener('click', function() {
    const pdfUrl = "{{ route('id-card', Auth::user()->member_id) }}";
    
    // Create a temporary link and trigger download
    const link = document.createElement('a');
    link.href = pdfUrl;
    link.download = 'id-card.pdf'; // nama file saat di download
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  });
</script>

<script>
  const url = "{{ route('id-card', Auth::user()->member_id) }}";

  // PDF.js setup
  pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';

  let pdfDoc = null,
      pageNum = 1,
      canvas = document.getElementById('pdf-canvas'),
      ctx = canvas.getContext('2d');

  function renderPage(num) {
    pdfDoc.getPage(num).then(function(page) {
      const viewport = page.getViewport({ scale: 1.5 });
      canvas.height = viewport.height;
      canvas.width = viewport.width;

      const renderContext = {
        canvasContext: ctx,
        viewport: viewport
      };
      page.render(renderContext);
    });
  }

  pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
    pdfDoc = pdfDoc_;
    renderPage(pageNum);
  }).catch(function(error){
    console.error('Error loading PDF:', error);
  });
</script>

@endsection
