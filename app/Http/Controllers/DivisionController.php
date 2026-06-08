<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DivisionController extends Controller
{
    protected $model = Division::class;

    public function index()
    {
        $columns = Division::$columns;
        if (request()->ajax()) {
            $data = $this->model::all();

            return DataTables::of($data)
            ->addColumn('action', fn($item) => view('pages.division.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.division.index', compact('columns'));
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
                'code' => $data['code'],
                ]);
                $message = ['success' => 'Division Inserted Successfully'];
            } else {
                $this->model::findOrFail($data['id'])->update([
                'name' => strtolower($data['name']),
                'code' => $data['code'],
                ]);
                $message = ['success' => 'Division Updated Successfully'];
            }
            DB::commit();
            return redirect()->route('division.index')->with($message);
        } catch (Exception $th) {
            DB::rollback();
            dd($th->getMessage());
        }
    }
    public function divisionstore(Request $request)
    {
        // return $request->all();
        if ($request->id == null) {
            $request->validate([
                'name' => 'required',
                'code' => 'required|unique:divisions'
            ]);
        }
        $data = $request->all();
        DB::beginTransaction();
        try {
            if ($data['id'] == null) {
                $this->model::create([
                'name' => strtolower($data['name']),
                'code' => $data['code'],
                ]);
                $message = ['success' => 'Division Inserted Successfully'];
            } else {
                $this->model::findOrFail($data['id'])->update([
                'name' => strtolower($data['name']),
                'code' => $data['code'],
                ]);
                $message = ['success' => 'Division Updated Successfully'];
            }
            DB::commit();
            $divisions = Division::all();
            return $divisions;
        } catch (Exception $th) {
            DB::rollback();
            dd($th->getMessage());
        }
        
    }
    function edit($id)
    {
        $id = base64_decode($id);
        $division = $this->model::findOrFail($id);
        $columns = $this->model::$columns;
        if (request()->ajax()) {
            $data = $this->model::all();

            return DataTables::of($data)
            ->addColumn('action', fn($item) => view('pages.division.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.division.index', compact('columns', 'division'));
    }
    function delete($id)
    {
        $id = base64_decode($id);
        $this->model::findOrFail($id)->delete();
        return redirect()->route('division.index')->with('success', 'Division Deleted Successfully');
    }
}
