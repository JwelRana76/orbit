<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    public static $columns = [
        ['name' => 'division', 'data' => 'division'],
        ['name' => 'name', 'data' => 'name'],
        ['name' => 'code', 'data' => 'code'],
        ['name' => 'action', 'data' => 'action'],
    ];
    
    protected $guarded = ['id'];

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id', 'id');
    }
}
