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
        ['name' => 'name', 'data' => 'name'],
        ['name' => 'age', 'data' => 'age'],
        ['name' => 'contact', 'data' => 'contact'],
        ['name' => 'tests', 'data' => 'test'],
        ['name' => 'total', 'data' => 'total'],
        ['name' => 'discount', 'data' => 'discount_amount'],
        ['name' => 'grand_total', 'data' => 'grand_total'],
        ['name' => 'report', 'data' => 'report'],
        ['name' => 'action', 'data' => 'action'],
    ];
    function tests()
    {
        return $this->hasMany(PathologyPatientTest::class, 'pathology_patient_id', 'id');
    }
    function user()
    {
        return $this->belongsTo(User::class);
    }
    function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    function gender()
    {
        return $this->belongsTo(Gender::class);
    }
    function referral()
    {
        return $this->belongsTo(Doctor::class);
    }

    function getMaxdiscountAttribute()
    {
        $data = $this->tests()->get();
        $max = 0;
        foreach ($data as $key => $item) {
            $max += $item->test()->sum('referral_fee_amount');
        }
        return $max;
    }
}
