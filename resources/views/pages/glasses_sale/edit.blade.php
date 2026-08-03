<x-admin title="Medicine Purchase Edit">
    {{-- <x-page-header head="Doctor" /> --}}
    <x-card header="Medicine Purchase Edit" links="{{ route('pathology.patient.index') }}" title="Patient List">
        <x-form  method="post" action="{{ route('glasses.sale.update',$sale->id) }}">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <x-input id="date" type="date" value="{{$sale->created_at->format('Y-m-d')}}" class="col-md-4" required />
                        <x-input id="customer" value="{{$sale->name}}" class="col-md-4" required />
                        <x-input id="phone" value="{{$sale->phone}}" class="col-md-4" required />
                        
                        <div class="col-md-6">
                            <label for="lens">Select Frame</label>
                            <select name="frame" id="frame" data-live-search="true" title="Select frame" class="form-control selectpicker">
                                @foreach ($frame as $key=>$item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="lens">Select Glass</label>
                            <select name="glass" id="glass" data-live-search="true" title="Select glass" class="form-control selectpicker">
                                @foreach ($glass as $key=>$item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
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
                                    <th style="width:100px">Unit</th>
                                    <th>Rate</th>
                                    <th>Sub Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="test_table">
                                @foreach ($sale->glass as $key=>$item)
                                    <tr data-test-id="">
                                        <td>{{++$key}}</td>
                                        <td>{{$item->glass->name}}</td>
                                        <td><input type="number" id="increment_subtotal" name="qty[]" class="form-control quantity" value="{{$item->qty}}" min="1"></td>
                                        <input type="hidden" name="glass_price[]" class="price" value="{{$item->price}}">
                                        <input type="hidden" name="glass_id[]" class="cost" value="{{$item->glass_id}}">
                                        <td>{{$item->price}}</td>
                                        <td class="subtotal">{{$item->qty * $item->price}}</td>
                                        <input type="hidden" name="subtotal" class="subtotal" value="{{$item->qty * $item->price}}">
                                        <td><a href="" class=" btn-danger btn-sm delete-tr"><i class="fa fa-fw fa-trash"></i></a></td>
                                    </tr>
                                @endforeach
                                @foreach ($sale->frame as $key=>$item)
                                    <tr data-test-id="">
                                        <td>{{++$key}}</td>
                                        <td>{{$item->frame->name}}</td>
                                        <td><input type="number" id="increment_subtotal" name="qty[]" class="form-control quantity" value="{{$item->qty}}" min="1"></td>
                                        <input type="hidden" name="frame_price[]" class="price" value="{{$item->price}}">
                                        <input type="hidden" name="frame_id[]" class="cost" value="{{$item->frame_id}}">
                                        <td>{{$item->price}}</td>
                                        <td class="subtotal">{{$item->qty * $item->price}}</td>
                                        <input type="hidden" name="subtotal" class="subtotal" value="{{$item->qty * $item->price}}">
                                        <td><a href="" class=" btn-danger btn-sm delete-tr"><i class="fa fa-fw fa-trash"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <x-textarea  id="note" value="{{ $data->note ?? old('note') }}"/>
                </div>
                <div class="col-md-4">
                    <x-small-card header="Calculation Part">
                        <x-inline-input value="{{$sale->total_price}}" id="sub_total" />
                        <input type="hidden" id="max_discount" name="max_discount">
                        <div class="mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend" style="width: 40%">
                                    <div class="input-group-text w-100" id="max_discount" style="cursor: pointer">Discount</div>
                                </div>
                                <input type="text" class="form-control" max="100" id="discount_percent" name="discount_percent" placeholder="%">
                                <input type="text" class="form-control" value="{{$sale->discount}}" id="discount_amount" name="discount_amount"  placeholder="Amount">
                            </div>
                        </div>
                        <x-inline-input id="shipping_cost" value="{{$sale->shipping_cost}}" />
                        <x-inline-input id="total_payable" value="{{$sale->grand_total}}" />
                        <div class="mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend" style="width: 40%">
                                    <div class="input-group-text w-100" id="paid_text" style="cursor: pointer">Paid</div>
                                </div>
                                <input type="text" class="form-control" id="paid" name="paid" value="{{$sale->paid}}"  placeholder="Paid Amount">
                            </div>
                        </div>
                        <x-inline-input id="change" value="{{$sale->changes}}" />
                    </x-small-card>
                    <button type="submit" class="btn btn-sm btn-primary mt-3"><i
                                                        class="fa fa-save"></i>
                                                    Save</button>
                    
                </div>
                
            </div>
            
        </x-form>
    </x-card>

    @push('js')
        <script>
          
            $(document).ready(function() {
                
                var rowCount = 1;

                // Use event delegation to handle dynamically added elements
                $(document).on('change', '#glass', function () {
                    var selectedValue = $(this).val();


                    // Add new row if not exists
                    $.get("/pharmacy/glasses/sale/find_glass/" + selectedValue, function (data) {
                        console.log(data);
                        
                        $('#test_table').append(`
                            <tr data-test-id="${selectedValue}">
                                <td>${rowCount}</td>
                                <td>${data.name}</td>
                                <td>
                                    <input type="number" id="increment_subtotal" name="qty[]" class="form-control quantity" value="1" min="1">
                                </td>
                                <input type="hidden" name="glass_price[]" class="price" value="${data.price}">
                                <input type="hidden" name="stock[]" class="stock" value="${data.stock}">
                                <input type="hidden" name="glass_id[]" value="${data.id}">
                                <td>
                                    ${data.price}</td>
                                <td class="subtotal"></td>
                                <input type="hidden" name="subtotal[]" class="subtotal-input" value="">
                                <td>
                                    <a href="#" class="btn-danger btn-sm delete-tr">
                                        <i class="fa fa-fw fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        `);

                        rowCount++;
                        calculate();
                    });
                });
                $(document).on('change', '#frame', function () {
                    var selectedValue = $(this).val();

                    // Find existing row
                    var existingItem = $(`#test_table tr[data-test-id="${selectedValue}"]`);

                    if (existingItem.length > 0) {
                        // Increment quantity
                        var qtyInput = existingItem.find('.quantity');
                        qtyInput.val(parseInt(qtyInput.val()) + 1);

                        calculate();

                        return;
                    }

                    // Add new row if not exists
                    $.get("/pharmacy/glasses/sale/find_frame/" + selectedValue, function (data) {
                        console.log(data);
                        
                        $('#test_table').append(`
                            <tr data-test-id="${selectedValue}">
                                <td>${rowCount}</td>
                                <td>${data.name}</td>
                                <td>
                                    <input type="number" id="increment_subtotal" name="qty[]" class="form-control quantity" value="1" min="1">
                                </td>
                                <input type="hidden" name="frame_price[]" class="price" value="${data.price}">
                                <input type="hidden" name="stock[]" class="stock" value="${data.stock}">
                                <input type="hidden" name="frame_id[]" value="${data.id}">
                                <td>
                                    ${data.price}</td>
                                <td class="subtotal"></td>
                                <input type="hidden" name="subtotal[]" class="subtotal-input" value="">
                                <td>
                                    <a href="#" class="btn-danger btn-sm delete-tr">
                                        <i class="fa fa-fw fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        `);

                        rowCount++;
                        calculate();
                    });
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
                    var rate = parseFloat($(item).closest('tr').find('.price').val());
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
                var total_payable = subtotal - discount;

                $('#total_payable').val(total_payable);
                var paid = parseFloat($('#paid').val() || 0);
                var change = total_payable - paid;
                $('#change').val(Math.abs(change));
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
                grandTotalCalculation();
            });
            $('input[name="discount_amount"],input[name="discount_percent"]').on('input',function(){
                discount_calculate(parseFloat($(this).val()));
            })
            $(document).on('click keyup','#increment_subtotal',function(){
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