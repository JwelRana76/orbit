<?php

namespace App\Http\Controllers;

use App\Models\Bed;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class BedController extends Controller
{
    protected $model = Bed::class;

    public function index()
    {
        $columns = $this->model::$columns;
        if (request()->ajax()) {
            $data = $this->model::all();

            return DataTables::of($data)
            ->addColumn('type', function ($item) {
                return $item->type == 0
                    ? '<span class="badge bg-primary text-light">Cabin</span>'
                    : '<span class="badge bg-success text-light">Ward</span>';
            })
            ->addColumn('status', function ($item) {
                return $item->status == 0
                    ? '<span class="badge bg-primary text-light">Available</span>'
                    : '<span class="badge bg-danger text-light">Bocked</span>';
            })
            ->addColumn('action', fn($item) => view('pages.bed.action', compact('item'))->render())
            ->rawColumns(['type', 'action','status']) // Render HTML instead of escaping it
            ->make(true);
        }
        return view('pages.bed.index', compact('columns'));
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
            'type' => $data['type'],
            ]);
            $message = ['success' => 'Bed Inserted Successfully'];
        } else {
            $this->model::findOrFail($data['id'])->update([
            'name' => strtolower($data['name']),
            'type' => $data['type'],
            ]);
            $message = ['success' => 'Bed Updated Successfully'];
        }
        DB::commit();
        return redirect()->route('bed.index')->with($message);
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
            $data = $this->model::all();

            return DataTables::of($data)
            ->addColumn('type', function ($item) {
                return $item->type == 0
                    ? '<span class="badge bg-primary text-light">Cabin</span>'
                    : '<span class="badge bg-success text-light">Ward</span>';
            })
            ->addColumn('status', function ($item) {
                return $item->status == 0
                    ? '<span class="badge bg-primary text-light">Available</span>'
                    : '<span class="badge bg-danger text-light">Bocked</span>';
            })
            ->addColumn('action', fn($item) => view('pages.bed.action', compact('item'))->render())
            ->rawColumns(['type', 'action','status']) // Render HTML instead of escaping it
            ->make(true);
        }
        return view('pages.bed.index', compact('columns', 'bed'));
    }
    function delete($id)
    {
        $id = base64_decode($id);
        $this->model::findOrFail($id)->delete();
        return redirect()->route('bed.index')->with('success', 'Blood Group Deleted Successfully');
    }
}
