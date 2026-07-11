<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionPatient extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static $columns = [
        ['name' => 'date', 'data' => 'date'],
        ['name' => 'name', 'data' => 'name'],
        ['name' => 'age', 'data' => 'age'],
        ['name' => 'surgone', 'data' => 'surgone'],
        ['name' => 'contact', 'data' => 'contact'],
        ['name' => 'lens', 'data' => 'lens'],
        ['name' => 'set', 'data' => 'set'],
        ['name' => 'ot', 'data' => 'ot'],
        ['name' => 'total', 'data' => 'total'],
        ['name' => 'action', 'data' => 'action'],
    ];
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
