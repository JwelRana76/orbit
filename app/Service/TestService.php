<?php

namespace App\Service;

use App\Models\Test;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class TestService {
  protected $model = Test::class;

  public function Index()
  {
    $data = $this->model::all();

    return DataTables::of($data)
      ->addColumn('name', function ($item) {
        return Str::upper($item->name);
      })
      ->addColumn('action', fn($item) => view('pages.test.action', compact('item'))->render())
      ->make(true);
  }

  public function create($data)
  {
    DB::beginTransaction();
    try {
      if ($data['id'] == null) {
        $this->model::create([
          'name' => $data['name'],
          'rate' => $data['rate'],
          'max_discount' => $data['max_discount'],
        ]);
        $message = ['success' => 'Test Inserted Successfully'];
      } else {
        $this->model::findOrFail($data['id'])->update([
          'name' => $data['name'],
          'rate' => $data['rate'],
          'max_discount' => $data['max_discount'],
        ]);
        $message = ['success' => 'Test Updated Successfully'];
      }
      DB::commit();
      return $message;
    } catch (Exception $th) {
      DB::rollback();
      dd($th->getMessage());
    }
  }
}