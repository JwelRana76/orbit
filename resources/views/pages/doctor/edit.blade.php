<x-admin title="Edit Doctor">
    <x-page-header head="Edit Dcotor" />
    <x-card header="Create Doctor" link="{{ route('doctor.index') }}" title="Doctor List">
      <x-form action="{{ route('doctor.update',$doctor->id) }}" method="post">
        <div class="row">
          <x-input id="name" value="{{ $doctor->name }}" required class="col-md-6 col-xl-6 col-sm-12" />
          <x-input id="designation" value="{{ $doctor->designation }}" required class="col-md-6 col-xl-6 col-sm-12" />
          <x-input id="institute" value="{{ $doctor->institute }}" required class="col-md-6 col-xl-6 col-sm-12" />
          <x-input id="degree" value="{{ $doctor->degree }}" required class="col-md-6 col-xl-6 col-sm-12" />
          <x-input id="contact" value="{{ $doctor->contact }}" required class="col-md-6 col-xl-6 col-sm-12" />
          <x-input id="email" value="{{ $doctor->email }}" class="col-md-6 col-xl-6 col-sm-12" />
          <div class="col-md-4 col-sm-12">
            <x-select id="gender" selectedId="{{ $doctor->gender_id }}" :options="$gender" required />
          </div>
          <div class="col-md-4 col-sm-12">
            <x-select id="religion" selectedId="{{ $doctor->religion_id }}" :options="$religion" required />
          </div>
          <div class="col-md-4 col-sm-12">
            <x-select id="blood_group" selectedId="{{ $doctor->blood_group_id }}" :options="$blood_group" required />
          </div>
          <div class="d-flex">
            <x-input type="file" id="photo" class="col-md-6 col-xl-6 col-sm-12" />
            <p><img src="/upload/doctor/{{ $doctor->photo }}" alt="photo" width="50px" height="auto"></p>
          </div>
          <div class="d-flex">
            <x-input type="file" id="signature" class="col-md-6 col-xl-6 col-sm-12" />
            <p><img src="/upload/signature/{{ $doctor->signature }}" alt="signature" width="120px" height="50px"></p>
          </div>
        </div>
        <x-button type="submit" />
      </x-form>
    </x-card> 
    


</x-admin>