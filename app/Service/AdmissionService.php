<?php

namespace App\Service;

use App\Models\AdmissionPatient;
use App\Models\Bed;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class AdmissionService {
    protected $model = AdmissionPatient::class;

  function unique_id()
  {
    $patient = $this->model::latest('id')->first();

    if ($patient) {
        $unique_id = date('m') . '-' . date('Y') . '-' . ($patient->id + 1);
    } else {
        $unique_id = date('m') . '-' . date('Y') . '-1';
    }
    return $unique_id;
  }
  function index()
  {
    $patinets = $this->model::orderBy('id', 'desc')->get();
    return DataTables::of($patinets)
      ->addColumn('date', function ($item) {
        return $item->created_at->format('d-M-Y');
      })
      ->addColumn('patient', function ($item) {
        return $item->name . '<br>Age:-' . $item->age .'<br>'.$item->contact;
      })
      ->addColumn('surgone', function ($item) {
        return $item->doctor->name;
      })
      ->addColumn('lens', function ($item) {
        return ($item->lens?->name ?? '') . '<br>' . ($item->lens?->power ?? '');
      })
      ->addColumn('bed', function ($item) {
        return $item->bed->name ?? null;
      })
      ->addColumn('ot', function ($item) {
        return $item->operation->name;
      })
      ->addColumn('status', function ($item) {
        return match ($item->status) {
            0 => '<span class="badge bg-primary text-light">Released</span>',
            1 => '<span class="badge bg-success text-light">Admitted</span>',
            default => '<span class="badge bg-danger text-light">Cancelled</span>',
        };
      })
      ->addColumn('action', fn ($item) => view('pages.admission_patient.action', compact('item'))->render())
      ->rawColumns(['action','status','patient','lens'])
      ->make(true);
  }
  function store($data)
  {
    DB::beginTransaction();
    try {
      // dd($data);
      $patient_data['user_id'] = auth()->user()->id;
      $patient_data['name'] = $data['name'];
      $patient_data['age'] = $data['age'];
      $patient_data['contact'] = $data['contact'];
      $patient_data['reg_no'] = $this->unique_id();
      $patient_data['doctor_id'] = $data['surgone'];
      $patient_data['present_address'] = $data['present_address'];
      $patient_data['permanent_address'] = $data['permanent_address'];
      $patient_data['relative_address'] = $data['relative_address'];
      if (isset($data['permanent_same'])) {
        $patient_data['permanent_address'] = $data['present_address'];
      }
      if (isset($data['relative_same'])) {
        $patient_data['ralative_address'] = $data['present_address'];
      }
      $patient_data['guardian'] = $data['guardian'];
      $patient_data['relative'] = $data['relative'];
      $patient_data['gender_id'] = $data['gender'];
      $patient_data['bed_type'] = $data['bed_type'];
      $patient_data['bed_id'] = $data['bed'];
      $patient_data['operation_id'] = $data['operation'];
      $patient_data['lens_id'] = $data['lens'];
      $patient_data['admission_fee'] = $data['admission_fee'];
      $patient_data['bed_fee'] = $data['ward_cabin'];

      $patient = $this->model::create($patient_data);

      $bed = Bed::findOrFail($data['bed']);
      if($bed->type == false){
        $bed->update(['status'=>true]);
      }

      DB::commit();
      return $patient;
    } catch (Exception $e) {
      DB::rollBack();
       dd(
        'Error: '.$e->getMessage(),
        'Line: '.$e->getLine()
      );
    }
  }

  function update($data,$id)
  {
    DB::beginTransaction();
    try {
      $patient = $this->model::findOrFail($id);
      $patient_data['user_id'] = auth()->user()->id;
      $patient_data['name'] = $data['name'];
      $patient_data['age'] = $data['age'];
      $patient_data['contact'] = $data['contact'];
      $patient_data['doctor_id'] = $data['surgone'];
      $patient_data['present_address'] = $data['present_address'];
      $patient_data['permanent_address'] = $data['permanent_address'];
      $patient_data['relative_address'] = $data['relative_address'];
      if (isset($data['permanent_same'])) {
        $patient_data['permanent_address'] = $data['present_address'];
      }
      if (isset($data['relative_same'])) {
        $patient_data['relative_address'] = $data['present_address'];
      }
      $patient_data['guardian'] = $data['guardian'];
      $patient_data['relative'] = $data['relative'];
      $patient_data['gender_id'] = $data['gender'];
      $patient_data['bed_type'] = $data['bed_type'];
      $patient_data['bed_id'] = $data['bed'];
      $patient_data['operation_id'] = $data['operation'];
      $patient_data['lens_id'] = $data['lens'];
      $patient_data['admission_fee'] = $data['admission_fee'];
      $patient_data['bed_fee'] = $data['ward_cabin'];
    
      $patient->update($patient_data);

      $bed = Bed::findOrFail($data['bed']);
      if($bed->type == false){
        $bed->update(['status'=>true]);
      }
      DB::commit();
      return $patient;
    } catch (Exception $e) {
      DB::rollBack();
      dd($e->getMessage(), __LINE__);
    }
  }

  function delete($id)
  {
    DB::beginTransaction();
    try {
      PathologyPatient::findOrFail($id)->delete();
      DB::commit();
      return ['success', 'Pathology Patient Deleted Successfully'];
    } catch (Exception $e) {
      DB::rollBack();
      dd($e->getMessage(), __LINE__);
    }
  }
}