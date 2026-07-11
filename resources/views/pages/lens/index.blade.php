<x-admin title="Lens">
    <x-page-header head="Lens" />
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3">
                <x-form method="post" action="{{ route('lens.store') }}">
                    <x-input id="id" type="hidden" value="{{ $bed->id ?? null }}" />
                    <x-input id="name" value="{{ $bed->name ?? old('name') }}" />
                    <x-input id="constant" value="{{ $bed->constant ?? old('constant') }}" />
                    <x-input id="cost" value="{{ $bed->cost ?? old('constant') }}" />
                    <x-input id="price" value="{{ $bed->price ?? old('price') }}" />
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="is_hospital_provided"
                            id="is_hospital_provided"
                            value="1"
                            {{ old('is_hospital_provided', isset($bed) ? $bed->is_hospital_provider : 0) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="is_hospital_provided">
                            Is Hospital Provided
                        </label>
                    </div>
                    <x-button value="Save" />
                </x-form>
            </div>
        </div>
        <div class="col-md-9">
            <x-data-table dataUrl="/lens/index" id="lenses" :columns="$columns" />
        </div>
    </div>
</x-admin>