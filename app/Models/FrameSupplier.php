<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrameSupplier extends Model
{
    use HasFactory;

    public static $columns = [
        ['name' => 'name', 'data' => 'name'],
        ['name' => 'contact', 'data' => 'contact'],
        ['name' => 'address', 'data' => 'address'],
        ['name' => 'due', 'data' => 'due'],
        ['name' => 'action', 'data' => 'action'],
    ];
     
    protected $guarded = ['id'];

    public function getDueAttribute()
    {
        $total_amount = FramePurchase::where('frame_supplier_id',$this->id)->sum('grand_total');
        $paid = FramePurchasePayment::whereHas('purchase', function ($query) {
            $query->where('frame_supplier_id', $this->id);
        })->sum('amount');
        return $total_amount - $paid;
        
    }
}
