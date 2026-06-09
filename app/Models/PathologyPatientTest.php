<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PathologyPatientTest extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    function test()
    {
        return $this->belongsTo(Test::class);
    }
}
