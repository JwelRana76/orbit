<x-admin title="Lens Provider">
    <x-card header="Lens Provider" links="{{ route('pathology.patient.index') }}" title="Patient List">
        <x-form  method="post" action="{{ route('lens.provider.update',$purchase->id) }}">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <x-input id="date" type="date" value="{{$purchase->created_at->format('Y-m-d')}}" class="col-md-4" required />
                        <x-input id="provider" class="col-md-4" value="{{$purchase->provider}}" required />
                        <x-input id="company" class="col-md-4" value="{{$purchase->company}}" required />
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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="test_table">
                                @foreach ($purchase->items as $key=>$item)
                                    <tr data-test-id="">
                                        <td>{{++$key}}</td>
                                        <td>{{$item->lens->name}} {{$item->lens->power}}</td>
                                        <td><input type="number" name="qty[]" class="form-control" value="{{$item->qty}}" min="1"></td>
                                        <input type="hidden" name="lens_id[]" class="cost" value="{{$item->lens_id}}">
                                        <td><a href="" class=" btn-danger btn-sm delete-tr"><i class="fa fa-fw fa-trash"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <x-textarea  id="note" value="{{ $data->note ?? old('note') }}"/>
                </div>
                <button type="submit" class="btn btn-sm btn-primary mt-3"><i
                                                        class="fa fa-save"></i>
                                                    Save</button>
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
                                    <td><input type="number" name="qty[]" class="form-control" value="1" min="1"></td>
                                    <input type="hidden" name="lens_id[]" class="cost" value="${data.id}">
                                    <td><a href="" class=" btn-danger btn-sm delete-tr"><i class="fa fa-fw fa-trash"></i></a></td>
                                </tr>
                            `);
                            rowCount++;
                        });
                    }
                });
            });

            
            $(document).on('click','.delete-tr',function(e){
              e.preventDefault();
              $(this).closest('tr').remove();

            });
            
        </script>
    @endpush
</x-admin>