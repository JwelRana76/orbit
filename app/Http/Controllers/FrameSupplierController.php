<?php

namespace App\Http\Controllers;

use App\Models\FramePurchase;
use App\Models\FrameSupplier;
use App\Service\FramePurchaseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class FrameSupplierController extends Controller
{
    protected $model = FrameSupplier::class;
    public function __construct()
    {
        $this->baseService = new FramePurchaseService;
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
            ->addColumn('action', fn($item) => view('pages.frame_supplier.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.frame_supplier.index', compact('columns'));
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
            $frame['name'] = $data['name'];
            $frame['contact'] = $data['contact'];
            $frame['address'] = $data['address'];
        if ($data['id'] == null) {
            $this->model::create($frame);
            $message = ['success' => 'Frame Supplier Inserted Successfully'];
        } else {
            $this->model::findOrFail($data['id'])->update($frame);
            $message = ['success' => 'Frame Supplier Updated Successfully'];
        }
        DB::commit();
        return redirect()->route('frame.supplier.index')->with($message);
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
            ->addColumn('due',function($item){
                return $item->due;
            })
            ->addColumn('action', fn($item) => view('pages.frame_supplier.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.frame_supplier.index', compact('columns', 'data'));
    }
    function delete($id)
    {
        $id = base64_decode($id);
        $this->model::findOrFail($id)->update([
            'status' => 0,
        ]);
        return redirect()->route('frame.supplier.index')->with('success', 'Frame Supplier Deleted Successfully');
    }

    function payment(Request $request){
        $data = $request->all();
        $purchase = FramePurchase::with('payment')
            ->where('frame_supplier_id', $data['supplier_id'])
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
        $purchases = FramePurchase::join(
            'frame_purchase_payments',
            'frame_purchases.id',
            '=',
            'frame_purchase_payments.frame_purchase_id'
        )
        ->select('frame_purchase_payments.*')
        ->where('frame_purchases.frame_supplier_id', $id)
        ->orderBy('frame_purchase_payments.id','desc')
        ->get();
        return $purchases;
    }
}
