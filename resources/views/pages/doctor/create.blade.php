<x-admin title="Create Doctor">
    {{-- <x-page-header head="Create Dcotor" /> --}}
    <x-card header="Create Doctor" link="{{ route('doctor.index') }}" title="Doctor List">
      <x-form action="{{ route('doctor.store') }}" method="post">
        <div class="row">
          <x-input id="name" required class="col-md-6 col-xl-6 col-sm-12" />
          <x-input id="designation" required class="col-md-6 col-xl-6 col-sm-12" />
          <x-input id="institute" required class="col-md-6 col-xl-6 col-sm-12" />
          <x-input id="degree" required class="col-md-6 col-xl-6 col-sm-12" />
          <x-input id="contact" required class="col-md-6 col-xl-6 col-sm-12" />
          <x-input id="email" class="col-md-6 col-xl-6 col-sm-12" />
          <div class="col-md-4 col-sm-12">
            <x-select id="gender" label="Gender" name="gender_id" :options="$gender" />
          </div>
          <div class="col-md-4 col-sm-12">
            <x-select id="religion" :options="$religion" required class="col-md-6 col-xl-6 col-sm-12" />
          </div>
          <div class="col-md-4 col-sm-12">
            <x-select id="blood_group" :options="$blood_group" required class="col-md-6 col-xl-6 col-sm-12" />
          </div>
          <x-input type="file" id="photo" class="col-md-6 col-xl-6 col-sm-12" />
          <x-input type="file" id="signature" class="col-md-6 col-xl-6 col-sm-12" />
        </div>
        <x-button type="submit" />
      </x-form>
    </x-card> 
    


</x-admin>