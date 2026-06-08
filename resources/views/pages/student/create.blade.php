<x-admin title="Creat Student">
    <x-page-header head="Creat Student" />
    <div class="row">
        <div class="col-md-12">
            <div class="card p-3" style="color: white; background: #0f042e">
              <h5>Student Information</h5>
              <p class="mb-5">All * mark field must be filled</p>
                <x-form method="post" action="{{ route('student.store') }}">
                  <div class="row">
                    <div class="col-md-3 mb-3">
                      <x-input id="roll" value="{{ old('roll') }}" required />
                    </div>
                    <div class="col-md-3 mb-3">
                      <x-input id="name" value="{{ old('name') }}" required />
                    </div>
                    <div class="col-md-3 mb-3">
                      <x-input id="phone_number" value="{{ old('phone_number') }}" />
                    </div>
                    <div class="col-md-3 mb-3">
                      <x-input id="date_of_birth" type="date" value="{{ old('date_of_birth') }}" required />
                    </div>
                    <div class="col-md-3 mb-3">
                      <x-select id="classes" name="classes" :options="$classes" required />
                    </div>
                    <div class="col-md-3 mb-3">
                      <x-select id="session" name="session" :options="$session" required />
                    </div>
                    <div class="col-md-3 mb-3">
                      <x-select id="religion" name="religion" :options="$religion" required />
                    </div>
                    <div class="col-md-3 mb-3">
                      <x-select id="gender" name="gender" :options="$gender" required />
                    </div>
                    <div class="col-md-3 mb-3">
                      <x-select id="blood_group" name="blood_group" :options="$blood_group" />
                    </div>
                    <div class="col-md-3 mb-3">
                      <x-input id="birth_certificate_number" value="{{ old('birth_certificate_number') }}" />
                    </div>
                    <div class="col-md-3 mb-3">
                      <x-input id="father_name" value="{{ old('father_name') }}" />
                    </div>
                    <div class="col-md-3 mb-3">
                      <x-input id="mother_name" value="{{ old('mother_name') }}" />
                    </div>
                    <div class="col-md-3 mb-3">
                      <x-input id="father_phone" value="{{ old('father_phone') }}" />
                    </div>
                    <div class="col-md-3 mb-3">
                      <x-input id="picture" type="file" value="{{ old('picture') }}" />
                    </div>
                    <div class="col-md-12 mb-3">
                      <hr>
                    </div>
                    <div class="col-md-6 mb-3">
                      <x-textarea id="present_address" value="{{ old('present_address') }}" required />
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="" style="margin-bottom: 0px">Parmanent Address 
                        <input type="checkbox" class="ml-5" name="same_address" id="same_address" >
                        <label for="">Same Address</label>
                      </label>
                      <textarea name="parmanent_address" id="parmanent_address"class="form-control" cols="10" rows="2"></textarea>
                    </div>
                  </div>
                  <x-button value="Save" />
                </x-form>
            </div>
        </div>
    </div>
    @push('js')
        <script>
          $("#same_address").on("change", function () {
            if ($(this).is(":checked")) {
                $("#parmanent_address").prop("disabled", true);
            } else {
                $("#parmanent_address").prop("disabled", false);
            }
          });
        </script>
    @endpush
</x-admin>