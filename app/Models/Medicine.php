<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    public static $columns = [
        ['name' => 'name', 'data' => 'name'],
        ['name' => 'type', 'data' => 'type'],
        ['name' => 'group', 'data' => 'group'],
        ['name' => 'company', 'data' => 'company'],
        ['name' => 'stock', 'data' => 'stock'],
        ['name' => 'price', 'data' => 'price'],
        ['name' => 'action', 'data' => 'action'],
    ];
     
    protected $guarded = ['id'];

    function getstockAttribute()
    {
        $purchase = MedicinePurchaseItem::where('medicine_id',$this->id)->sum('qty');
        $sale = MedicineSaleItem::where('medicine_id',$this->id)->sum('qty');
        return $purchase - $sale;
    }
}
