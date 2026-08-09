<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    public static $columns = [
        ['name' => 'date', 'data' => 'date'],
        ['name' => 'purposes', 'data' => 'purposes'],
        ['name' => 'amount', 'data' => 'amount'],
        ['name' => 'note', 'data' => 'note'],
        ['name' => 'action', 'data' => 'action'],
    ];

    protected $guarded = ['id'];
}
