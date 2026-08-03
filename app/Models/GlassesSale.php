<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlassesSale extends Model
{
    use HasFactory;

    
    public static $columns = [
        ['name' => 'date', 'data' => 'date'],
        ['name' => 'customer', 'data' => 'customer'],
        ['name' => 'total', 'data' => 'total'],
        ['name' => 'discount', 'data' => 'discount'],
        ['name' => 'grand_total', 'data' => 'grand_total'],
        ['name' => 'paid', 'data' => 'paid'],
        ['name' => 'change', 'data' => 'change'],
        ['name' => 'action', 'data' => 'action'],
    ];
     
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function glass()
    {
        return $this->hasMany(GlassSaleItem::class, 'glasses_sale_id', 'id');
    }
    public function frame()
    {
        return $this->hasMany(FrameSaleItem::class, 'glasses_sale_id', 'id');
    }
    public function payment(){
        return $this->hasMany(GlassesSalePayment::class, 'glasses_sale_id');
    }
    public function getPaidAttribute()
    {
        return $this->payment()->sum('amount');
    }
}
