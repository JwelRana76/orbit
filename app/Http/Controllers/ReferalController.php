<?php

namespace App\Http\Controllers;

use App\Models\Referal;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ReferalController extends Controller
{
    protected $model = Referal::class;

    public function index()
    {
        $columns = $this->model::$columns;
        if (request()->ajax()) {
            $data = $this->model::all();
            return DataTables::of($data)
            ->addColumn('action', fn($item) => view('pages.referal.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.referal.index', compact('columns'));
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
            $referal['name'] = $data['name'];
            $referal['contact'] = $data['contact'];
            $referal['address'] = $data['address'];
        if ($data['id'] == null) {
            $this->model::create($referal);
            $message = ['success' => 'Referal Inserted Successfully'];
        } else {
            $this->model::findOrFail($data['id'])->update($referal);
            $message = ['success' => 'Referal Updated Successfully'];
        }
        DB::commit();
        return redirect()->route('referal.index')->with($message);
        } catch (Exception $th) {
            DB::rollback();
            dd($th->getMessage());
        }
    }
    function edit($id)
    {
        $id = base64_decode($id);
        $referal = $this->model::findOrFail($id);
        $columns = $this->model::$columns;
        if (request()->ajax()) {
            $data = $this->model::all();

            return DataTables::of($data)
            ->addColumn('action', fn($item) => view('pages.referal.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.referal.index', compact('columns', 'referal'));
    }
    function delete($id)
    {
        $id = base64_decode($id);
        $this->model::findOrFail($id)->delete();
        return redirect()->route('referal.index')->with('success', 'Referal Deleted Successfully');
    }
}
