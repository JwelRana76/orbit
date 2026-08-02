<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class OtController extends Controller
{
    protected $model = Operation::class;

    public function index()
    {
        $columns = $this->model::$columns;
        if (request()->ajax()) {
            $data = $this->model::all();

            return DataTables::of($data)
            ->addColumn('status', function ($item) {
                return $item->status == 1
                    ? '<span class="badge bg-primary text-light">Active</span>'
                    : '<span class="badge bg-success text-light">Deactive</span>';
            })
            ->addColumn('action', fn($item) => view('pages.operation.action', compact('item'))->render())
            ->rawColumns(['action','status']) // Render HTML instead of escaping it
            ->make(true);
        }
        return view('pages.operation.index', compact('columns'));
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
            'name' => $data['name'],
            'charge' => $data['charge'],
            ]);
            $message = ['success' => 'Operation Inserted Successfully'];
        } else {
            $this->model::findOrFail($data['id'])->update([
            'name' => $data['name'],
            'charge' => $data['charge'],
            ]);
            $message = ['success' => 'Operation Updated Successfully'];
        }
        DB::commit();
        return redirect()->route('ot.index')->with($message);
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
            $data = $this->model::all();

            return DataTables::of($data)
            ->addColumn('status', function ($item) {
                return $item->status == 1
                    ? '<span class="badge bg-primary text-light">Active</span>'
                    : '<span class="badge bg-success text-light">Deactive</span>';
            })
            ->addColumn('action', fn($item) => view('pages.operation.action', compact('item'))->render())
            ->rawColumns(['action','status']) // Render HTML instead of escaping it
            ->make(true);
        }
        return view('pages.operation.index', compact('columns', 'item'));
    }
    function delete($id)
    {
        $id = base64_decode($id);
        $this->model::findOrFail($id)->update(['status'=>false]);
        return redirect()->route('ot.index')->with('success', 'Operation Deleted Successfully');
    }
}
