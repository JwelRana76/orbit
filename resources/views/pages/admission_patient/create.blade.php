<x-admin title="Admission Patient Create">
    {{-- <x-page-header head="Doctor" /> --}}
    <x-card header="Admission Patient Create" links="{{ route('admission.patient.index') }}" title="Patient List">
        <form id="patient_insert_form">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <x-input id="name" class="col-md-3" required />
                        <x-input id="age" class="col-md-3" required />
                        <x-input id="contact" class="col-md-3" required />
                        <div class="col-md-3">
                            <x-select id="gender" name="gender_id" :options="$gender" required />
                        </div>
                        <div class="col-md-3">
                            <x-select id="surgone" name="doctor_id" required :options="$doctors" class="col-md-4" />
                        </div>
                        <x-input id="admission_fee" class="col-md-3" required />
                        <div class="col-md-3">
                            <label for="ot_type">Operation *</label>
                            <select name="ot_type" required id="ot_type" class="form-control selectpicker" data-live-search="true" title="Select OT Type">
                                <option value="sics">Cataract SICS</option>
                                <option value="phaco">Cataract Phaco</option>
                                <option value="chalazion">Chalazion</option>
                                <option value="dcr">DCR</option>
                                <option value="dct">DCT</option>
                                <option value="pterygium">Pterygium</option>
                                <option value="abscess_drain ">Abscess Drain </option>
                                <option value="evisceration ">Evisceration</option>
                                <option value=" yag_laser ">Yag Laser</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="bed_type">Bed Type</label>
                            <select name="bed_type" id="bed_type" class="form-control selectpicker" data-live-search="true" title="Select Bed Type">
                                <option value="1">Ward</option>
                                <option value="0">Cabin</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <x-select id="bed" name="bed" :options="$beds" class="col-md-4" />
                        </div>
                    </div>
                </div>
            </div>
            
        </form>
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