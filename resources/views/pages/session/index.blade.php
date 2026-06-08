<x-admin title="Session">
    <x-page-header head="Session" />
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3">
                <x-form method="post" action="{{ route('session.store') }}">
                    <x-input id="id" type="hidden" value="{{ $session->id ?? null }}" />
                    <x-input id="name" value="{{ $session->name ?? null }}" />
                    <x-button value="Save" />
                </x-form>
            </div>
        </div>
        <div class="col-md-9">
            <x-data-table dataUrl="/acamedic/session" id="sessions" :columns="$columns" />
        </div>
    </div>
    @push('js')
        <script>
             
        </script>
    @endpush
</x-admin>