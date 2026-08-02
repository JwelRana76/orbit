<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\MedicinePayment;
use App\Models\MedicinePurchase;
use App\Models\MedicineSupplier;
use App\Service\MedicinePurchaseService;
use Illuminate\Http\Request;

class MedicinePurchaseController extends Controller
{
    public function __construct()
    {
        $this->baseService = new MedicinePurchaseService;
    }
    protected $model = MedicinePurchase::class;

    public function index()
    {
        $columns = $this->model::$columns;
        $purchase = $this->baseService->Index();
        if (request()->ajax()) {
            return $purchase;
        }
        return view('pages.medicine_purchase.index', compact('columns'));
    }
    public function create(){
        $supplier = MedicineSupplier::where('status',true)->get();
        $medicine = Medicine::where('is_active',true)->get();
        return view('pages.medicine_purchase.create',compact('supplier','medicine'));
    }
    public function medicineFind($id){
        return Medicine::findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $purchase = $this->baseService->store($data);
        return redirect()->route('medicine.purchase.index')->with('success','Medicine Purchases Successfully');
    }
    public function invoice($id){
        $purchase = MedicinePurchase::findOrFail($id);
        return view('pages.medicine_purchase.invoice',compact('purchase'));
    }
    function edit($id)
    {   $id = base64_decode($id);
        $supplier = MedicineSupplier::where('status',true)->get();
        $purchase = MedicinePurchase::findOrFail($id);
        $medicine = Medicine::where('is_active',true)->get();
        return view('pages.medicine_purchase.edit', compact('purchase','supplier','medicine'));
    }
    
    public function update(Request $request, $id){
        $data = $request->all();
        $this->baseService->update($data,$id);
        return redirect()->route('medicine.purchase.index')->with('success','Medicine Purchases Updated Successfully');
    }
    public function payment(Request $request){
        $data['paid_amount'] = $request->amount;
        $data['id'] = $request->purchase_id;
        $this->baseService->payment($data);
        return redirect()->route('medicine.purchase.index')->with('success', 'Payment Success');
    }
    public function paymentDelete($id){
        $payment = MedicinePayment::findOrFail($id)->delete();
        return back()->with('success','Medicine Purchase Payment Deleted Successfully');
    }
    function delete($id)
    {
        $id = base64_decode($id);
        $this->model::findOrFail($id)->delete();
        return redirect()->route('medicine.purchase.index')->with('success', 'Medicine Purchase Deleted Successfully');
    }
}
