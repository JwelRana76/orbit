<x-admin title="Group">
    <x-page-header head="Group" />
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3">
                <x-form method="post" action="{{ route('group.store') }}">
                    <x-input id="id" type="hidden" value="{{ $group->id ?? null }}" />
                    <x-input id="name" value="{{ $group->name ?? null }}" />
                    <x-button value="Save" />
                </x-form>
            </div>
        </div>
        <div class="col-md-9">
            <x-data-table dataUrl="/acamedic/group" id="groups" :columns="$columns" />
        </div>
    </div>
    @push('js')
        <script>
             
        </script>
    @endpush
</x-admin>