<x-admin title="Medicine">
    <x-page-header head="Medicine" />
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3">
                <x-form method="post" action="{{ route('medicine.store') }}">
                    <x-input id="id" type="hidden" value="{{ $medicine->id ?? null }}" />
                    <x-input id="name" value="{{ $medicine->name ?? old('name') }}" />
                    <x-input id="type" value="{{ $medicine->type ?? old('type') }}" />
                    <x-input id="group" value="{{ $medicine->group ?? old('group') }}" />
                    <x-input id="company" value="{{ $medicine->company ?? old('company') }}" />
                    <x-input id="cost" value="{{ $medicine->cost ?? old('company') }}" />
                    <x-input id="price" value="{{ $medicine->price ?? old('price') }}" />
                    
                    <x-button value="Save" />
                </x-form>
            </div>
        </div>
        <div class="col-md-9">
            <x-data-table dataUrl="pharmacy/medicine" id="medicines" :columns="$columns" />
        </div>
    </div>
</x-admin>