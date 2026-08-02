<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\MedicineSale;
use App\Service\MedicineSaleService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    protected $model = Customer::class;
    
    public function __construct()
    {
        $this->baseService = new MedicineSaleService;
    }

    public function index()
    {
        $columns = $this->model::$columns;
        if (request()->ajax()) {
            $data = $this->model::get();

            return DataTables::of($data)
            ->addColumn('due',function($item){
                return $item->due;
            })
            ->addColumn('action', fn($item) => view('pages.customer.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.customer.index', compact('columns'));
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
            $message = ['success' => 'Medicine Customer Inserted Successfully'];
        } else {
            $this->model::findOrFail($data['id'])->update($medicine);
            $message = ['success' => 'Medicine Customer Updated Successfully'];
        }
        DB::commit();
        return redirect()->route('medicine.customer.index')->with($message);
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
            $data = $this->model::get();
    
            return DataTables::of($data)
            ->addColumn('action', fn($item) => view('pages.customer.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.customer.index', compact('columns', 'data'));
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
        $purchase = MedicineSale::with('payment')
            ->where('customer_id', $data['customer_id'])
            ->orderBy('id', 'asc')
            ->get()
            ->filter(function ($item) {
                return $item->grand_total > $item->paid;
            })
            ->map(function ($item) {
                return [
                    'id'  => $item->id,
                    'due' => $item->grand_total - $item->paid,
                ];
            })
            ->values();
        foreach ($purchase as $key => $value) {
            $amount = $request->amount;
            while($amount > 0){
                if($amount > $value['due']){
                    $data['paid'] = $value['due'];
                    $data['id'] = $value['id'];
                    $amount -= $value['due'];
                }else{
                    $data['paid'] = $amount;
                    $data['id'] = $value['id'];
                    $amount = 0;;
                }
                $this->baseService->payment($data);
            }
        }
        return back()->with('success','Customer Payment Completed');
        
    }
    function paymentDetails($id){
        $purchases = MedicineSale::join(
            'sale_payments',
            'medicine_sales.id',
            '=',
            'sale_payments.medicine_sale_id'
        )
        ->select('sale_payments.*')
        ->where('medicine_sales.customer_id', $id)
        ->orderBy('sale_payments.id','desc')
        ->get();
        return $purchases;
    }
}
