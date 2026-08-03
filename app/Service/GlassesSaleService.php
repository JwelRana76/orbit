<?php

namespace App\Service;

use App\Models\FrameSaleItem;
use App\Models\GlassesSale;
use App\Models\GlassesSalePayment;
use App\Models\GlassSaleItem;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class GlassesSaleService {

    protected $model = GlassesSale::class;
    
    function saleid()
    {
        $sale = $this->model::orderBy('id', 'desc')->first();
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
            return $item->name . '<br>' .
            $item->phone;
        })
        ->addColumn('paid', function ($item) {
            return $item->paid;
        })
        ->addColumn('total', function ($item) {
            return $item->total_price;
        })
        ->addColumn('change', function ($item) {
            return $item->return;
        })
        ->addColumn('action', fn ($item) => view('pages.glasses_sale.action', compact('item'))->render())
        ->rawColumns(['action','customer'])
        ->make(true);
    }
    function store($data)
    {
        DB::beginTransaction();
        try {
            // dd($data);
            $sale_data['user_id'] = auth()->user()->id;
            $sale_data['name'] = $data['customer'];
            $sale_data['phone'] = $data['phone'];
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
            
            if (isset($data['glass_id'])) {
                foreach ($data['glass_id'] as $key => $item) {
                    $glass_sale = [
                        'glasses_sale_id' => $sale->id,
                        'glass_id'          => $item,
                        'qty'              => $data['qty'][$key],
                        'price'            => $data['glass_price'][$key],
                    ];

                    GlassSaleItem::create($glass_sale);
                }
            }
            if (isset($data['frame_id'])) {
                foreach ($data['frame_id'] as $key => $item) {
                    $frame_sale = [
                        'glasses_sale_id' => $sale->id,
                        'frame_id'          => $item,
                        'qty'              => $data['qty'][$key],
                        'price'            => $data['frame_price'][$key],
                    ];

                    FrameSaleItem::create($frame_sale);
                }
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
            
            $sale_data['user_id'] = auth()->user()->id;
            $sale_data['name'] = $data['customer'];
            $sale_data['phone'] = $data['phone'];
            $sale_data['total_qty'] = array_sum($data['qty']);
            $sale_data['total_price'] = $data['sub_total'];
            $sale_data['discount_percent'] = $data['discount_percent'];
            $sale_data['discount'] = $data['discount_amount'];
            $sale_data['grand_total'] = $data['total_payable'];
            $sale_data['changes'] = $data['change'];
            $sale_data['note'] = $data['note'] ?? null;


            $sale = $this->model::findOrFail($id);

            $sale->update($sale_data);
            $sale->glass()->delete();
            $sale->frame()->delete();
            $sale->payment()->delete();
            $payment['id'] = $sale->id;
            $payment['paid'] = $data['paid'];
            $this->payment($payment);

            if (isset($data['glass_id'])) {
                foreach ($data['glass_id'] as $key => $item) {
                    $glass_sale = [
                        'glasses_sale_id' => $sale->id,
                        'glass_id'          => $item,
                        'qty'              => $data['qty'][$key],
                        'price'            => $data['glass_price'][$key],
                    ];

                    GlassSaleItem::create($glass_sale);
                }
            }
            if (isset($data['frame_id'])) {
                foreach ($data['frame_id'] as $key => $item) {
                    $frame_sale = [
                        'glasses_sale_id' => $sale->id,
                        'frame_id'          => $item,
                        'qty'              => $data['qty'][$key],
                        'price'            => $data['frame_price'][$key],
                    ];

                    FrameSaleItem::create($frame_sale);
                }
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
            $payment['glasses_sale_id'] = $data["id"];
            $payment['amount'] = $data["paid"];
            $payment['user_id'] = Auth::user()->id;
            GlassesSalePayment::create($payment);
        }
    }
}