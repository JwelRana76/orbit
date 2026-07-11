<x-admin title="Lens Supplier">
    <x-page-header head="Lens Supplier" />
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3">
                <x-form method="post" action="{{ route('lens.supplier.store') }}">
                    <x-input id="id" type="hidden" value="{{ $data->id ?? null }}" />
                    <x-input id="name" value="{{ $data->name ?? old('name') }}" />
                    <x-input id="contact" value="{{ $data->contact ?? old('contact') }}" />
                    <x-textarea  id="address" value="{{ $data->address ?? old('address') }}"/>
                    <x-button value="Save" />
                </x-form>
            </div>
        </div>
        <div class="col-md-9">
            <x-data-table dataUrl="/lens/supplier" id="lenssuppliers" :columns="$columns" />
        </div>
    </div>
</x-admin>