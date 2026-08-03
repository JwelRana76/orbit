<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FramePurchaseItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function frame()
    {
        return $this->belongsTo(Frame::class, 'frame_id', 'id');
    }
}
