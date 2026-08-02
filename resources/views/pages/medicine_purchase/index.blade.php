<x-admin title="Medicine Purchase">
    <x-page-header head="Medicine Purchase" />
    <div class="row">
      <a href="{{route('medicine.purchase.create')}}" class="btn btn-primary ml-3 mb-3"><i class="fas fa-fw fa-plus mr-2"></i>Create</a>
        <div class="col-md-12">
            <x-data-table dataUrl="pharmacy/medicine/purchase" id="medicine_purchases" :columns="$columns" />
        </div>
    </div>

<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <x-form method="post" action="{{ route('medicine.purchase.payment') }}">
            <input type="hidden" name="purchase_id" id="purchase_id">
            <input type="hidden" name="due" id="due">
            <x-input id="amount" />
            <x-button value="Submit" />
        </x-form>
      </div>
    </div>
  </div>
</div>
@push('js')
    <script>
        $(document).ready(function() {
            $('#paymentModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var due = button.data('due');

                $('#purchase_id').val(id);
                $('#due').val(due);
            });

            $('#paymentModal #amount').on('input',function(){
              var max_due = parseFloat($('#due').val());
              var amount = parseFloat($(this).val());
              if(amount > max_due){
                alert('You can not Pay more than due amount');
                $(this).val(max_due);
              }
            })
        });
    </script>  
@endpush
</x-admin>
