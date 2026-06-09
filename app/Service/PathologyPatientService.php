<?php

namespace App\Service;

use App\Models\PathologyPatient;
use App\Models\PathologyPatientTest;
use App\Models\PathologyPayment;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PathologyPatientService {
  protected $model = PathologyPatient::class;

  function unique_id()
  {
    $patient = PathologyPatient::orderBy('id', 'desc')->first();
    if ($patient) {
      $unique_id = $patient->unique_id;
      $ext = explode('-', $unique_id)[1];
      if ($ext < 10) {
        $unique_id = setting()->invoice_prefix . '-000' . $ext + 1;
      } elseif ($ext < 100) {
        $unique_id = setting()->invoice_prefix . '-00' . $ext + 1;
      } elseif ($ext < 1000) {
        $unique_id = setting()->invoice_prefix . '-0' . $ext + 1;
      } else {
        $unique_id = setting()->invoice_prefix . '-' . $ext + 1;
      }
    } else {
      $unique_id = setting()->invoice_prefix . '-0001';
    }
    return $unique_id;
  }
  function index()
  {
    $patinets = $this->model::orderBy('id', 'desc')->get();
    return DataTables::of($patinets)
      ->addColumn('test', function ($item) {
        $badges = '';
        foreach ($item->tests as $test) {
          $badges .= '<span class="badge badge-primary">' . ($test->test->name ?? 'N/A') . '</span> ';
        }
        return $badges;
      })
      ->addColumn('action', fn ($item) => view('pages.pathology_patient.action', compact('item'))->render())
      ->rawColumns(['test', 'action'])
      ->make(true);
  }
  function store($data)
  {
    DB::beginTransaction();
    try {
      $patient_data['user_id'] = auth()->user()->id;
      $patient_data['name'] = $data['name'];
      $patient_data['age'] = $data['age'];
      $patient_data['contact'] = $data['contact'];
      // $patient_data['unique_id'] = $this->unique_id();
      $patient_data['doctor_id'] = $data['doctor'];
      $patient_data['referal_id'] = $data['referal'];
      if ($data['doctor'] != null) {
        $patient_data['referal_id'] = null;
      }
      $patient_data['visit_date'] = date('Y-m-d');
      $patient_data['gender_id'] = $data['gender'];
      $patient_data['total'] = $data['sub_total'];
      $patient_data['discount_amount'] = $data['discount_amount'];
      $patient_data['discount_percent'] = $data['discount_percent'];
      $patient_data['grand_total'] = $data['total_payable'];
      $patient_data['paid'] = $data['paid'] ?? 0;

      $patient = PathologyPatient::create($patient_data);

      $tests = $data['test_id'];

      foreach ($tests as $key => $test) {
        $patient_test['test_id'] = $test;
        $patient_test['pathology_patient_id'] = $patient->id;
        PathologyPatientTest::create($patient_test);
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

  function update($data)
  {
    DB::beginTransaction();
    try {
      $patient_data['name'] = $data['name'];
      $patient_data['age'] = $data['age'];
      $patient_data['contact'] = $data['contact'];
      $patient_data['age_type'] = $data['age_type'];
      $patient_data['doctor_id'] = $data['doctor_id'];
      $patient_data['referral_id'] = $data['referral_id'];
      if ($data['doctor_id'] != null) {
        $patient_data['referral_id'] = null;
      }
      $patient_data['gender_id'] = $data['gender_id'];
      $patient_data['total'] = $data['sub_total'];
      $patient_data['discount_amount'] = $data['discount_amount'];
      $patient_data['discount_percent'] = $data['discount_percent'];
      $patient_data['grand_total'] = $data['total_payable'];
      $patient_data['paid'] = $data['paid'];

      $patient = PathologyPatient::findOrFail($data['patient_id']);
      $patient->update($patient_data);

      $tests = $data['test_id'];

      PathologyPatientTest::where('patient_id', $patient->id)->delete();

      foreach ($tests as $key => $test) {
        $patient_test['test_id'] = $test;
        $patient_test['patient_id'] = $patient->id;
        PathologyPatientTest::create($patient_test);
      }
      
      PathologyPayment::where('patient_id', $patient->id)->delete();

      $payment = new PathologyPayment([
        'amount' => $patient->paid,
      ]);

      $patient->payment()->save($payment);
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