<?php

namespace App\Service;

use App\Models\LenProvideItem;
use App\Models\LensProvider;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class LensProviderService {
    protected $model = LensProvider::class;

    function index()
    {
        $provider = $this->model::orderBy('id', 'desc')->get();
        return DataTables::of($provider)
        ->addColumn('date', function ($item) {
            return $item->created_at->format('d-M-Y');
        })
        ->addColumn('action', fn ($item) => view('pages.lens_provider.action', compact('item'))->render())
        ->make(true);
    }
    function store($data)
    {
        DB::beginTransaction();
        try {
            
        $purchase_data['user_id'] = auth()->user()->id;
        $purchase_data['provider'] = $data['provider'];
        $purchase_data['total_qty'] = array_sum($data['qty']);
        $purchase_data['company'] = $data['company'];
        $purchase_data['note'] = $data['note'] ?? null;


        $provider = $this->model::create($purchase_data);

        

        foreach ($data['lens_id'] as $key => $item) {
            $lens_purchase = [
                'lens_provider_id' => $provider->id,
                'lens_id'          => $item,
                'qty'              => $data['qty'][$key],
            ];

            LenProvideItem::create($lens_purchase);
        }


        DB::commit();
        return $provider;
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
        $purchase_data['provider'] = $data['provider'];
        $purchase_data['total_qty'] = array_sum($data['qty']);
        $purchase_data['company'] = $data['company'];
        $purchase_data['note'] = $data['note'] ?? null;


        $purchase = $this->model::findOrFail($id);

        $purchase->update($purchase_data);
        $purchase->items()->delete();
        
        foreach ($data['lens_id'] as $key => $item) {
            $lens_purchase = [
                'lens_provider_id' => $purchase->id,
                'lens_id'          => $item,
                'qty'              => $data['qty'][$key],
            ];

            LenProvideItem::create($lens_purchase);
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
}