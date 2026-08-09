<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ExpenseController extends Controller
{
    protected $model = Expense::class;

    public function index()
    {
        $columns = $this->model::$columns;
        if (request()->ajax()) {
            $data = $this->model::orderBy('id','desc')->get();

            return DataTables::of($data)
            ->addColumn('date', function ($item) {
                return $item->created_at->format('d-M-y');
            })
            ->addColumn('action', fn($item) => view('pages.expense.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.expense.index', compact('columns'));
    }

    public function store(Request $request)
    {
        if ($request->id == null) {
            $request->validate([
                'purposes' => 'required',
            ]);
        }
        $data = $request->all();
        DB::beginTransaction();
        try {
            $expense['created_at'] = $data['date'];
            $expense['user_id'] = Auth::user()->id;
            $expense['purposes'] = $data['purposes'];
            $expense['amount'] = $data['amount'];
            $expense['note'] = $data['note'];
        if ($data['id'] == null) {
            $this->model::create($expense);
            $message = ['success' => 'Expense Inserted Successfully'];
        } else {
            $this->model::findOrFail($data['id'])->update($expense);
            $message = ['success' => 'Expense Updated Successfully'];
        }
        DB::commit();
        return redirect()->route('expense.index')->with($message);
        } catch (Exception $th) {
        DB::rollback();
        dd($th->getMessage());
        }
    }
    function edit($id)
    {
        $id = base64_decode($id);
        $expense = $this->model::findOrFail($id);
        $columns = $this->model::$columns;
        if (request()->ajax()) {
            $data = $this->model::orderBy('id','desc')->get();
    
            return DataTables::of($data)
            ->addColumn('date', function ($item) {
                return $item->created_at->format('d-M-y');
            })
            ->addColumn('action', fn($item) => view('pages.expense.action', compact('item'))->render())
            ->make(true);
        }
        return view('pages.expense.index', compact('columns', 'expense'));
    }
    function delete($id)
    {
        $id = base64_decode($id);
        $this->model::findOrFail($id)->delete();
        return redirect()->route('expense.index')->with('success', 'Expense Deleted Successfully');
    }
}
