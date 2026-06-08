<?php

namespace App\Http\Controllers;

use App\Models\BloodGroup;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class BloodGroupController extends Controller
{
    protected $model = BloodGroup::class;

    public function index()
    {
        $columns = $this->model::$columns;
        if (request()->ajax()) {
            $data = $this->model::all();

            return DataTables::of($data)
            ->addColumn('action', fn($item) => view('pages.blood_group.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.blood_group.index', compact('columns'));
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
            ]);
            $message = ['success' => 'Blood Group Inserted Successfully'];
        } else {
            $this->model::findOrFail($data['id'])->update([
            'name' => strtolower($data['name']),
            ]);
            $message = ['success' => 'Blood Group Updated Successfully'];
        }
        DB::commit();
        return redirect()->route('blood_group.index')->with($message);
        } catch (Exception $th) {
        DB::rollback();
        dd($th->getMessage());
        }
    }
    function edit($id)
    {
        $id = base64_decode($id);
        $blood_group = $this->model::findOrFail($id);
        $columns = $this->model::$columns;
        if (request()->ajax()) {
            $data = $this->model::all();

            return DataTables::of($data)
            ->addColumn('action', fn($item) => view('pages.blood_group.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.blood_group.index', compact('columns', 'blood_group'));
    }
    function delete($id)
    {
        $id = base64_decode($id);
        $this->model::findOrFail($id)->delete();
        return redirect()->route('blood_group.index')->with('success', 'Blood Group Deleted Successfully');
    }
}
