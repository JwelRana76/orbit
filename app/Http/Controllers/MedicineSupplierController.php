<?php

namespace App\Http\Controllers;

use App\Models\MedicinePurchase;
use App\Models\MedicineSupplier;
use App\Service\MedicinePurchaseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MedicineSupplierController extends Controller
{
    protected $model = MedicineSupplier::class;
    public function __construct()
    {
        $this->baseService = new MedicinePurchaseService;
    }

    public function index()
    {
        $columns = $this->model::$columns;
        if (request()->ajax()) {
            $data = $this->model::where('status',true)->get();

            return DataTables::of($data)
            ->addColumn('due',function($item){
                return $item->due;
            })
            ->addColumn('action', fn($item) => view('pages.medicine_supplier.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.medicine_supplier.index', compact('columns'));
    }

    public function store(Request $request)
    {
        if ($request->id == null) {
            $request->validate([
                'name' => 'required',
            ]);
        }
        $data = $request->all();
        DB::beginTransaction();
        try {
            $medicine['name'] = $data['name'];
            $medicine['contact'] = $data['contact'];
            $medicine['address'] = $data['address'];
        if ($data['id'] == null) {
            $this->model::create($medicine);
            $message = ['success' => 'Medicine Supplier Inserted Successfully'];
        } else {
            $this->model::findOrFail($data['id'])->update($medicine);
            $message = ['success' => 'Medicine Supplier Updated Successfully'];
        }
        DB::commit();
        return redirect()->route('medicine.supplier.index')->with($message);
        } catch (Exception $th) {
        DB::rollback();
        dd($th->getMessage());
        }
    }
    function edit($id)
    {
        $id = base64_decode($id);
        $data = $this->model::findOrFail($id);
        $columns = $this->model::$columns;
        if (request()->ajax()) {
            $data = $this->model::where('status',true)->get();
    
            return DataTables::of($data)
            ->addColumn('action', fn($item) => view('pages.medicine_supplier.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.medicine_supplier.index', compact('columns', 'data'));
    }
    function delete($id)
    {
        $id = base64_decode($id);
        $this->model::findOrFail($id)->update([
            'status' => 0,
        ]);
        return redirect()->route('medicine.supplier.index')->with('success', 'Medicine Supplier Deleted Successfully');
    }

    function payment(Request $request){
        $data = $request->all();
        $purchase = MedicinePurchase::with('payment')
            ->where('medicine_supplier_id', $data['supplier_id'])
            ->orderBy('id', 'asc')
            ->get()
            ->filter(function ($item) {
                return $item->grand_total > $item->paid_amount;
            })
            ->map(function ($item) {
                return [
                    'id'  => $item->id,
                    'due' => $item->grand_total - $item->paid_amount,
                ];
            })
            ->values();
        foreach ($purchase as $key => $value) {
            $amount = $request->amount;
            while($amount > 0){
                if($amount > $value['due']){
                    $data['paid_amount'] = $value['due'];
                    $data['id'] = $value['id'];
                    $amount -= $value['due'];
                }else{
                    $data['paid_amount'] = $amount;
                    $data['id'] = $value['id'];
                    $amount = 0;;
                }
                $this->baseService->payment($data);
            }
        }
        return back()->with('success','Supplier Payment Completed');
        
    }
    function paymentDetails($id){
        $purchases = MedicinePurchase::join(
            'medicine_payments',
            'medicine_purchases.id',
            '=',
            'medicine_payments.medicine_purchase_id'
        )
        ->select('medicine_payments.*')
        ->where('medicine_purchases.medicine_supplier_id', $id)
        ->orderBy('medicine_payments.id','desc')
        ->get();
        return $purchases;
    }
}
