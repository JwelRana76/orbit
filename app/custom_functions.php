<?php

use App\Models\Permission;
use App\Models\RoleHasPermission;
use App\Models\SiteSetting;
use App\Models\UserHasRole;

function setting()
{
  return SiteSetting::findOrFail(1);
}
function userHasPermission($permission)
{


  $user = Auth()->user()->id;
  $role = UserHasRole::where('user_id', $user)->first();

  $permission = Permission::where('name', $permission)->first();
  if ($permission && $role) {
    $valide = RoleHasPermission::where(['role_id' => $role->role_id, 'permission_id' => $permission->id])->first();
    if ($valide) {
      return true;
    } else {
      return false;
    }
  } else {
    return false;
  }
}
function hasNotPermission()
{
  return view('not_permitted');
}
