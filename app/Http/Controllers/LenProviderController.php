<?php

namespace App\Http\Controllers;

use App\Models\Lens;
use App\Models\LensProvider;
use App\Service\LensProviderService;
use Illuminate\Http\Request;

class LenProviderController extends Controller
{
    public function __construct()
    {
        $this->baseService = new LensProviderService;
    }
    protected $model = LensProvider::class;

    public function index()
    {
        $columns = $this->model::$columns;
        $provider = $this->baseService->Index();
        if (request()->ajax()) {
            return $provider;
        }
        return view('pages.lens_provider.index', compact('columns'));
    }
    public function create(){
        $lens = Lens::where('status',true)->where('is_hospital_provider',false)->get();
        return view('pages.lens_provider.create',compact('lens'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $purchase = $this->baseService->store($data);
        return redirect()->route('lens.provider.index')->with('success','Len Stock In Successfully');
    }
    public function invoice($id){
        $purchase = LensProvider::findOrFail($id);
        return view('pages.lens_provider.invoice',compact('purchase'));
    }
    function edit($id)
    {   $id = base64_decode($id);
        $purchase = LensProvider::findOrFail($id);
        $lens = Lens::where('status',true)->where('is_hospital_provider',false)->get();
        return view('pages.lens_provider.edit', compact('purchase','lens'));
    }
    
    public function update(Request $request, $id){
        $data = $request->all();
        $purchase = $this->baseService->update($data,$id);
        return redirect()->route('lens.provider.index')->with('success','Len Stock In Updated Successfully');
    }
    function delete($id)
    {
        $id = base64_decode($id);
        $this->model::findOrFail($id)->delete();
        return redirect()->route('lens.provider.index')->with('success', 'Lens Stock In Deleted Successfully');
    }
}
