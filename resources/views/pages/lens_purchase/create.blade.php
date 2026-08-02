<x-admin title="Lens Purchase">
    {{-- <x-page-header head="Doctor" /> --}}
    <x-card header="Lens Purchase" links="{{ route('pathology.patient.index') }}" title="Patient List">
        <x-form  method="post" action="{{ route('lens.purchase.store') }}">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <x-input id="date" type="date" class="col-md-4" required />
                        <x-input id="chalan_no" class="col-md-4" required />
                        <div class="col-md-4">
                            <x-select id="supplier" :options="$supplier" required />
                        </div>
                        <div class="col-md-12">
                            <label for="lens">Select Lens</label>
                            <select name="lens" id="lens" data-live-search="true" title="Select Lens" class="form-control selectpicker">
                                @foreach ($lens as $key=>$item)
                                    <option value="{{$item->id}}">{{$item->name}} [{{$item->power}}]</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3 mb-5">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>SL No.</th>
                                    <th>Name</th>
                                    <th>Unit</th>
                                    <th>Rate</th>
                                    <th>Sub Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="test_table">

                            </tbody>
                        </table>
                    </div>
                    <x-textarea  id="note" value="{{ $data->note ?? old('note') }}"/>
                </div>
                <div class="col-md-4">
                    <x-small-card header="Calculation Part">
                        <x-inline-input id="sub_total" />
                        <input type="hidden" id="max_discount" name="max_discount">
                        <div class="mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend" style="width: 40%">
                                    <div class="input-group-text w-100" id="max_discount" style="cursor: pointer">Discount</div>
                                </div>
                                <input type="text" class="form-control" max="100" id="discount_percent" name="discount_percent" placeholder="%">
                                <input type="text" class="form-control" value="0" id="discount_amount" name="discount_amount"  placeholder="Amount">
                            </div>
                        </div>
                        <x-inline-input id="shipping_cost" value="0" />
                        <x-inline-input id="total_payable" />
                        <div class="mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend" style="width: 40%">
                                    <div class="input-group-text w-100" id="paid_text" style="cursor: pointer">Paid</div>
                                </div>
                                <input type="text" class="form-control" id="paid" name="paid"  placeholder="Paid Amount">
                            </div>
                        </div>
                        <x-inline-input id="due" />
                    </x-small-card>
                    <button type="submit" class="btn btn-sm btn-primary mt-3"><i
                                                        class="fa fa-save"></i>
                                                    Save</button>
                    <a href="{{ route('lens.purchase.create') }}"  class="btn btn-sm btn-success float-right mt-3">Clear form</a>
                </div>
                
            </div>
            
        </x-form>
    </x-card>

    @push('js')
        <script>
          
            $(document).ready(function() {
                
                var rowCount = 1;

                // Use event delegation to handle dynamically added elements
                $(document).on('change', '#lens', function() {
                    var selectedValue = $(this).val();
                    // Check if an item with the same value already exists in the table
                    var existingItem = $(`#test_table tr[data-test-id="${selectedValue}"]`);

                    if (existingItem.length === 0) {
                        $.get("/lens/purchase/find_lens/" + selectedValue, function (data) {
                            $('#test_table').append(`
                                <tr data-test-id="${selectedValue}">
                                    <td>${rowCount}</td>
                                    <td>${data.name} [${data.power}]</td>
                                    <td><input type="number" id="increment_subtotal" name="qty[]" class="form-control quantity" value="1" min="1"></td>
                                    <input type="hidden" name="cost[]" class="cost" value="${data.cost}">
                                    <input type="hidden" name="lens_id[]" class="cost" value="${data.id}">
                                    <td>${data.cost}</td>
                                    <td class="subtotal"></td>
                                    <input type="hidden" name="subtotal" class="subtotal" value="">
                                    <td><a href="" class=" btn-danger btn-sm delete-tr"><i class="fa fa-fw fa-trash"></i></a></td>
                                </tr>
                            `);
                            rowCount++;
                            calculate();
                        });
                    }
                });
                $(document).on('click','#paid_text', function(){
                    var payable = parseFloat($('#total_payable').val());
                    $('#paid').val(payable);
                    grandTotalCalculation();
                })
            });

            function calculate() {
                var total_discount = 0;
                var total_subtotal = 0;

                $('#test_table').find('.quantity').each(function(index, item) {
                    var rate = parseFloat($(item).closest('tr').find('.cost').val());
                    var quantity = parseFloat($(item).val());
                    var subtotal = rate * quantity;

                    // Update the subtotal field and display
                    $(item).closest('tr').find('.subtotal').text(subtotal);
                    $(item).closest('tr').find('.subtotal-input').val(subtotal);

                    total_subtotal += subtotal;
                });

                $('#test_table .discount_amount').each(function(index, item) {
                    let refd_amount = $(item).val();
                    total_discount += parseFloat(refd_amount);
                });

                $('#max_discount').val(total_discount);
                $('#sub_total').val(total_subtotal);
                var discount_amount = $('#discount_amount').val();
                discount_calculate(discount_amount);

                grandTotalCalculation();
            }


            function grandTotalCalculation(){
                var subtotal = parseFloat($('#sub_total').val());
                var discount = parseFloat($('#discount_amount').val());
                var shipping_cost = parseFloat($('#shipping_cost').val());
                var total_payable = subtotal - discount + shipping_cost;

                $('#total_payable').val(total_payable);
                var paid = parseFloat($('#paid').val() || 0);
                var due = total_payable - paid;
                $('#due').val(due);
            }
            function discount_calculate(InputValue){
                var subtotal = parseFloat($('#sub_total').val());
                
                var amount = parseFloat($('#discount_amount').val() || 0);
                var percent = parseFloat($('#discount_percent').val() || 0);
                if(InputValue == amount){
                    var parcentage = (InputValue / subtotal) * 100;
                    $('#discount_percent').val(parcentage.toFixed(1));
                }else{
                    var amounts = (subtotal * InputValue) / 100;
                    $('#discount_amount').val(amounts);
                }
                
                grandTotalCalculation();
            }
            $('input[name="paid"]').on('input',function(){
                var payable = parseFloat($('#total_payable').val());
                if(payable < parseFloat($(this).val())){
                    alert(`You can't pay more than ${payable}`);
                    $(this).val(payable);
                }
                grandTotalCalculation();
            })
            $('input[name="discount_amount"],input[name="discount_percent"]').on('input',function(){
                discount_calculate(parseFloat($(this).val()));
            })
            $(document).on('click keyup','#increment_subtotal',function(){
                calculate();
            });
            $(document).on('click keyup','#shipping_cost',function(){
                calculate();
            });
            $(document).on('click','.delete-tr',function(e){
              e.preventDefault();
              $(this).closest('tr').remove();

              calculate();
            });

            $("#btnSubmit").click(function(){
                $("#btnSubmit").prop('disabled',true);
            });
            
        </script>
    @endpush
</x-admin>