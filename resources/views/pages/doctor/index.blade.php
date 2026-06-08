<x-admin title="Doctors List">
    <x-page-header head="Dcotors List" />
    <a href="{{ route('doctor.create') }}" class="btn btn-sm btn-primary my-2">
        <i class="fas fa-fw fa-plus"></i> Add Doctor
    </a>
    <x-data-table dataUrl="/doctor" id="doctors" :columns="$columns" />


</x-admin>