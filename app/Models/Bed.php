<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    use HasFactory;

    public static $columns = [
        ['name' => 'name', 'data' => 'name'],
        ['name' => 'type', 'data' => 'type'],
        ['name' => 'status', 'data' => 'status'],
        ['name' => 'action', 'data' => 'action'],
    ];
     
    protected $guarded = ['id'];
}
