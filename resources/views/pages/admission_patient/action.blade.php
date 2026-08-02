<!-- Default dropleft button -->
<div class="btn-group dropleft">
    <button type="button" class="action-button dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-fw fa-ellipsis-v"></i>
    </button>
    <div class="dropdown-menu">
        {{-- @if (userHasPermission('patient-update')) --}}
        <a class="dropdown-item" href="{{ route('admission.patient.edit',$item->id) }}" ><i class="fa fa-fw text-primary fa-pen-nib"></i> Edit</a>
        @if ($item->status == true)
        <a class="dropdown-item" href="{{ route('admission.patient.release',$item->id) }}" ><i class="fas fa-fw fa-arrow-left"></i> Release</a>
        @endif
        @if ($item->status == true)
        <button type="button" class="dropdown-item" data-toggle="modal" data-target="#cancelModal" data-id="{{$item->id}}" ><i class="fas fa-fw fa-arrow-left"></i> Cancel</button>
        @endif
        {{-- @endif --}}
        @if ($item->payment_status == false && $item->status != null)
            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#paymentModal" data-id="{{$item->id}}" ><i class="fa fa-fw text-primary fa-file"></i> Payment</button>
        @endif
        {{-- @if (userHasPermission('patient-delete')) --}}
        <a class="dropdown-item" href="{{ route('admission.patient.delete',$item->id) }}" onclick="return confirm('Are you sure to Delete this record..??')"><i class="fa fa-fw text-danger fa-trash"></i> Delete</a>
        {{-- @endif --}}
    </div>   
</div>