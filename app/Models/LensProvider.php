<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LensProvider extends Model
{
    use HasFactory;

    public static $columns = [
        ['name' => 'date', 'data' => 'date'],
        ['name' => 'provider', 'data' => 'provider'],
        ['name' => 'company', 'data' => 'company'],
        ['name' => 'total_qty', 'data' => 'total_qty'],
        ['name' => 'action', 'data' => 'action'],
    ];
    
    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(LenProvideItem::class, 'lens_provider_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
