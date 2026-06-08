<div class="btn-group dropleft">
    <a class="edit_button" href="{{ route('group.edit',base64_encode($item->id)) }}"><i class="fas fa-fw fa-pen"></i></a>
    <a class="delete_button" href="{{ route('group.delete',base64_encode($item->id)) }}" onclick="return confirm('Are you sure to Delete this record..??')"><i class="fas fa-fw fa-trash"></i></a> 
</div>
