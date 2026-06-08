<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Division;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DistrictController extends Controller
{
    protected $model = District::class;

    public function index()
    {
        $columns = $this->model::$columns;
        $division = Division::all();
        if (request()->ajax()) {
            $data = $this->model::all();

            return DataTables::of($data)
            ->addColumn('division', function ($item) {
                return optional($item->division)->name;
            })
            ->addColumn('action', fn($item) => view('pages.district.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.district.index', compact('columns','division'));
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
            'division_id' => $data['division_id'],
            ]);
            $message = ['success' => 'District Inserted Successfully'];
        } else {
            $this->model::findOrFail($data['id'])->update([
            'name' => strtolower($data['name']),
            'code' => $data['code'],
            'division_id' => $data['division_id'],
            ]);
            $message = ['success' => 'District Updated Successfully'];
        }
        DB::commit();
        return redirect()->route('district.index')->with($message);
        } catch (Exception $th) {
        DB::rollback();
        dd($th->getMessage());
        }
    }
    public function districtstore(Request $request)
    {
        // return $request->all();
        if ($request->id == null) {
            $request->validate([
                'name' => 'required',
                'code' => 'required|unique:districts'
            ]);
        }
        $data = $request->all();
        DB::beginTransaction();
        try {
            if ($data['id'] == null) {
                $this->model::create([
                'name' => strtolower($data['name']),
                'code' => $data['code'],
                'division_id' => $data['division_id'],
                ]);
                $message = ['success' => 'District Inserted Successfully'];
            } else {
                $this->model::findOrFail($data['id'])->update([
                'name' => strtolower($data['name']),
                'code' => $data['code'],
                'division_id' => $data['division_id'],
                ]);
                $message = ['success' => 'District Updated Successfully'];
            }
            DB::commit();
            $districts = District::all();
            return $districts;
        } catch (Exception $th) {
            DB::rollback();
            dd($th->getMessage());
        }
        
    }
    function edit($id)
    {
        $id = base64_decode($id);
        $district = $this->model::findOrFail($id);
        $columns = $this->model::$columns;
        $division = Division::all();
        if (request()->ajax()) {
            $data = $this->model::all();

            return DataTables::of($data)
            ->addColumn('division', function ($item) {
                return optional($item->division)->name;
            })
            ->addColumn('action', fn($item) => view('pages.district.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.district.index', compact('columns', 'district','division'));
    }
    function delete($id)
    {
        $id = base64_decode($id);
        $this->model::findOrFail($id)->delete();
        return redirect()->route('district.index')->with('success', 'District Deleted Successfully');
    }
}
