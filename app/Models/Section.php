<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    public static $columns = [
        ['name' => 'name', 'data' => 'name'],
        ['name' => 'action', 'data' => 'action'],
    ];
     
    protected $guarded = ['id'];
}
