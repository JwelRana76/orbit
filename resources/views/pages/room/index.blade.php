<x-admin title="Room">
    <x-page-header head="Room" />
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3">
                <x-form method="post" action="{{ route('room.store') }}">
                    <x-input id="id" type="hidden" value="{{ $room->id ?? null }}" />
                    <x-input id="name" value="{{ $room->name ?? null }}" />
                    <x-button value="Save" />
                </x-form>
            </div>
        </div>
        <div class="col-md-9">
            <x-data-table dataUrl="/acamedic/room" id="rooms" :columns="$columns" />
        </div>
    </div>
    @push('js')
        <script>
             
        </script>
    @endpush
</x-admin>