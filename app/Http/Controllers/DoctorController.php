<?php

namespace App\Http\Controllers;

use App\Models\BloodGroup;
use App\Models\Doctor;
use App\Models\Gender;
use App\Models\Religion;
use App\Service\DoctorService;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->baseService = new DoctorService;
    }

    public function index()
    {
        $doctors = $this->baseService->index();
        $columns = Doctor::$columns;
        if (request()->ajax()) {
            return $doctors;
        }
        return view('pages.doctor.index', compact('columns'));
    }

    public function create()
    {
        $gender = Gender::all();
        $blood_group = BloodGroup::all();
        $religion = Religion::all();
        return view('pages.doctor.create', compact('gender', 'blood_group', 'religion'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'institute' => 'required',
            'degree' => 'required',
            'contact' => 'required|unique:doctors,contact',
            'gender' => 'required',
            'blood_group' => 'required',
            'religion' => 'required',
        ]);
        $data = $request->all();
        $this->baseService->create($data);
        return redirect()->route('doctor.index')->with('success', 'Doctor Inserted Successfully');
    }
    public function edit($id)
    {
        $gender = Gender::all();
        $blood_group = BloodGroup::all();
        $religion = Religion::all();
        $doctor = Doctor::findOrFail($id);
        return view('pages.doctor.edit', compact('doctor', 'gender', 'blood_group', 'religion'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'institute' => 'required',
            'degree' => 'required',
            'contact' => 'required',
            'gender' => 'required',
            'blood_group' => 'required',
            'religion' => 'required',
        ]);
        $data = $request->all();
        $this->baseService->update($data, $id);
        return redirect()->route('doctor.index')->with('success', 'Doctor Updated Successfully');
    }
    public function delete($id)
    {
        $this->baseService->delete($id);
        return redirect()->route('doctor.index')->with('success', 'Doctor Deleted Successfully');
    }
}
