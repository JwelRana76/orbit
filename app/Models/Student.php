<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public static $columns = [
        ['name' => 'name', 'data' => 'name'],
        ['name' => 'roll', 'data' => 'roll'],
        ['name' => 'reg_no', 'data' => 'reg_no'],
        ['name' => 'unique_id', 'data' => 'unique_id'],
        ['name' => 'class', 'data' => 'class'],
        ['name' => 'action', 'data' => 'action'],
    ];
     
    protected $guarded = ['id'];

    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class_id', 'id');
    }
}
