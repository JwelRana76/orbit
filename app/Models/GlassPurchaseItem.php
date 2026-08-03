<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlassPurchaseItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function glass()
    {
        return $this->belongsTo(Glass::class, 'glass_id', 'id');
    }
}
