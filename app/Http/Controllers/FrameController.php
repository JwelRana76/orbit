<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class FrameController extends Controller
{
    protected $model = Frame::class;

    public function index()
    {
        $columns = $this->model::$columns;
        if (request()->ajax()) {
            $data = $this->model::where('is_active',true)->get();

            return DataTables::of($data)
            ->addColumn('stock', function ($item) {
                return $item->stock;
            })
            ->addColumn('action', fn($item) => view('pages.frame.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.frame.index', compact('columns'));
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
            $frame['company'] = $data['company'];
            $frame['cost'] = $data['cost'];
            $frame['price'] = $data['price'];
        if ($data['id'] == null) {
            $this->model::create($frame);
            $message = ['success' => 'Frame Inserted Successfully'];
        } else {
            $this->model::findOrFail($data['id'])->update($frame);
            $message = ['success' => 'Frame Updated Successfully'];
        }
        DB::commit();
        return redirect()->route('frame.index')->with($message);
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
            ->addColumn('action', fn($item) => view('pages.frame.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.frame.index', compact('columns', 'item'));
    }
    function delete($id)
    {
        $id = base64_decode($id);
        $this->model::findOrFail($id)->update([
            'is_active' => 0,
        ]);
        return redirect()->route('frame.index')->with('success', 'Frame Deleted Successfully');
    }
}
