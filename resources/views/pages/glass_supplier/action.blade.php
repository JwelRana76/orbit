
<div class="btn-group dropleft">
    <button type="button" class="action-button dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-fw fa-ellipsis-v"></i>
    </button>
    <div class="dropdown-menu">
        {{-- @if (userHasPermission('patient-update')) --}}
        <a class="dropdown-item" href="{{ route('glass.supplier.edit',base64_encode($item->id)) }}" ><i class="fa fa-fw text-primary fa-pen-nib"></i> Edit</a>
        {{-- @endif --}}
        @if ($item->due > 0)
            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#paymentModal" data-id="{{$item->id}}" data-due="{{$item->due}}" ><i class="fa fa-fw text-primary fa-file"></i> Payment</button>
        @endif
        <button type="button" class="dropdown-item" data-toggle="modal" data-target="#paymentDetails" data-id="{{$item->id}}"><i class="fa fa-fw text-primary fa-file"></i> Payment Details</button>
        
        {{-- @if (userHasPermission('patient-delete')) --}}
        <a class="dropdown-item" href="{{ route('glass.supplier.delete',base64_encode($item->id)) }}" onclick="return confirm('Are you sure to Delete this record..??')"><i class="fa fa-fw text-danger fa-trash"></i> Delete</a>
        {{-- @endif --}}
    </div>   
</div>