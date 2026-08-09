<x-admin title="Referal">
    <x-page-header head="Referal" />
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3">
                <x-form method="post" action="{{ route('referal.store') }}">
                    <x-input id="id" type="hidden" value="{{ $referal->id ?? null }}" />
                    <x-input id="name" value="{{ $referal->name ?? old('name') }}" />
                    <x-input id="contact" value="{{ $referal->contact ?? old('contact') }}" />
                    <x-input id="address" value="{{ $referal->address ?? old('contact') }}" />
                    <x-button value="Save" />
                </x-form>
            </div>
        </div>
        <div class="col-md-9">
            <x-data-table dataUrl="/setting/referal" id="referals" :columns="$columns" />
        </div>
    </div>
</x-admin>