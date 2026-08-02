<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lens extends Model
{
    use HasFactory;
    
    public static $columns = [
        ['name' => 'name', 'data' => 'name'],
        ['name' => 'power', 'data' => 'power'],
        ['name' => 'constant', 'data' => 'constant'],
        ['name' => 'cost', 'data' => 'cost'],
        ['name' => 'price', 'data' => 'price'],
        ['name' => 'stock', 'data' => 'stock'],
        ['name' => 'action', 'data' => 'action'],
    ];
    
    protected $guarded = ['id'];

    function getstockAttribute()
    {
        if($this->is_hospital_provider == true){
            $purchase = LensPurchaseItem::where('lens_id',$this->id)->sum('qty');
            $used = AdmissionPatient::where('lens_id',$this->id)->count();
            return $purchase - $used;
        }
        else {
            $purchase = LenProvideItem::where('lens_id',$this->id)->sum('qty');
            $used = AdmissionPatient::where('lens_id',$this->id)->count();
            return $purchase - $used;
        }
    }
}
