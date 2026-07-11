<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LensPurchase extends Model
{
    use HasFactory;

    public static $columns = [
        ['name' => 'date', 'data' => 'date'],
        ['name' => 'chalan_no', 'data' => 'chalan_no'],
        ['name' => 'supplier', 'data' => 'supplier'],
        ['name' => 'shipping_cost', 'data' => 'shipping_cost'],
        ['name' => 'grand_total', 'data' => 'grand_total'],
        ['name' => 'paid_amount', 'data' => 'paid_amount'],
        ['name' => 'due', 'data' => 'due'],
        ['name' => 'action', 'data' => 'action'],
    ];
    
    protected $guarded = ['id'];

    public function supplier()
    {
        return $this->belongsTo(LensSupplier::class, 'lens_supplier_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function items()
    {
        return $this->hasMany(LensPurchaseItem::class, 'lens_purchase_id', 'id');
    }
    public function payment(){
        return $this->hasMany(LensPayment::class, 'lens_purchase_id');
    }
    public function getPaidAmountAttribute()
{
    return $this->payment()->sum('amount');
}
}
