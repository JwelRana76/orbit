<?php

namespace App\Service;

use App\Models\Doctor;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DoctorService {
  protected $model = Doctor::class;

  public function index()
  {
    $doctors = $this->model::active();
    return DataTables::of($doctors)
      ->addColumn('photo', function ($user) {
        if ($user->photo) {
          $img = '<img src="/upload/doctor/' . $user->photo . '" alt="logo" width="80px">';
        } else {
          if ($user->gender_id == 1) {
            $img = '<img src="/upload/doctor/male.jpg" alt="logo" width="80px">';
          } else {
            $img = '<img src="/upload/doctor/female.jpg" alt="logo" width="80px">';
          }
        }
        return $img;
      })
      ->addColumn('signature', function ($user) {
        if ($user->signature) {
          return $img = '<img src="/upload/signature/' . $user->signature . '" alt="logo" width="80px">';
        } else {
          return 'No Signature';
        }
      })
      ->addColumn('action', function ($item) {
        return view('pages.doctor.action', compact('item'))->render();
      })
      ->rawColumns(['photo', 'action', 'signature'])
      ->make(true);
  }
  public function create($data)
  {
    DB::beginTransaction();
    try {
      if (!empty($data['photo'])) {
        $file = $data['photo'];
        $name = time() . '.' . $file->getClientOriginalExtension();
        $des = 'upload/doctor/';
        $file->move($des, $name);
        $data['photo'] = $name;
      }
      if (!empty($data['signature'])) {
        $file = $data['signature'];
        $name = time() . '.' . $file->getClientOriginalExtension();
        $des = 'upload/signature/';
        $file->move($des, $name);
        $data['signature'] = $name;
      }
      $data['gender_id'] = $data['gender'];
      $data['religion_id'] = $data['religion'];
      $data['blood_group_id'] = $data['blood_group'];
      $this->model::create($data);

      DB::commit();
    } catch (Exception $e) {
      DB::rollBack();
      dd($e->getMessage());
    }
  }
  public function update($data, $id)
  {
    $doctor = $this->model::findOrFail($id);
    DB::beginTransaction();
    try {
      if (!empty($data['photo'])) {
        $file = $data['photo'];
        $name = time() . '.' . $file->getClientOriginalExtension();
        $des = 'upload/doctor/';
        $file->move($des, $name);
        $data['photo'] = $name;
      }
      if (!empty($data['signature'])) {
        $file = $data['signature'];
        $name = time() . '.' . $file->getClientOriginalExtension();
        $des = 'upload/signature/';
        $file->move($des, $name);
        $data['signature'] = $name;
      }
      $data['gender_id'] = $data['gender'];
      $data['religion_id'] = $data['religion'];
      $data['blood_group_id'] = $data['blood_group'];

      $doctor->update($data);

      DB::commit();
    } catch (Exception $e) {
      DB::rollBack();
      dd($e->getMessage());
    }
  }
  public function delete($id)
  {
    $this->model::findOrFail($id)->update([
      'is_active' => false,
    ]);
  }
}