<?php

namespace App\Service;
use Yajra\DataTables\Facades\DataTables;
use app\Models\User;

class UserService extends Service {
    protected $model = User::class;

    public function index(){
        $user = $this->model::all();
      DataTables::of($user)
        ->addColumn('role', function ($user) {
            return $user->role->role->name ?? 'N/A';
        })
        ->addColumn('action', fn ($item) => view('pages.user.action', compact('item'))->render())
        ->make(true);
    }
 
}