<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lens extends Model
{
    use HasFactory;
    
    public static $columns = [
        ['name' => 'name', 'data' => 'name'],
        ['name' => 'constant', 'data' => 'constant'],
        ['name' => 'cost', 'data' => 'cost'],
        ['name' => 'price', 'data' => 'price'],
        ['name' => 'action', 'data' => 'action'],
    ];
    
    protected $guarded = ['id'];
}
