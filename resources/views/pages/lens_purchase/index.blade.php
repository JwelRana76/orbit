<x-admin title="Lens Purchase">
    <x-page-header head="Lens Purchase" />
    <div class="row">
      
        <div class="col-md-12">
            <x-data-table dataUrl="/lens/purchase" id="lens_purchases" :columns="$columns" />
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
        <x-form method="post" action="{{ route('lens.purchase.payment') }}">
            <input type="hidden" name="purchase_id" id="purchase_id">
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

                $('#purchase_id').val(id);
            });
        });
    </script>  
@endpush
</x-admin>
