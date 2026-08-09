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
        ['name' => 'reg_no', 'data' => 'reg_no'],
        ['name' => 'patient', 'data' => 'patient'],
        ['name' => 'surgone', 'data' => 'surgone'],
        ['name' => 'lens', 'data' => 'lens'],
        ['name' => 'bed', 'data' => 'bed'],
        ['name' => 'ot', 'data' => 'ot'],
        ['name' => 'status', 'data' => 'status'],
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
    function lens()
    {
        return $this->belongsTo(Lens::class);
    }
    function bed()
    {
        return $this->belongsTo(Bed::class);
    }
    function operation()
    {
        return $this->belongsTo(Operation::class);
    }

    function gettotalAttribute()
    {
        return $this->admission_fee + $this->ot_fee + $this->lens_fee + $this-> bed_fee;
        
    }
}
