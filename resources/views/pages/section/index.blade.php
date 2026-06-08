<x-admin title="Section">
    <x-page-header head="Section" />
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3">
                <x-form method="post" action="{{ route('section.store') }}">
                    <x-input id="id" type="hidden" value="{{ $section->id ?? null }}" />
                    <x-input id="name" value="{{ $section->name ?? null }}" />
                    <x-button value="Save" />
                </x-form>
            </div>
        </div>
        <div class="col-md-9">
            <x-data-table dataUrl="/acamedic/section" id="sections" :columns="$columns" />
        </div>
    </div>
    @push('js')
        <script>
             
        </script>
    @endpush
</x-admin>