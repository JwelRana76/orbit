<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use App\Models\Glass;
use App\Models\GlassesSale;
use App\Models\GlassesSalePayment;
use App\Service\GlassesSaleService;
use Illuminate\Http\Request;

class GlassesSaleController extends Controller
{
    public function __construct()
    {
        $this->baseService = new GlassesSaleService;
    }
    protected $model = GlassesSale::class;

    public function index()
    {
        $columns = $this->model::$columns;
        $sale = $this->baseService->Index();
        if (request()->ajax()) {
            return $sale;
        }
        return view('pages.glasses_sale.index', compact('columns'));
    }
    public function create(){
        $glass = Glass::where('is_active', true)
        ->get()
        ->filter(function ($item) {
            return $item->stock > 0;
        })
        ->values();
        $frame = Frame::where('is_active', true)
        ->get()
        ->filter(function ($item) {
            return $item->stock > 0;
        })
        ->values();
        return view('pages.glasses_sale.create',compact('glass','frame'));
    }
    public function glass($id){
        return Glass::findOrFail($id)->append('stock');
    }
    public function frame($id){
        return Frame::findOrFail($id)->append('stock');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $sale = $this->baseService->store($data);
        return redirect()
        ->route('glasses.sale.create')
        ->with('success', 'Medicine sales successfully.')
        ->with('invoice_id', $sale->id);
    }
    public function invoice($id){
        $sale = GlassesSale::findOrFail($id);
        return view('pages.glasses_sale.invoice_pos',compact('sale'));
    }
    function edit($id)
    {   $id = base64_decode($id);
        $sale = GlassesSale::findOrFail($id);
        $glass = Glass::where('is_active',true)->get();
        $frame = Frame::where('is_active',true)->get();
        return view('pages.glasses_sale.edit', compact('sale','glass','frame'));
    }
    
    public function update(Request $request, $id){
        $data = $request->all();
        $sale = $this->baseService->update($data,$id);
        return redirect()
        ->route('glasses.sale.create')
        ->with('success', 'Glasses Sales Update successfully.')
        ->with('invoice_id', $sale->id);
    }
    public function payment(Request $request){
        $data['paid'] = $request->amount;
        $data['id'] = $request->sale_id;
        $this->baseService->payment($data);
        return redirect()->route('glasses.sale.index')->with('success', 'Payment Success');
    }
    public function paymentDelete($id){
        $payment = GlassesSalePayment::findOrFail($id)->delete();
        return back()->with('success','Glasses sale Payment Deleted Successfully');
    }
    function delete($id)
    {
        $id = base64_decode($id);
        $this->model::findOrFail($id)->delete();
        return redirect()->route('glasses.sale.index')->with('success', 'Glasses sale Deleted Successfully');
    }
}
