<x-admin title="Admission Patient">
    <x-page-header head="Admission Patient" />
    <a href="{{ route('admission.patient.create') }}" class="btn btn-sm btn-primary my-2">
      <i class="fas fa-fw fa-plus"></i> Add Patient
    </a>
    <div class="row">
      <x-data-table dataUrl="/admission/patient" id="admission_patients" :columns="$columns" />
    </div>


<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <x-form method="post" action="{{ route('admission.patient.payment') }}">
            <input type="hidden" name="patient_id" id="patient_id">
            <div class="mb-3" id="admission_section">
                <label for="">Admission Fee</label>
                <input type="text" class="form-control" id="admission_fee" name="admission_fee" >
            </div>
            <div class="mb-3" id="bed_section">
                <label for="">Bed Fee</label>
                <input type="text" class="form-control" id="bed_fee" name="bed_fee" >
            </div>
            <div class="mb-3" id="ot_section">
                <label for="">OT Fee</label>
                <input type="text" class="form-control" id="ot_fee" name="ot_fee" >
            </div>
            <div class="mb-3" id="lens_section">
                <label for="">Lens Fee</label>
                <input type="text" class="form-control" id="lens_fee" name="lens_fee" >
            </div>
            <div class="mb-3">
                <label for="payment_status">Bed Type</label>
                <select name="payment_status" id="payment_status" class="form-control selectpicker" data-live-search="true" title="Select Bed Type">
                    <option value="1">Paid</option>
                    <option value="0">Due</option>
                </select>
            </div>
            <x-button value="Submit" />
        </x-form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <x-form method="post" action="{{ route('admission.patient.cancel') }}">
            <input type="hidden" name="patient_id" id="patient_id">
            <div class="mb-3" id="admission_section">
                <label for="">Admission Fee</label>
                <input type="text" class="form-control" id="admission_fee" name="admission_fee" >
            </div>
            <div class="mb-3" id="bed_section">
                <label for="">Bed Fee</label>
                <input type="text" class="form-control" id="bed_fee" name="bed_fee" >
            </div>
            <div class="mb-3" id="ot_section">
                <label for="">OT Fee</label>
                <input type="text" class="form-control" id="ot_fee" name="ot_fee" >
            </div>
            <div class="mb-3" id="lens_section">
                <label for="">Lens Fee</label>
                <input type="text" class="form-control" id="lens_fee" name="lens_fee" >
            </div>
            <x-button value="Submit" />
        </x-form>
      </div>
    </div>
  </div>
</div>
@push('js')
    <script>
        $(document).ready(function() {
            $('#paymentModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                $('#patient_id').val(id);
                $.get("/admission/patient/find_patient/" + id, function (data) {
                  if (data.admission_fee != null) {
                      $('#admission_section').hide();
                  }
                  if (data.bed_fee != null) {
                      $('#bed_section').hide();
                  }
                  if (data.ot_fee != null) {
                      $('#ot_section').hide();
                  }
                  if (data.lens_fee != null) {
                      $('#lens_section').hide();
                  }
                });
            });
            $('#cancelModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                $('#cancelModal #patient_id').val(id);
                $.get("/admission/patient/find_patient/" + id, function (data) {
                    console.log(data);
                    
                  $('#cancelModal #admission_fee').val(data.admission_fee);
                  $('#cancelModal #bed_fee').val(data.bed_fee);
                  $('#cancelModal #ot_fee').val(data.ot_fee);
                  $('#cancelModal #lens_fee').val(data.lens_fee);
                });
            });
        });
    </script>  
@endpush
</x-admin>