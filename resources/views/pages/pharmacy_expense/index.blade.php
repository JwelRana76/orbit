<x-admin title="Pharmacy Expense">
    <x-page-header head="Pharmacy Expense" />
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3">
                <x-form method="post" action="{{ route('pharmacy.expense.store') }}">
                    <x-input id="id" type="hidden" value="{{ $expense->id ?? null }}" />
                    <x-input id="date" type="date" value="{{ old('date', isset($expense) ? $expense->created_at->format('Y-m-d') : '') }}" />
                    <x-input id="purposes" value="{{ $expense->purposes ?? old('purposes') }}" />
                    <x-input id="amount" value="{{ $expense->amount ?? old('amount') }}" />
                    <x-input id="note" value="{{ $expense->note ?? old('note') }}" />
                    <x-button value="Save" />
                </x-form>
            </div>
        </div>
        <div class="col-md-9">
            <x-data-table dataUrl="expense" id="expenses" :columns="$columns" />
        </div>
    </div>
</x-admin>