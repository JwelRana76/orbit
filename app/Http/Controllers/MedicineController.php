<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MedicineController extends Controller
{
    protected $model = Medicine::class;

    public function index()
    {
        $columns = $this->model::$columns;
        if (request()->ajax()) {
            $data = $this->model::where('is_active',true)->get();

            return DataTables::of($data)
            ->addColumn('stock', function ($item) {
                return $item->stock;
            })
            ->addColumn('action', fn($item) => view('pages.medicine.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.medicine.index', compact('columns'));
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
            $medicine['type'] = $data['type'];
            $medicine['group'] = $data['group'];
            $medicine['company'] = $data['company'];
            $medicine['cost'] = $data['cost'];
            $medicine['price'] = $data['price'];
        if ($data['id'] == null) {
            $this->model::create($medicine);
            $message = ['success' => 'Medicine Inserted Successfully'];
        } else {
            $this->model::findOrFail($data['id'])->update($medicine);
            $message = ['success' => 'Medicine Updated Successfully'];
        }
        DB::commit();
        return redirect()->route('medicine.index')->with($message);
        } catch (Exception $th) {
        DB::rollback();
        dd($th->getMessage());
        }
    }
    function edit($id)
    {
        $id = base64_decode($id);
        $medicine = $this->model::findOrFail($id);
        $columns = $this->model::$columns;
        if (request()->ajax()) {
            $data = $this->model::where('is_active',true)->get();
    
            return DataTables::of($data)
            ->addColumn('stock', function ($item) {
                return $item->stock;
            })
            ->addColumn('action', fn($item) => view('pages.medicine.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.medicine.index', compact('columns', 'medicine'));
    }
    function delete($id)
    {
        $id = base64_decode($id);
        $this->model::findOrFail($id)->update([
            'is_active' => 0,
        ]);
        return redirect()->route('medicine.index')->with('success', 'Medicine Deleted Successfully');
    }
}
