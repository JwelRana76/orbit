<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LensPurchaseItem extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function lens()
    {
        return $this->belongsTo(Lens::class, 'lens_id', 'id');
    }
}
