<?php

namespace App\Http\Controllers;

use App\Models\LensSupplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class LensSupplierController extends Controller
{
    protected $model = LensSupplier::class;

    public function index()
    {
        $columns = $this->model::$columns;
        if (request()->ajax()) {
            $data = $this->model::where('status',true)->get();

            return DataTables::of($data)
            ->addColumn('action', fn($item) => view('pages.lens_supplier.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.lens_supplier.index', compact('columns'));
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
        if ($data['id'] == null) {
            $this->model::create([
            'name' => strtolower($data['name']),
            'contact' => $data['contact'],
            'address' => $data['address'],
            ]);
            $message = ['success' => 'Lens Inserted Successfully'];
        } else {
            $this->model::findOrFail($data['id'])->update([
            'name' => strtolower($data['name']),
            'contact' => $data['contact'],
            'address' => $data['address'],
            ]);
            $message = ['success' => 'Lens Updated Successfully'];
        }
        DB::commit();
        return redirect()->route('lens.supplier.index')->with($message);
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
            ->addColumn('action', fn($item) => view('pages.lens_supplier.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.lens_supplier.index', compact('columns', 'data'));
    }
    public function update(Request $request, $id){
        
    }
    function delete($id)
    {
        $id = base64_decode($id);
        $this->model::findOrFail($id)->update([
            'status' => 0,
        ]);
        return redirect()->route('lens.index')->with('success', 'Lens Deleted Successfully');
    }
}
