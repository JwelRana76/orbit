<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DepartmentController extends Controller
{
    protected $model = Department::class;

    public function index()
    {
        $columns = $this->model::$columns;
        if (request()->ajax()) {
            $data = $this->model::all();

            return DataTables::of($data)
            ->addColumn('action', fn($item) => view('pages.department.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.department.index', compact('columns'));
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
                $message = ['success' => 'Department Inserted Successfully'];
            } else {
                $this->model::findOrFail($data['id'])->update([
                'name' => strtolower($data['name']),
                ]);
                $message = ['success' => 'Department Updated Successfully'];
            }
            DB::commit();
            return redirect()->route('department.index')->with($message);
        } catch (Exception $th) {
            DB::rollback();
            dd($th->getMessage());
        }
    }
    function edit($id)
    {
        $id = base64_decode($id);
        $department = $this->model::findOrFail($id);
        $columns = $this->model::$columns;
        if (request()->ajax()) {
            $data = $this->model::all();

            return DataTables::of($data)
            ->addColumn('action', fn($item) => view('pages.department.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.department.index', compact('columns', 'department'));
    }
    function delete($id)
    {
        $id = base64_decode($id);
        $this->model::findOrFail($id)->delete();
        return redirect()->route('department.index')->with('success', 'Department Deleted Successfully');
    }
}
