<x-admin title="Operation">
    <x-page-header head="Operation" />
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3">
                <x-form method="post" action="{{ route('ot.store') }}">
                    <x-input id="id" type="hidden" value="{{ $item->id ?? null }}" />
                    <x-input id="name" value="{{ $item->name ?? old('name') }}" />
                    <x-input id="charge" value="{{ $item->charge ?? old('charge') }}" />
                    <x-button value="Save" />
                </x-form>
            </div>
        </div>
        <div class="col-md-9">
            <x-data-table dataUrl="/acamedic/operation" id="operations" :columns="$columns" />
        </div>
    </div>
</x-admin>