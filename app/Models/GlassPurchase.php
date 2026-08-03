<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlassPurchase extends Model
{
    use HasFactory;

    public static $columns = [
        ['name' => 'date', 'data' => 'date'],
        ['name' => 'chalan_no', 'data' => 'chalan_no'],
        ['name' => 'supplier', 'data' => 'supplier'],
        ['name' => 'grand_total', 'data' => 'grand_total'],
        ['name' => 'paid_amount', 'data' => 'paid_amount'],
        ['name' => 'due', 'data' => 'due'],
        ['name' => 'action', 'data' => 'action'],
    ];
     
    protected $guarded = ['id'];

    public function supplier()
    {
        return $this->belongsTo(GlassSupplier::class, 'glass_supplier_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function items()
    {
        return $this->hasMany(GlassPurchaseItem::class, 'glass_purchase_id', 'id');
    }
    public function payment(){
        return $this->hasMany(GlassPurchasePayment::class, 'glass_purchase_id');
    }
    public function getPaidAmountAttribute()
    {
        return $this->payment()->sum('amount');
    }
}
