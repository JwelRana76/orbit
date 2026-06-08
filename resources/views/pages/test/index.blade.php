<x-admin title="Test">
    <x-page-header head="Test" />
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3">
                <x-form method="post" action="{{ route('test.store') }}">
                    <x-input id="id" type="hidden" value="{{ $test->id ?? null }}" />
                    <x-input id="name" value="{{ $test->name ?? null }}" />
                    <x-input id="rate" value="{{ $test->rate ?? null }}" />
                    <x-input id="max_discount" value="{{ $test->max_discount ?? null }}" />
                    <x-button value="Save" />
                </x-form>
            </div>
        </div>
        <div class="col-md-9">
            <x-data-table dataUrl="/pathology/test" id="tests" :columns="$columns" />
        </div>
    </div>
    @push('js')
        <script>
             
        </script>
    @endpush
</x-admin>