<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Medicine;
use App\Models\MedicineSale;
use App\Models\SalePayment;
use App\Service\MedicinePurchaseService;
use App\Service\MedicineSaleService;
use Illuminate\Http\Request;

class MedicineSaleController extends Controller
{
    public function __construct()
    {
        $this->baseService = new MedicineSaleService;
    }
    protected $model = MedicineSale::class;

    public function index()
    {
        $columns = $this->model::$columns;
        $sale = $this->baseService->Index();
        if (request()->ajax()) {
            return $sale;
        }
        return view('pages.medicine_sale.index', compact('columns'));
    }
    public function create(){
        $customers = Customer::get();
        $medicine = Medicine::where('is_active', true)
        ->get()
        ->filter(function ($item) {
            return $item->stock > 0;
        })
        ->values();
        return view('pages.medicine_sale.create',compact('customers','medicine'));
    }
    public function medicineFind($id){
        return Medicine::findOrFail($id)->append('stock');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $sale = $this->baseService->store($data);
        return redirect()
        ->route('medicine.sale.create')
        ->with('success', 'Medicine sales successfully.')
        ->with('invoice_id', $sale->id);
    }
    public function invoice($id){
        $sale = Medicinesale::findOrFail($id);
        return view('pages.medicine_sale.invoice_pos',compact('sale'));
    }
    function edit($id)
    {   $id = base64_decode($id);
        $customer = Customer::get();
        $sale = Medicinesale::findOrFail($id);
        $medicine = Medicine::where('is_active',true)->get();
        return view('pages.medicine_sale.edit', compact('sale','customer','medicine'));
    }
    
    public function update(Request $request, $id){
        $data = $request->all();
        $sale = $this->baseService->update($data,$id);
        return redirect()
        ->route('medicine.sale.create')
        ->with('success', 'Medicine Sales Update successfully.')
        ->with('invoice_id', $sale->id);
    }
    public function payment(Request $request){
        $data['paid'] = $request->amount;
        $data['id'] = $request->sale_id;
        $this->baseService->payment($data);
        return redirect()->route('medicine.sale.index')->with('success', 'Payment Success');
    }
    public function paymentDelete($id){
        $payment = SalePayment::findOrFail($id)->delete();
        return back()->with('success','Medicine sale Payment Deleted Successfully');
    }
    function delete($id)
    {
        $id = base64_decode($id);
        $this->model::findOrFail($id)->delete();
        return redirect()->route('medicine.sale.index')->with('success', 'Medicine sale Deleted Successfully');
    }
}
