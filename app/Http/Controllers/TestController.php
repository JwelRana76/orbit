<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Service\TestService;

class TestController extends Controller
{
    public function __construct()
    {
        $this->baseService = new TestService;
    }
    public function index()
    {
        $item = $this->baseService->Index();
        $columns = Test::$columns;
        if (request()->ajax()) {
            return $item;
        }
        return view('pages.test.index', compact('columns'));
    }

    public function store(Request $request)
    {
        if ($request->id == null) {
            $request->validate([
                'name' => 'required',
            ]);
        }
        $data = $request->all();
        $message = $this->baseService->create($data);
        return redirect()->route('test.index')->with($message);
    }
    function edit($id)
    {
        $id = base64_decode($id);
        $test = Test::findOrFail($id);
        $item = $this->baseService->Index();
        $columns = Test::$columns;
        if (request()->ajax()) {
            return $item;
        }
        return view('pages.test.index', compact('columns', 'test'));
    }
    function delete($id)
    {
        $id = base64_decode($id);
        Classes::findOrFail($id)->delete();
        return redirect()->route('test.index')->with('success', 'Test Deleted Successfully');
    }
}
