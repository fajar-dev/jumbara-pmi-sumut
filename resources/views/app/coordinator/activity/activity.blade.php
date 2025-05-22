@extends('layouts.app')

@section('content')
  <div class="row g-5 g-xl-10">
    <div class="col-xl-12 mb-8">
      <div class="card card-flush">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
          <div class="card-title">
            <h3 class="card-title align-items-start flex-column">
              <span class="card-label fw-bold fs-3 mb-1">Activity</span>
              <span class="text-muted fw-semibold fs-7">{{ $coordinator->contingent->name }}</span>
            </h3>
          </div>
        </div>
        <div class="card-body pt-0">

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