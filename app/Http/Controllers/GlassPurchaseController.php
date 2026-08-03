<?php

namespace App\Http\Controllers;

use App\Models\Glass;
use App\Models\GlassPurchase;
use App\Models\GlassPurchasePayment;
use App\Models\GlassSupplier;
use App\Service\GlassPurchaseService;
use Illuminate\Http\Request;

class GlassPurchaseController extends Controller
{
    public function __construct()
    {
        $this->baseService = new GlassPurchaseService;
    }
    protected $model = GlassPurchase::class;

    public function index()
    {
        $columns = $this->model::$columns;
        $purchase = $this->baseService->Index();
        if (request()->ajax()) {
            return $purchase;
        }
        return view('pages.glass_purchase.index', compact('columns'));
    }
    public function create(){
        $supplier = GlassSupplier::where('status',true)->get();
        $glasses = Glass::where('is_active',true)->get();
        return view('pages.glass_purchase.create',compact('supplier','glasses'));
    }
    public function medicineFind($id){
        return Glass::findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $purchase = $this->baseService->store($data);
        return redirect()->route('glass.purchase.index')->with('success','Glass Purchases Successfully');
    }
    public function invoice($id){
        $purchase = GlassPurchase::findOrFail($id);
        return view('pages.glass_purchase.invoice',compact('purchase'));
    }
    function edit($id)
    {   $id = base64_decode($id);
        $supplier = GlassSupplier::where('status',true)->get();
        $purchase = GlassPurchase::findOrFail($id);
        $glasses = Glass::where('is_active',true)->get();
        return view('pages.glass_purchase.edit', compact('purchase','supplier','glasses'));
    }
    
    public function update(Request $request, $id){
        $data = $request->all();
        $this->baseService->update($data,$id);
        return redirect()->route('glass.purchase.index')->with('success','Glass Purchases Updated Successfully');
    }
    public function payment(Request $request){
        $data['paid_amount'] = $request->amount;
        $data['id'] = $request->purchase_id;
        $this->baseService->payment($data);
        return redirect()->route('glass.purchase.index')->with('success', 'Payment Success');
    }
    public function paymentDelete($id){
        $payment = GlassPurchasePayment::findOrFail($id)->delete();
        return back()->with('success','Glass Purchase Payment Deleted Successfully');
    }
    function delete($id)
    {
        $id = base64_decode($id);
        $this->model::findOrFail($id)->delete();
        return redirect()->route('glass.purchase.index')->with('success', 'Glass Purchase Deleted Successfully');
    }
}
