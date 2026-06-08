<x-admin title="Religion">
    <x-page-header head="Religion" />
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3">
                <x-form method="post" action="{{ route('religion.store') }}">
                    <x-input id="id" type="hidden" value="{{ $religion->id ?? null }}" />
                    <x-input id="name" value="{{ $religion->name ?? old('code') }}" />
                    <x-button value="Save" />
                </x-form>
            </div>
        </div>
        <div class="col-md-9">
            <x-data-table dataUrl="/acamedic/religion" id="religions" :columns="$columns" />
        </div>
    </div>
</x-admin>