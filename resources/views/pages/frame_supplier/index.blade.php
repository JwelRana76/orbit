<x-admin title="Frame Supplier">
    <x-page-header head="Frame Supplier" />
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3">
                <x-form method="post" action="{{ route('frame.supplier.store') }}">
                    <x-input id="id" type="hidden" value="{{ $data->id ?? null }}" />
                    <x-input id="name" value="{{ $data->name ?? old('name') }}" />
                    <x-input id="contact" value="{{ $data->contact ?? old('contact') }}" />
                    <x-textarea  id="address" value="{{ $data->address ?? old('address') }}"/>
                    <x-button value="Save" />
                </x-form>
            </div>
        </div>
        <div class="col-md-9">
            <x-data-table dataUrl="pharmacy/frame/supplier" id="framesuppliers" :columns="$columns" />
        </div>
    </div>

    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h3>Payment Details</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form method="post" action="{{ route('frame.supplier.payment') }}">
                    <input type="hidden" name="supplier_id" id="supplier_id">
                    <input type="hidden" name="due" id="due">
                    <x-input id="amount" />
                    <x-button value="Submit" />
                </x-form>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="paymentDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Payment Details</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="paymentDetailsBody">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
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

                    $('#supplier_id').val(id);
                    $('#due').val(due);
                });

                $('#paymentModal #amount').on('input',function(){
                    var max_due = parseFloat($('#due').val());
                    var amount = parseFloat($(this).val());
                    if(amount > max_due){
                        alert('You can not Pay more than due amount');
                        $(this).val(max_due);
                    }
                });

                $('#paymentDetails').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var id = button.data('id');

                    $.get("/pharmacy/frame/supplier/payment/details/" + id, function (data) {

                        let tbody = $('#paymentDetailsBody tbody');
                        tbody.html(''); // Clear previous rows
                        
                        $.each(data, function(index, item) {
                            tbody.append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.created_at.split('T')[0]}</td>
                                    <td>${item.amount}</td>
                                    <td>
                                        <a onclick="return confirm('Are you sure to Delete this record..??')" href="{{ url('pharmacy/frame/purchase/paymentdelete') }}/${item.id}">
                                            <i class="fas fa-fw fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            `);
                        });
                    });
                });
            });
        </script>  
    @endpush
</x-admin>