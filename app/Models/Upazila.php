<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upazila extends Model
{
    use HasFactory;

    public static $columns = [
        ['name' => 'district', 'data' => 'district'],
        ['name' => 'name', 'data' => 'name'],
        ['name' => 'code', 'data' => 'code'],
        ['name' => 'action', 'data' => 'action'],
    ];
    
    protected $guarded = ['id'];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
}
