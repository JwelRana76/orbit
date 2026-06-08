<x-admin title="Upazila">
    <x-page-header head="Upazila" />
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3">
                <x-form method="post" action="{{ route('upazila.store') }}">
                    <x-input id="id" type="hidden" value="{{ $upazila->id ?? null }}" />
                    <x-select id="district_id" label="District" selectedId="{{ $upazila->district_id ?? null }}" name="district_id" :options="$district" has-modal modal-open-id="district" />
                    <x-input id="name" value="{{ $upazila->name ?? old('name') }}" />
                    <label for="code">Code</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="code" id="code" value="{{ $upazila->code ?? old('code') }}" >
                        <span style="cursor: pointer; border-radius: 0;" class="input-group-text" id="generate_code">
                            <i class="fa fa-barcode"></i>
                        </span>
                    </div>
                    <x-button value="Save" />
                </x-form>
            </div>
        </div>
        <div class="col-md-9">
            <x-data-table dataUrl="/acamedic/upazila" id="upazilas" :columns="$columns" />
        </div>
    </div>
    <x-modal id="district">
        <form id="divisionForm">
            @csrf
            <x-select id="division_id" label="Division" name="division_id" :options="$divisions" />
            <x-input id="distirct_name" label="name" />
            <label for="code">Code</label>
            <div class="input-group flex-nowrap">
                <input type="text" required name="code" id="distirct_code"
                    class="form-control" placeholder="Category Code">
                <span style="cursor: pointer; border-radius: 0;" class="input-group-text" id="district_code_gen">
                    <i class="fa fa-barcode"></i>
                </span>
            </div>
            <x-button value="Save" />
        </form>
    </x-modal>
    @push('js')
        <script>
        $(document).ready(function() {
            $('#district_code_gen').on('click', function() {
                const inputEl = $(this).prev();
                const random = (Math.random() + 1).toString(10).substring(14);
                inputEl.val(random);
            });
            $('#generate_code').on('click', function() {
                const inputEl = $(this).prev();
                const random = (Math.random() + 1).toString(10).substring(14);
                inputEl.val(random);
            });

            $(document).ready(function() {
                // Add an event listener to the form's submit event
                $('#divisionForm').on('submit', function(e) {
                    e.preventDefault(); // Prevent the default form submission

                    // Collect the form data
                    var formData = {
                    _token: $('input[name="_token"]').val(),
                    id: null,
                    name: $('#distirct_name').val(),
                    code: $('#distirct_code').val(),
                    division_id: $('#division_id').val()
                    };

                    // Use AJAX to send the data to the server
                    $.ajax({
                    type: 'POST',
                    url: '{{ route("district.districtstore") }}',
                    data: formData,
                    success: function(response) {
                        // Handle the success response here
                        console.log(response);
                        $('#district').modal('hide');
                        updatedistrictSelect(response);

                        var lastdistrictId = response[response.length - 1].id;
                        var selectElement = $('#district_id'); // Use the correct selector
                        console.log(lastdistrictId);
                        selectElement.selectpicker('val', lastdistrictId);
                    },
                    error: function(error) {
                        // Handle any errors here
                        console.error(error);
                    }
                    });
                });
                
            });
            function updatedistrictSelect(categories) {
                // Assuming "categories" is an array of objects with "id" and "name" fields
                var $categorySelect = $('#district_id');
                $categorySelect.empty(); // Clear the current options

                // Add the new options
                categories.forEach(function(category) {
                    $categorySelect.append(
                        $('<option>', {
                            value: category.id,
                            text: category.name
                        })
                    );
                });

                // Update the selectpicker
                $categorySelect.selectpicker('refresh');
            }
        
        });
        </script>
    @endpush
</x-admin>