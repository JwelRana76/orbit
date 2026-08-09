<?php

namespace App\Http\Controllers;

use App\Models\AdmissionPatient;
use App\Models\Bed;
use App\Models\Doctor;
use App\Models\Gender;
use App\Models\Lens;
use App\Models\Operation;
use App\Service\AdmissionService;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    public function __construct()
    {
        $this->baseService = new AdmissionService;
    }
    function index()
    {
        if (!userHasPermission('patient-index'))
        // return view('404');
        $patients = $this->baseService->index();
        $columns = AdmissionPatient::$columns;
        if (request()->ajax()) {
            return $patients;
        }
        return view('pages.admission_patient.index', compact('columns'));
    }

    function create()
    {
        if (!userHasPermission('patient-store'))
        // return view('404');
        $gender = Gender::all();
        $beds = Bed::where('status',false)->get();
        $lens = Lens::where('status',true)->get();
        $operation = Operation::where('status',true)->get();
        $doctors = Doctor::where('is_active', 1)->get();
        return view('pages.admission_patient.create', compact('doctors', 'gender','beds','lens','operation'));
    }
    function store(Request $request)
    {
        $data = $request->all();
        $patient = $this->baseService->store($data);
        return redirect()->route('admission.patient.index')->with('success','Admission Completed');
    }
    function find_patient($id)
    {
        $patient = AdmissionPatient::select('ot_fee', 'bed_fee', 'lens_fee', 'admission_fee')
                ->findOrFail($id);
        return $patient;
    }
    function payment(Request $request){
        $data = array_filter(
            $request->except('patient_id'),
            fn ($value) => !is_null($value)
        );
        $patient = AdmissionPatient::findOrFail($request->patient_id);
        $patient->update($data);
        return back()->with('success','Patient Payment Completed');
    }
    function cancel(Request $request){
        $data = $request->except('patient_id');
        $data['status'] = null;
        $patient = AdmissionPatient::findOrFail($request->patient_id);
        $patient->update($data);
        Bed::findOrFail($patient->bed_id)->update(['status'=> false]);
        return back()->with('success','Patient Cancel Completed');
    }
    function edit($id)
    {
        $patient = AdmissionPatient::findOrFail($id);
        $gender = Gender::all();
        $beds = Bed::where('status',false)->orwhere('id',$patient->bed_id)->get();;
        $lens = Lens::where('status',true)->get();
        $operation = Operation::where('status',true)->get();
        $doctors = Doctor::where('is_active', 1)->get();
        return view('pages.admission_patient.edit', compact('patient', 'doctors', 'gender','lens','beds','operation'));
    }
    function update(Request $request,$id)
    {
        $data = $request->all();
        $patient = $this->baseService->update($data,$id);
        return redirect()->route('admission.patient.index')->with('success','Admission Update Completed');
    }
    function delete($id)
    {
        if (!userHasPermission('patient-delete'))
        return view('404');
        $message = $this->baseService->delete($id);
        return redirect()->route('pathology.patient.index')->with($message);
    }
    function release($id){
        $patient = AdmissionPatient::findOrFail($id);
        $patient->update([
            'status' => false,
            'released' => now(),
        ]);
        $bed = Bed::findOrFail($patient->bed_id)->update(['status' => false]);
        return back()->with('success','Patient Released Successfully');
    }
    function readmit(Request $request){
        $patient = AdmissionPatient::findOrFail($request->patient_id);
        $patient->update([
            'status' => true,
            'bed_id' => $request->bed_id,
            'created_at' => now(),
        ]);
        return back()->with('success','Patient Re-Admited Successfully');
    }
    function lens(Request $request){
        
        $patient = AdmissionPatient::findOrFail($request->patient_id);
        $patient->update([
            'lens_id' => $request->lens_id,
        ]);
        return back()->with('success','Patient Lens Provided Successfully');
    }
}
