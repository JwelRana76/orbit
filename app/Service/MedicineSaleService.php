<?php

namespace App\Service;

use App\Models\Medicine;
use App\Models\MedicineSale;
use App\Models\MedicineSaleItem;
use App\Models\SalePayment;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MedicineSaleService {

    protected $model = MedicineSale::class;
    
    function saleid()
    {
        $sale = MedicineSale::orderBy('id', 'desc')->first();
        if ($sale) {
        $saleid = $sale->saleid;
        $ext = explode('-', $saleid)[0];
        if ($ext < 10) {
            $saleid = '000' . $ext + 1;
        } elseif ($ext < 100) {
            $saleid = '00' . $ext + 1;
        } elseif ($ext < 1000) {
            $saleid = '0' . $ext + 1;
        } else {
            $saleid = '-' . $ext + 1;
        }
        } else {
        $saleid = '0001';
        }
        return $saleid;
    }
    
    function index()
    {
        $purchase = $this->model::orderBy('id', 'desc')->withSum('payment', 'amount')->get();
        return DataTables::of($purchase)
        ->addColumn('date', function ($item) {
            return $item->created_at->format('d-M-Y');
        })
        ->addColumn('customer', function ($item) {
            return $item->customer->name . '<br>' .
            $item->customer->contact . '<br>' .
            $item->customer->address;
        })
        ->addColumn('paid', function ($item) {
            return $item->paid;
        })
        ->addColumn('total', function ($item) {
            return $item->total_price;
        })
        ->addColumn('due', function ($item) {
            return $item->grand_total - $item->paid;
        })
        ->addColumn('action', fn ($item) => view('pages.medicine_sale.action', compact('item'))->render())
        ->rawColumns(['action','customer'])
        ->make(true);
    }
    function store($data)
    {
        DB::beginTransaction();
        try {
            // dd($data);
            $sale_data['user_id'] = auth()->user()->id;
            $sale_data['customer_id'] = $data['customer'];
            $sale_data['saleid'] = $this->saleid();
            $sale_data['total_qty'] = array_sum($data['qty']);
            $sale_data['total_price'] = $data['sub_total'];
            $sale_data['discount_percent'] = $data['discount_percent'];
            $sale_data['discount'] = $data['discount_amount'];
            $sale_data['grand_total'] = $data['total_payable'];
            $sale_data['changes'] = $data['change'];
            $sale_data['note'] = $data['note'] ?? null;


            $sale = $this->model::create($sale_data);

            $payment['id'] = $sale->id;
            $payment['paid'] = $data['paid'];
            $this->payment($payment);
            

            foreach ($data['medicine_id'] as $key => $item) {
                $medicine_sale = [
                    'medicine_sale_id' => $sale->id,
                    'medicine_id'          => $item,
                    'qty'              => $data['qty'][$key],
                    'price'            => $data['price'][$key],
                ];

                MedicineSaleItem::create($medicine_sale);
            }


            DB::commit();
            return $sale;
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
            
            $sale_data['customer_id'] = $data['customer'];
            $sale_data['total_qty'] = array_sum($data['qty']);
            $sale_data['total_price'] = $data['sub_total'];
            $sale_data['discount_percent'] = $data['discount_percent'];
            $sale_data['discount'] = $data['discount_amount'];
            $sale_data['grand_total'] = $data['total_payable'];
            $sale_data['changes'] = $data['change'];
            $sale_data['note'] = $data['note'] ?? null;


            $sale = $this->model::findOrFail($id);

            $sale->update($sale_data);
            $sale->items()->delete();
            $sale->payment()->delete();
            $payment['id'] = $sale->id;
            $payment['paid'] = $data['paid'];
            $this->payment($payment);
            foreach ($data['medicine_id'] as $key => $item) {
                $medicine_sale = [
                    'medicine_sale_id' => $sale->id,
                    'medicine_id'          => $item,
                    'qty'              => $data['qty'][$key],
                    'price'            => $data['price'][$key],
                ];

                MedicineSaleItem::create($medicine_sale);
            }


            DB::commit();
            return $sale;
        } catch (Exception $e) {
        DB::rollBack();
        dd(
            'Error: '.$e->getMessage(),
            'Line: '.$e->getLine()
        );
        }
    }
    public function payment($data){
        if($data["paid"] > 0){
            $payment['medicine_sale_id'] = $data["id"];
            $payment['amount'] = $data["paid"];
            $payment['user_id'] = Auth::user()->id;
            SalePayment::create($payment);
        }
    }

}