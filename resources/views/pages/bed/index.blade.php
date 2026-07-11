<x-admin title="Bed">
    <x-page-header head="Bed" />
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3">
                <x-form method="post" action="{{ route('bed.store') }}">
                    <x-input id="id" type="hidden" value="{{ $bed->id ?? null }}" />
                    <x-input id="name" value="{{ $bed->name ?? old('name') }}" />
                    <div class="">
                        <label for="bed_type">Bed Type</label>
                        <select name="type" id="bed_type" class="form-control selectpicker" data-live-search="true" title="Select Bed Type">
                            <option value="1" {{ isset($bed) && $bed->type == 1 ? 'selected' : '' }}>Ward</option>
                            <option value="0" {{ isset($bed) && $bed->type == 0 ? 'selected' : '' }}>Cabin</option>
                        </select>
                    </div>
                    <x-button value="Save" />
                </x-form>
            </div>
        </div>
        <div class="col-md-9">
            <x-data-table dataUrl="/acamedic/bed" id="beds" :columns="$columns" />
        </div>
    </div>
</x-admin>