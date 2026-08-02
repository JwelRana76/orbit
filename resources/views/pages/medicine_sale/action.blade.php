<div class="btn-group dropleft">
    <button type="button" class="action-button dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-fw fa-ellipsis-v"></i>
    </button>
    <div class="dropdown-menu">
        {{-- @if (userHasPermission('patient-update')) --}}
        <a class="dropdown-item" href="{{ route('medicine.sale.edit',base64_encode($item->id)) }}" ><i class="fa fa-fw text-primary fa-pen-nib"></i> Edit</a>
        {{-- @endif --}}
        <a class="dropdown-item" onclick="window.open('{{route('medicine.sale.invoice',$item->id)}}','popup','width=600,height=600,scrollbars=no,resizable=no'); return false;" target="popup" href="#" ><i class="fa fa-fw text-primary fa-file"></i> Invoice</a>
        @if ($item->grand_total > $item->paid)
            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#paymentModal" data-id="{{$item->id}}" data-due="{{$item->grand_total - $item->paid}}" ><i class="fa fa-fw text-primary fa-file"></i> Payment</button>
        @endif
        {{-- @if (userHasPermission('patient-delete')) --}}
        <a class="dropdown-item" href="{{ route('medicine.sale.delete',base64_encode($item->id)) }}" onclick="return confirm('Are you sure to Delete this record..??')"><i class="fa fa-fw text-danger fa-trash"></i> Delete</a>
        {{-- @endif --}}
    </div>   
</div>