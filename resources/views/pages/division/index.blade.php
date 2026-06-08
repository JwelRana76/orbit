<x-admin title="Division">
    <x-page-header head="Division" />
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3">
                <x-form method="post" action="{{ route('division.store') }}">
                    <x-input id="id" type="hidden" value="{{ $division->id ?? null }}" />
                    <x-input id="name" value="{{ $division->name ?? old('code') }}" />
                    <label for="code">Code</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="code" id="code" value="{{ $division->code ?? old('code') }}" >
                        <div class="input-group-append">
                            <input type="button" class="input-group-text" id="generate_code" value="Gen" >
                        </div>
                    </div>
                    <x-button value="Save" />
                </x-form>
            </div>
        </div>
        <div class="col-md-9">
            <x-data-table dataUrl="/acamedic/division" id="divisions" :columns="$columns" />
        </div>
    </div>
    @push('js')
        <script>
             $('#generate_code').on('click', function () {
                var min = 100;
                var max = 9999;
                var randomCode = Math.floor(Math.random() * (max - min + 1)) + min;
                $('input[name="code"]').val(randomCode);
            });
        </script>
    @endpush
</x-admin>