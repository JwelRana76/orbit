<x-admin title="Blood Group">
    <x-page-header head="Blood Group" />
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3">
                <x-form method="post" action="{{ route('blood_group.store') }}">
                    <x-input id="id" type="hidden" value="{{ $blood_group->id ?? null }}" />
                    <x-input id="name" value="{{ $blood_group->name ?? old('code') }}" />
                    <x-button value="Save" />
                </x-form>
            </div>
        </div>
        <div class="col-md-9">
            <x-data-table dataUrl="/acamedic/blood_group" id="blood_groups" :columns="$columns" />
        </div>
    </div>
</x-admin>