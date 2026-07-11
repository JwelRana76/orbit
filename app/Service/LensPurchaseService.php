<?php

namespace App\Service;

use App\Models\LensPayment;
use App\Models\LensPurchase;
use App\Models\LensPurchaseItem;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class LensPurchaseService {

    protected $model = LensPurchase::class;

    function index()
    {
        $purchase = $this->model::orderBy('id', 'desc')->withSum('payment', 'amount')->get();
        return DataTables::of($purchase)
        ->addColumn('date', function ($item) {
            return $item->created_at->format('d-M-Y');
        })
        ->addColumn('supplier', function ($item) {
            return $item->supplier->name . '<br>' .
            $item->supplier->contact . '<br>' .
            $item->supplier->address;
        })
        ->addColumn('paid_amount', function ($item) {
            return $item->paid_amount;
        })
        ->addColumn('due', function ($item) {
            return $item->grand_total - $item->paid_amount;
        })
        ->addColumn('action', fn ($item) => view('pages.lens_purchase.action', compact('item'))->render())
        ->rawColumns(['action','supplier'])
        ->make(true);
    }
    function store($data)
    {
        DB::beginTransaction();
        try {
            
        $purchase_data['user_id'] = auth()->user()->id;
        $purchase_data['lens_supplier_id'] = $data['supplier'];
        $purchase_data['chalan_no'] = $data['chalan_no'];
        $purchase_data['total_qty'] = array_sum($data['qty']);
        $purchase_data['total_price'] = $data['sub_total'];
        $purchase_data['shipping_cost'] = $data['shipping_cost'];
        $purchase_data['discount'] = $data['discount_amount'];
        $purchase_data['grand_total'] = $data['total_payable'];
        $purchase_data['note'] = $data['note'] ?? null;


        $purchase = $this->model::create($purchase_data);

        $payment['id'] = $purchase->id;
        $payment['paid_amount'] = $data['paid'];
        $this->payment($payment);
        

        foreach ($data['lens_id'] as $key => $item) {
            $lens_purchase = [
                'lens_purchase_id' => $purchase->id,
                'lens_id'          => $item,
                'qty'              => $data['qty'][$key],
                'price'            => $data['cost'][$key],
            ];

            LensPurchaseItem::create($lens_purchase);
        }


        DB::commit();
        return $purchase;
        } catch (Exception $e) {
        DB::rollBack();
        dd(
            'Error: '.$e->getMessage(),
            'Line: '.$e->getLine()
        );
        }
    }
    function update($data,$id)
    {
        DB::beginTransaction();
        try {
            
        $purchase_data['user_id'] = auth()->user()->id;
        $purchase_data['lens_supplier_id'] = $data['supplier'];
        $purchase_data['chalan_no'] = $data['chalan_no'];
        $purchase_data['total_qty'] = array_sum($data['qty']);
        $purchase_data['total_price'] = $data['sub_total'];
        $purchase_data['shipping_cost'] = $data['shipping_cost'];
        $purchase_data['discount'] = $data['discount_amount'];
        $purchase_data['grand_total'] = $data['total_payable'];
        $purchase_data['note'] = $data['note'] ?? null;


        $purchase = $this->model::findOrFail($id);

        $purchase->update($purchase_data);
        $purchase->items()->delete();
        $purchase->payment()->delete();
        $purchase['paid_amount'] = $data['paid'];
        $payment['id'] = $purchase->id;
        $payment['paid_amount'] = $data['paid'];
        $this->payment($payment);
        foreach ($data['lens_id'] as $key => $item) {
            $lens_purchase = [
                'lens_purchase_id' => $purchase->id,
                'lens_id'          => $item,
                'qty'              => $data['qty'][$key],
                'price'            => $data['cost'][$key],
            ];

            LensPurchaseItem::create($lens_purchase);
        }


        DB::commit();
        return $purchase;
        } catch (Exception $e) {
        DB::rollBack();
        dd(
            'Error: '.$e->getMessage(),
            'Line: '.$e->getLine()
        );
        }
    }
    public function payment($data){
        if($data["paid_amount"] > 0){
            $payment['lens_purchase_id'] = $data["id"];
            $payment['amount'] = $data["paid_amount"];
            $payment['user_id'] = Auth::user()->id;
            LensPayment::create($payment);
        }
    }
}