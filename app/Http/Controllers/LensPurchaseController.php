<?php

namespace App\Http\Controllers;

use App\Models\Lens;
use App\Models\LensPurchase;
use App\Models\LensSupplier;
use App\Service\LensPurchaseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class LensPurchaseController extends Controller
{
    public function __construct()
    {
        $this->baseService = new LensPurchaseService;
    }
    protected $model = LensPurchase::class;

    public function index()
    {
        $columns = $this->model::$columns;
        $purchase = $this->baseService->Index();
        if (request()->ajax()) {
            return $purchase;
        }
        return view('pages.lens_purchase.index', compact('columns'));
    }
    public function create(){
        $supplier = LensSupplier::where('status',true)->get();
        $lens = Lens::where('status',true)->where('is_hospital_provider',true)->get();
        return view('pages.lens_purchase.create',compact('supplier','lens'));
    }
    public function lensFind($id){
        return Lens::findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $purchase = $this->baseService->store($data);
        return redirect()->route('lens.purchase.index')->with('success','Len Purchases Successfully');
    }
    public function invoice($id){
        $purchase = LensPurchase::findOrFail($id);
        return view('pages.lens_purchase.invoice',compact('purchase'));
    }
    function edit($id)
    {   $id = base64_decode($id);
        $supplier = LensSupplier::where('status',true)->get();
        $purchase = LensPurchase::findOrFail($id);
        $lens = Lens::where('status',true)->where('is_hospital_provider',true)->get();
        return view('pages.lens_purchase.edit', compact('purchase','supplier','lens'));
    }
    
    public function update(Request $request, $id){
        $data = $request->all();
        $purchase = $this->baseService->update($data,$id);
        return redirect()->route('lens.purchase.index')->with('success','Len Purchases Updated Successfully');
    }
    public function payment(Request $request){
        $data['paid_amount'] = $request->amount;
        $data['id'] = $request->purchase_id;
        $this->baseService->payment($data);
        return redirect()->route('lens.purchase.index')->with('success', 'Payment Success');
    }
    function delete($id)
    {
        $id = base64_decode($id);
        $this->model::findOrFail($id)->delete();
        return redirect()->route('lens.purchase.index')->with('success', 'Lens Deleted Successfully');
    }
}
