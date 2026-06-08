<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    public static $columns = [
        ['name' => 'name', 'data' => 'name'],
        ['name' => 'code', 'data' => 'code'],
        ['name' => 'action', 'data' => 'action'],
    ];

    protected $guarded = ['id'];
}
