<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FramePurchasePayment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function purchase()
    {
        return $this->belongsTo(FramePurchase::class, 'Frame_purchase_id');
    }
}
