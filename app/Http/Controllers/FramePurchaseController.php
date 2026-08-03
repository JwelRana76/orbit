<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use App\Models\FramePurchase;
use App\Models\FramePurchasePayment;
use App\Models\FrameSupplier;
use App\Service\FramePurchaseService;
use Illuminate\Http\Request;

class FramePurchaseController extends Controller
{
    public function __construct()
    {
        $this->baseService = new FramePurchaseService;
    }
    protected $model = FramePurchase::class;

    public function index()
    {
        $columns = $this->model::$columns;
        $purchase = $this->baseService->Index();
        if (request()->ajax()) {
            return $purchase;
        }
        return view('pages.frame_purchase.index', compact('columns'));
    }
    public function create(){
        $supplier = FrameSupplier::where('status',true)->get();
        $frames = Frame::where('is_active',true)->get();
        return view('pages.frame_purchase.create',compact('supplier','frames'));
    }
    public function medicineFind($id){
        return Frame::findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $purchase = $this->baseService->store($data);
        return redirect()->route('frame.purchase.index')->with('success','Frame Purchases Successfully');
    }
    public function invoice($id){
        $purchase = FramePurchase::findOrFail($id);
        return view('pages.frame_purchase.invoice',compact('purchase'));
    }
    function edit($id)
    {   $id = base64_decode($id);
        $supplier = FrameSupplier::where('status',true)->get();
        $purchase = FramePurchase::findOrFail($id);
        $frames = Frame::where('is_active',true)->get();
        return view('pages.frame_purchase.edit', compact('purchase','supplier','frames'));
    }
    
    public function update(Request $request, $id){
        $data = $request->all();
        $this->baseService->update($data,$id);
        return redirect()->route('frame.purchase.index')->with('success','Frame Purchases Updated Successfully');
    }
    public function payment(Request $request){
        $data['paid_amount'] = $request->amount;
        $data['id'] = $request->purchase_id;
        $this->baseService->payment($data);
        return redirect()->route('frame.purchase.index')->with('success', 'Payment Success');
    }
    public function paymentDelete($id){
        $payment = FramePurchasePayment::findOrFail($id)->delete();
        return back()->with('success','Frame Purchase Payment Deleted Successfully');
    }
    function delete($id)
    {
        $id = base64_decode($id);
        $this->model::findOrFail($id)->delete();
        return redirect()->route('frame.purchase.index')->with('success', 'Frame Purchase Deleted Successfully');
    }
}
