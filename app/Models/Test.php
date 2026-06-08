<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    public static $columns = [
        ['name' => 'name', 'data' => 'name'],
        ['name' => 'rate', 'data' => 'rate'],
        ['name' => 'max_discount', 'data' => 'max_discount'],
        ['name' => 'action', 'data' => 'action'],
    ];
    
    protected $guarded = ['id'];
}
