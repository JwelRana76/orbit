<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PathologyPatient extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static $columns = [
        ['name' => 'visit_date', 'data' => 'visit_date'],
        ['name' => 'type', 'data' => 'type'],
        ['name' => 'name', 'data' => 'name'],
        ['name' => 'age', 'data' => 'age'],
        ['name' => 'contact', 'data' => 'contact'],
        ['name' => 'gender', 'data' => 'gender'],
        ['name' => 'address', 'data' => 'address'],
        ['name' => 'action', 'data' => 'action'],
    ];

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
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function blood_group()
    {
        return $this->belongsTo(BloodGroup::class);
    }
    public function documents()
    {
        return $this->hasMany(PatientDocument::class);
    }
    public function getAgesAttribute()
    {
        if ($this->age_type == 1) {
            $ex = 'Days';
        } elseif ($this->age_type == 2) {
            $ex = 'Months';
        } else {
            $ex = 'Years';
        }
        return $this->age . ' ' . $ex;
    }
}
