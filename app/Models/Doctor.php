<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    public static $columns = [
        ['name' => 'photo', 'data' => 'photo'],
        ['name' => 'name', 'data' => 'name'],
        ['name' => 'designation', 'data' => 'designation'],
        ['name' => 'institute', 'data' => 'institute'],
        ['name' => 'degree', 'data' => 'degree'],
        ['name' => 'contact', 'data' => 'contact'],
        ['name' => 'signature', 'data' => 'signature'],
        ['name' => 'action', 'data' => 'action'],
    ];

    protected $guarded = ['id'];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }
    public function religion()
    {
        return $this->belongsTo(Religion::class);
    }
    public function blood_group()
    {
        return $this->belongsTo(BloodGroup::class);
    }
}
