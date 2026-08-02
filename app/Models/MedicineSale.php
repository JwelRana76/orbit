<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineSale extends Model
{
    use HasFactory;

    public static $columns = [
        ['name' => 'date', 'data' => 'date'],
        ['name' => 'customer', 'data' => 'customer'],
        ['name' => 'total', 'data' => 'total'],
        ['name' => 'discount', 'data' => 'discount'],
        ['name' => 'grand_total', 'data' => 'grand_total'],
        ['name' => 'paid', 'data' => 'paid'],
        ['name' => 'due', 'data' => 'due'],
        ['name' => 'action', 'data' => 'action'],
    ];
     
    protected $guarded = ['id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function items()
    {
        return $this->hasMany(MedicineSaleItem::class, 'medicine_sale_id', 'id');
    }
    public function payment(){
        return $this->hasMany(SalePayment::class, 'medicine_sale_id');
    }
    public function getPaidAttribute()
    {
        return $this->payment()->sum('amount');
    }
}
