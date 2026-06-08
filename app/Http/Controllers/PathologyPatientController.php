<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Doctor;
use App\Models\Gender;
use App\Models\PathologyPatient;
use App\Models\Religion;
use App\Service\PathologyPatientService;
use Illuminate\Http\Request;

class PathologyPatientController extends Controller
{
     public function __construct()
    {
        $this->baseService = new PathologyPatientService;
    }
    function index()
    {
        if (!userHasPermission('patient-index'))
        // return view('404');
        $patients = $this->baseService->index();
        $columns = PathologyPatient::$columns;
        if (request()->ajax()) {
            return $patients;
        }
        return view('pages.pathology_patient.index', compact('columns'));
    }

    function create()
    {
        if (!userHasPermission('patient-store'))
        // return view('404');
        $gender = Gender::all();
        $doctors = Doctor::where('is_active', 1)->get();
        $tests = Test::where('is_active', 1)->get();
        return view('pages.pathology_patient.create', compact('doctors', 'tests', 'gender'));
    }
    function testFind($id)
    {
        return Test::where('id', $id)->first();
    }
    function store(Request $request)
    {
        $data = $request->all();
        <!-- $patient = $this->baseService->store($data); -->
        return $data;
    }
    function invoice($id)
    {
        $patient = PathologyPatient::findOrFail($id);
        return view('pages.pathology_patient.invoice', compact('patient'));
    }
    function edit($id)
    {
        if (!userHasPermission('patient-update'))
        return view('404');
        $genders = Gender::all();
        $doctors = Doctor::where('is_active', 1)->get();
        $referrals = Doctor::where('is_active', 1)->get();
        $tests = Test::where('is_active', 1)->get();
        $patient = PathologyPatient::findOrFail($id);
        return view('pages.pathology_patient.edit', compact('patient', 'doctors', 'referrals', 'tests', 'tubes', 'genders'));
    }
    function update(Request $request)
    {
        $data = $request->all();
        $patient = $this->baseService->update($data);
        return $patient;
    }
    function delete($id)
    {
        if (!userHasPermission('patient-delete'))
        return view('404');
        $message = $this->baseService->delete($id);
        return redirect()->route('pathology.patient.index')->with($message);
    }
}
