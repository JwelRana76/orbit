<x-admin title="Admission Patient Edit">
    {{-- <x-page-header head="Doctor" /> --}}
    <x-card header="Admission Patient Edit" links="{{ route('admission.patient.index') }}" title="Patient List">
        <x-form method="post" action="{{ route('admission.patient.update',$patient->id) }}">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <h5 class="col-md-12">Patient Details</h5>
                        <x-input id="name" value="{{$patient->name}}" class="col-md-3" required />
                        <x-input id="age" value="{{$patient->age}}" class="col-md-3" required />
                        <x-input id="contact" value="{{$patient->contact}}" class="col-md-3" required />
                        <div class="mb-3 col-md-3">
                            <label for="">Father / Husband</label>
                            <input type="text" value="{{$patient->guardian}}" class="form-control" id="guardian" name="guardian" >
                        </div>
                        <x-input id="present_address" value="{{$patient->present_address}}" class="col-md-3" required />
                        <div class="mb-3 col-md-3">
                            <label for="">
                                <input type="checkbox" class="btn-check mr-3" name="permanent_same" id="btncheck1" autocomplete="off">
                                Permanent Address</label>
                            <input type="text" value="{{$patient->permanent_address}}" class="form-control" id="permanent_address" name="permanent_address" >
                        </div>
                        <x-input id="relative" value="{{$patient->relative}}" class="col-md-3"  />
                        <div class="mb-3 col-md-3">
                            <label for="">
                                <input type="checkbox" class="btn-check mr-3" name="relative_same" id="btncheck1" autocomplete="off">
                                Relative Address</label>
                            <input type="text" class="form-control" value="{{$patient->relative_address}}" id="relative_address" name="relative_address" >
                        </div>
                        <div class="col-md-3">
                            <x-select id="gender" selectedId="{{$patient->gender_id}}" name="gender_id" :options="$gender" required />
                        </div>
                        <div class="col-md-3">
                            <label for="bed_type">Bed Type</label>
                            <select name="bed_type" id="bed_type" class="form-control selectpicker" data-live-search="true" title="Select Bed Type">
                                <option value="1" {{$patient->bed_type == true ? 'selected':''}}>Ward</option>
                                <option value="0" {{$patient->bed_type == false ? 'selected':''}}>Cabin</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <x-select id="bed" selectedId="{{$patient->bed_id}}" name="bed" :options="$beds" class="col-md-4" />
                        </div>
                        <h5 class="col-md-12 mt-3">Operation Details</h5>
                        <div class="col-md-3">
                            <x-select id="surgone" selectedId="{{$patient->doctor_id}}" name="doctor_id" required :options="$doctors" class="col-md-4" />
                        </div>
                        <div class="col-md-3">
                            <x-select id="operation" name="bed" selectedId="{{$patient->operation_id}}" :options="$operation" class="col-md-4" />
                        </div>
                        <div class="col-md-3">
                            <x-select id="lens" selectedId="{{$patient->lens_id}}" :options="$lens" />
                        </div>
                        <h5 class="col-md-12 mt-3">Amount Section</h5>
                        <x-input id="admission_fee" value="{{$patient->admission_fee}}" class="col-md-3" />
                        <div class="mb-3 col-md-3">
                            <label for="">Ward / Cabin Fee</label>
                            <input type="text" class="form-control" value="{{$patient->bed_fee}}" id="ward_cabin" name="ward_cabin" >
                        </div>
                    </div>
                    <x-button value="Save" />
                </div>
            </div>
        </x-form>
    </x-card>

    @push('js')
        <script>
          
            $(document).ready(function() {
                
                var beds = @json($beds);
                

                $(document).on('change', '#bed_type', function () {

                    let type = $(this).val();
                    let bed = $('#bed');

                    bed.empty();

                    $.each(beds, function (index, item) {

                        if (item.type == type) {
                            bed.append(
                                `<option value="${item.id}">${item.name}</option>`
                            );
                        }

                    });

                    bed.selectpicker('refresh');
                });
                
            });

            
        </script>
    @endpush
</x-admin>