<x-admin title="Department">
    <x-page-header head="Department" />
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3">
                <x-form method="post" action="{{ route('department.store') }}">
                    <x-input id="id" type="hidden" value="{{ $department->id ?? null }}" />
                    <x-input id="name" value="{{ $department->name ?? old('name') }}" />
                    <x-button value="Save" />
                </x-form>
            </div>
        </div>
        <div class="col-md-9">
            <x-data-table dataUrl="/acamedic/department" id="departments" :columns="$columns" />
        </div>
    </div>
</x-admin>