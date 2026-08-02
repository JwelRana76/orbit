<x-admin title="Glass">
    <x-page-header head="Glass" />
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3">
                <x-form method="post" action="{{ route('glass.store') }}">
                    <x-input id="id" type="hidden" value="{{ $item->id ?? null }}" />
                    <x-input id="name" value="{{ $item->name ?? old('name') }}" />
                    <x-input id="company" value="{{ $item->company ?? old('company') }}" />
                    <x-input id="cost" value="{{ $item->cost ?? old('cost') }}" />
                    <x-input id="price" value="{{ $item->price ?? old('price') }}" />
                    <x-button value="Save" />
                </x-form>
            </div>
        </div>
        <div class="col-md-9">
            <x-data-table dataUrl="pharmacy/glass" id="glasses" :columns="$columns" />
        </div>
    </div>
</x-admin>