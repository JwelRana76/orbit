<?php

namespace App\Http\Controllers;

use App\Models\Lens;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class LensController extends Controller
{
    protected $model = Lens::class;

    public function index()
    {
        $columns = $this->model::$columns;
        if (request()->ajax()) {
            $data = $this->model::where('status',true)->get();

            return DataTables::of($data)
            ->addColumn('action', fn($item) => view('pages.lens.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.lens.index', compact('columns'));
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
            $lens['name'] = $data['name'];
            $lens['constant'] = $data['constant'];
            $lens['cost'] = $data['cost'];
            $lens['price'] = $data['price'];
            $lens['is_hospital_provider'] = isset($data['is_hospital_provided']) ? 1 : 0;
        // dd($lens);
        if ($data['id'] == null) {
            $this->model::create($lens);
            $message = ['success' => 'Lens Inserted Successfully'];
        } else {
            $this->model::findOrFail($data['id'])->update($lens);
            $message = ['success' => 'Lens Updated Successfully'];
        }
        DB::commit();
        return redirect()->route('lens.index')->with($message);
        } catch (Exception $th) {
        DB::rollback();
        dd($th->getMessage());
        }
    }
    function edit($id)
    {
        $id = base64_decode($id);
        $bed = $this->model::findOrFail($id);
        $columns = $this->model::$columns;
        if (request()->ajax()) {
            $data = $this->model::where('status',true)->get();

            return DataTables::of($data)
            ->addColumn('action', fn($item) => view('pages.lens.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.lens.index', compact('columns', 'bed'));
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
