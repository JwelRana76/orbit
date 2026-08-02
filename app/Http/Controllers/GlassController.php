<?php

namespace App\Http\Controllers;

use App\Models\Glass;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class GlassController extends Controller
{
    protected $model = Glass::class;

    public function index()
    {
        $columns = $this->model::$columns;
        if (request()->ajax()) {
            $data = $this->model::where('is_active',true)->get();

            return DataTables::of($data)
            ->addColumn('stock', function ($item) {
                return $item->stock;
            })
            ->addColumn('action', fn($item) => view('pages.glass.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.glass.index', compact('columns'));
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
            $glass['name'] = $data['name'];
            $glass['company'] = $data['company'];
            $glass['cost'] = $data['cost'];
            $glass['price'] = $data['price'];
        if ($data['id'] == null) {
            $this->model::create($glass);
            $message = ['success' => 'Glass Inserted Successfully'];
        } else {
            $this->model::findOrFail($data['id'])->update($glass);
            $message = ['success' => 'Glass Updated Successfully'];
        }
        DB::commit();
        return redirect()->route('glass.index')->with($message);
        } catch (Exception $th) {
        DB::rollback();
        dd($th->getMessage());
        }
    }
    function edit($id)
    {
        $id = base64_decode($id);
        $item = $this->model::findOrFail($id);
        $columns = $this->model::$columns;
        if (request()->ajax()) {
            $data = $this->model::where('is_active',true)->get();
    
            return DataTables::of($data)
            ->addColumn('stock', function ($item) {
                return $item->stock;
            })
            ->addColumn('action', fn($item) => view('pages.glass.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.glass.index', compact('columns', 'item'));
    }
    function delete($id)
    {
        $id = base64_decode($id);
        $this->model::findOrFail($id)->update([
            'is_active' => 0,
        ]);
        return redirect()->route('glass.index')->with('success', 'Glass Deleted Successfully');
    }
}
