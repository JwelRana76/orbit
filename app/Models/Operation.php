<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;
    public static $columns = [
        ['name' => 'name', 'data' => 'name'],
        ['name' => 'charge', 'data' => 'charge'],
        ['name' => 'status', 'data' => 'status'],
        ['name' => 'action', 'data' => 'action'],
    ];
     
    protected $guarded = ['id'];
}
