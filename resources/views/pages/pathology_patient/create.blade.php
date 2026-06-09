<x-admin title="Pathology Patient Create">
    {{-- <x-page-header head="Doctor" /> --}}
    <x-card header="Pathology Patient Create" links="{{ route('pathology.patient.index') }}" title="Patient List">
        <form id="patient_insert_form">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <x-input id="name" class="col-md-12" required />
                        <x-input id="contact" class="col-md-4" required />
                        <div class="col-md-4">
                            <x-select id="gender" name="gender_id" :options="$gender" class="col-md-4" required />
                        </div>
                        <div class=" col-md-4 col-xl-4 col-sm-12">
                            <label for="age">Age</label>
                            <div class="input-group mb-3">
                            <input type="text" name="age" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <x-select id="doctor" name="doctor_id" :options="$doctors" class="col-md-4" />
                        </div>
                        <div class="col-md-6">
                            <x-select id="referal" name="referal_id" :options="$doctors" class="col-md-4" />
                        </div>
                        <div class="col-md-12">
                            <x-select id="pathologytest" name="test_id" :options="$tests" key="code" class="col-md-4" />
                        </div>
                    </div>
                    <div class="row mt-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
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
                                <input type="text" class="form-control" id="discount_amount" name="discount_amount"  placeholder="Amount">
                            </div>
                        </div>
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
                    <button onclick="PatientCreate()" id="btnSubmit" type="button" class="btn btn-sm btn-primary mt-3  save-btn" target="_blank"><i
                                                        class="fa fa-save"></i>
                                                    Save</button>
                    <a href="{{ route('pathology.patient.create') }}"  class="btn btn-sm btn-success float-right mt-3">Clear form</a>
                </div>
                
            </div>
            
        </form>
    </x-card>

    @push('js')
        <script>
          
            $(document).ready(function() {
                
                var rowCount = 1;

                // Use event delegation to handle dynamically added elements
                $(document).on('change', '#pathologytest', function() {
                    var selectedValue = $(this).val();
                    // Check if an item with the same value already exists in the table
                    var existingItem = $(`#test_table tr[data-test-id="${selectedValue}"]`);

                    if (existingItem.length === 0) {
                        $.get("/pathology/patient/test_find/" + selectedValue, function (data) {
                            console.log(data);
                            $('#test_table').append(`
                                <tr data-test-id="${selectedValue}">
                                    <td>${rowCount}</td>
                                    <td>${data.name}</td>
                                    <td><input type="number" name="qty[]" class="form-control quantity" value="1" min="1" readonly></td>
                                    <input type="hidden" name="rate[]" class="rate" value="${data.rate}">
                                    <input type="hidden" name="test_id[]" class="rate" value="${data.id}">
                                    <input type="hidden" name="max_discount[]" class="max_discount" value="${data.max_discount}">
                                    <td>${data.rate}</td>
                                    <td class="subtotal"></td>
                                    <input type="hidden" name="subtotal" class="subtotal" value="">
                                    <input type="hidden" name="discount_amount" class="discount_amount" value="${data.referral_fee_amount}">
                                    <td><a href="" class=" btn-danger btn-sm delete-tr"><i class="fa fa-fw fa-trash"></i></a></td>
                                </tr>
                            `);
                            rowCount++;
                            calculate();
                        });
                    }
                });
                $(document).on('click','#max_discount', function(){
                    var max_discount = 0;
                    $('#test_table .max_discount').each(function(index, item) {
                        let amount = $(item).val();
                        max_discount += parseFloat(amount);
                    });
                    $('#discount_amount').val(max_discount);
                    discount_calculate(max_discount);
                })
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
                    var rate = parseFloat($(item).closest('tr').find('.rate').val());
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
                $('#discount_amount').val(0);
                discount_calculate(0);

                grandTotalCalculation();
            }


            function grandTotalCalculation(){
                var subtotal = parseFloat($('#sub_total').val());
                var discount = parseFloat($('#discount_amount').val());
                var total_payable = subtotal - discount;

                $('#total_payable').val(total_payable);
                var paid = parseFloat($('#paid').val() || 0);
                var due = total_payable - paid;
                $('#due').val(due);
            }
            function discount_calculate(InputValue){
                var max_discount = parseFloat($('#max_discount').val());
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
                
                
                var discount_amount = parseFloat($('#discount_amount').val() ?? 0);
                if(max_discount < discount_amount){
                    alert(`You can not set discount more than ${max_discount}`);
                    $('#discount_amount').val(max_discount);
                    discount_calculate(max_discount);
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
            $(document).on('click','.delete-tr',function(e){
              e.preventDefault();
              $(this).closest('tr').remove();

              calculate();
            });

            $("#btnSubmit").click(function(){
                $("#btnSubmit").prop('disabled',true);
            });
            function PatientCreate(){
                
                // $('.error_list').html('');
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var properties = "toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=500,width=700,height=300";
                var data = $('#patient_insert_form').serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ route('pathology.patient.store') }}",
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        window.open("/pathology/patient/invoice/"+response.id,"popup",properties);
                        location.reload();
                    },
                    error: function(reject) {
                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function(key, val) {
                            $('.error_list').append(`<li class="text-danger">`+val+`</li>`);
                        })
                    }
                });
            }
        </script>
    @endpush
</x-admin>