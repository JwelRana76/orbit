<?php

namespace App\Http\Controllers;

use App\Models\Gender;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class GenderController extends Controller
{
    protected $model = Gender::class;

    public function index()
    {
        $columns = $this->model::$columns;
        if (request()->ajax()) {
            $data = $this->model::all();

            return DataTables::of($data)
            ->addColumn('action', fn($item) => view('pages.gender.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.gender.index', compact('columns'));
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
            $message = ['success' => 'Gender Inserted Successfully'];
        } else {
            $this->model::findOrFail($data['id'])->update([
            'name' => strtolower($data['name']),
            ]);
            $message = ['success' => 'Gender Updated Successfully'];
        }
        DB::commit();
        return redirect()->route('gender.index')->with($message);
        } catch (Exception $th) {
        DB::rollback();
        dd($th->getMessage());
        }
    }
    function edit($id)
    {
        $id = base64_decode($id);
        $gender = $this->model::findOrFail($id);
        $columns = $this->model::$columns;
        if (request()->ajax()) {
            $data = $this->model::all();

            return DataTables::of($data)
            ->addColumn('action', fn($item) => view('pages.gender.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.gender.index', compact('columns', 'gender'));
    }
    function delete($id)
    {
        $id = base64_decode($id);
        $this->model::findOrFail($id)->delete();
        return redirect()->route('gender.index')->with('success', 'Gender Deleted Successfully');
    }
}
