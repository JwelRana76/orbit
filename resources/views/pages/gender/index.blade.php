<x-admin title="Gender">
    <x-page-header head="Gender" />
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3">
                <x-form method="post" action="{{ route('gender.store') }}">
                    <x-input id="id" type="hidden" value="{{ $gender->id ?? null }}" />
                    <x-input id="name" value="{{ $gender->name ?? old('code') }}" />
                    <x-button value="Save" />
                </x-form>
            </div>
        </div>
        <div class="col-md-9">
            <x-data-table dataUrl="/acamedic/gender" id="genders" :columns="$columns" />
        </div>
    </div>
</x-admin>