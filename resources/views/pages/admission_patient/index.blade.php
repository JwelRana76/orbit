<x-admin title="Pathology Patient">
    <x-page-header head="Pathology Patient" />
    <a href="{{ route('pathology.patient.create') }}" class="btn btn-sm btn-primary my-2">
      <i class="fas fa-fw fa-plus"></i> Add Patient
    </a>
    <div class="row">
      <x-data-table dataUrl="/pathology/patient" id="pathology_patients" :columns="$columns" />
    </div>

</x-admin>