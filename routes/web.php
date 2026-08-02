<?php

use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\BedController;
use App\Http\Controllers\BloodGroupController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SiteSettingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\FrameController;
use App\Http\Controllers\GenderController;
use App\Http\Controllers\GlassController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LenProviderController;
use App\Http\Controllers\LensController;
use App\Http\Controllers\LensPurchaseController;
use App\Http\Controllers\LensSupplierController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\MedicinePurchaseController;
use App\Http\Controllers\MedicineSaleController;
use App\Http\Controllers\MedicineSupplierController;
use App\Http\Controllers\OtController;
use App\Http\Controllers\PathologyPatientController;
use App\Http\Controllers\ReligionController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UpazilaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['middleware'=>['auth']], function() {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'setting/role', 'as' => 'role.'], function () {
        Route::get('/',[RoleController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('edit');
        Route::post('/store', [RoleController::class, 'store'])->name('store');
        Route::get('/delete/{id}', [RoleController::class, 'delete'])->name('delete');
        Route::post('/update/{id}', [RoleController::class, 'update'])->name('update');
        Route::get('/permission/{id}', [RoleController::class, 'permission'])->name('permission');
        Route::post('/permission/store/{id}', [RoleController::class, 'permission_store'])->name('permission.store');
    });
    Route::group(['prefix' => 'setting/user', 'as' => 'user.'], function () {
        Route::get('/',[UsersController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [UsersController::class, 'edit'])->name('edit');
        Route::post('/store', [UsersController::class, 'store'])->name('store');
        Route::get('/delete/{id}', [UsersController::class, 'delete'])->name('delete');
        Route::post('/update/{id}', [UsersController::class, 'update'])->name('update');
        Route::get('/assign_role/{id}',[UsersController::class, 'assign_role'])->name('role_assign');
        Route::post('/assign_role', [UsersController::class, 'assign_role_store'])->name('role_assign_store');
    });
    Route::group(['prefix' => 'setting/site_setting', 'as' => 'site_setting.'], function () {
        Route::get('/',[SiteSettingController::class, 'index'])->name('index');
        Route::post('/update/{id}', [SiteSettingController::class, 'update'])->name('update');
    });
    Route::group(['prefix' => 'setting/division', 'as' => 'division.'], function () {
        Route::get('/',[DivisionController::class, 'index'])->name('index');
        Route::post('/store',[DivisionController::class, 'store'])->name('store');
        Route::get('/edit/{id}',[DivisionController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}',[DivisionController::class, 'delete'])->name('delete');
        Route::post('/divisionstore', [DivisionController::class, 'divisionstore'])->name('divisionstore');
    });
    Route::group(['prefix' => 'setting/doctor', 'as' => 'doctor.'], function () {
        Route::get('/',[DoctorController::class, 'index'])->name('index');
        Route::get('/create',[DoctorController::class, 'create'])->name('create');
        Route::post('/store',[DoctorController::class, 'store'])->name('store');
        Route::get('/edit/{id}',[DoctorController::class, 'edit'])->name('edit');
        Route::post('/update/{id}',[DoctorController::class, 'update'])->name('update');
        Route::get('/delete/{id}',[DoctorController::class, 'delete'])->name('delete');
        Route::post('/divisionstore', [DoctorController::class, 'divisionstore'])->name('divisionstore');
    });
    Route::group(['prefix' => 'setting/district', 'as' => 'district.'], function () {
        Route::get('/',[DistrictController::class, 'index'])->name('index');
        Route::post('/store',[DistrictController::class, 'store'])->name('store');
        Route::get('/edit/{id}',[DistrictController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}',[DistrictController::class, 'delete'])->name('delete');
        Route::post('/districtstore', [DistrictController::class, 'districtstore'])->name('districtstore');
    });
    Route::group(['prefix' => 'setting/upazila', 'as' => 'upazila.'], function () {
        Route::get('/',[UpazilaController::class, 'index'])->name('index');
        Route::post('/store',[UpazilaController::class, 'store'])->name('store');
        Route::get('/edit/{id}',[UpazilaController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}',[UpazilaController::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'setting/blood_group', 'as' => 'blood_group.'], function () {
        Route::get('/',[BloodGroupController::class, 'index'])->name('index');
        Route::post('/store',[BloodGroupController::class, 'store'])->name('store');
        Route::get('/edit/{id}',[BloodGroupController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}',[BloodGroupController::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'setting/religion', 'as' => 'religion.'], function () {
        Route::get('/',[ReligionController::class, 'index'])->name('index');
        Route::post('/store',[ReligionController::class, 'store'])->name('store');
        Route::get('/edit/{id}',[ReligionController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}',[ReligionController::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'setting/gender', 'as' => 'gender.'], function () {
        Route::get('/',[GenderController::class, 'index'])->name('index');
        Route::post('/store',[GenderController::class, 'store'])->name('store');
        Route::get('/edit/{id}',[GenderController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}',[GenderController::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'setting/bed', 'as' => 'bed.'], function () {
        Route::get('/',[BedController::class, 'index'])->name('index');
        Route::post('/store',[BedController::class, 'store'])->name('store');
        Route::get('/edit/{id}',[BedController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}',[BedController::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'setting/operation', 'as' => 'ot.'], function () {
        Route::get('/',[OtController::class, 'index'])->name('index');
        Route::post('/store',[OtController::class, 'store'])->name('store');
        Route::get('/edit/{id}',[OtController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}',[OtController::class, 'delete'])->name('delete');
    });
    // Academic section route start
    Route::group(['prefix' => 'pathology/test', 'as' => 'test.'], function () {
        Route::get('/',[TestController::class,'index'])->name('index');
        Route::post('/store',[TestController::class,'store'])->name('store');
        Route::get('/edit/{id}',[TestController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}',[TestController::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'pathology/patient', 'as' => 'pathology.patient.'], function () {
        Route::get('/',[PathologyPatientController::class, 'index'])->name('index');
        Route::get('/create',[PathologyPatientController::class, 'create'])->name('create');
        Route::post('/store',[PathologyPatientController::class, 'store'])->name('store');
        Route::get('/edit/{id}',[PathologyPatientController::class, 'edit'])->name('edit');
        Route::post('/update/{id}',[PathologyPatientController::class, 'update'])->name('update');
        Route::get('/delete/{id}',[PathologyPatientController::class, 'delete'])->name('delete');
        Route::get('/test_find/{id}',[PathologyPatientController::class ,'testFind']);
        Route::get('/invoice/{id}',[PathologyPatientController::class, 'invoice'])->name('invoice');
    });

    // Lens router section started 
    Route::group(['prefix' => 'lens/index', 'as' => 'lens.'], function () {
        Route::get('/',[LensController::class,'index'])->name('index');
        Route::post('/store',[LensController::class,'store'])->name('store');
        Route::get('/edit/{id}',[LensController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}',[LensController::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'lens/supplier', 'as' => 'lens.supplier.'], function () {
        Route::get('/',[LensSupplierController::class,'index'])->name('index');
        Route::post('/store',[LensSupplierController::class,'store'])->name('store');
        Route::get('/edit/{id}',[LensSupplierController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}',[LensSupplierController::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'lens/purchase', 'as' => 'lens.purchase.'], function () {
        Route::get('/',[LensPurchaseController::class, 'index'])->name('index');
        Route::get('/create',[LensPurchaseController::class, 'create'])->name('create');
        Route::post('/store',[LensPurchaseController::class, 'store'])->name('store');
        Route::get('/edit/{id}',[LensPurchaseController::class, 'edit'])->name('edit');
        Route::post('/update/{id}',[LensPurchaseController::class, 'update'])->name('update');
        Route::get('/delete/{id}',[LensPurchaseController::class, 'delete'])->name('delete');
        Route::get('/find_lens/{id}',[LensPurchaseController::class, 'lensFind']);
        Route::get('/invoice/{id}',[LensPurchaseController::class, 'invoice'])->name('invoice');
        Route::post('payment',[LensPurchaseController::class,'payment'])->name('payment');
    });
    Route::group(['prefix' => 'lens/provider', 'as' => 'lens.provider.'], function () {
        Route::get('/',[LenProviderController::class, 'index'])->name('index');
        Route::get('/create',[LenProviderController::class, 'create'])->name('create');
        Route::post('/store',[LenProviderController::class, 'store'])->name('store');
        Route::get('/edit/{id}',[LenProviderController::class, 'edit'])->name('edit');
        Route::post('/update/{id}',[LenProviderController::class, 'update'])->name('update');
        Route::get('/delete/{id}',[LenProviderController::class, 'delete'])->name('delete');
        Route::get('/invoice/{id}',[LenProviderController::class, 'invoice'])->name('invoice');
    });

    // Admission patient route sections
     Route::group(['prefix' => 'admission/patient', 'as' => 'admission.patient.'], function () {
        Route::get('/',[AdmissionController::class, 'index'])->name('index');
        Route::get('/create',[AdmissionController::class, 'create'])->name('create');
        Route::post('/store',[AdmissionController::class, 'store'])->name('store');
        Route::get('/edit/{id}',[AdmissionController::class, 'edit'])->name('edit');
        Route::post('/update/{id}',[AdmissionController::class, 'update'])->name('update');
        Route::get('/delete/{id}',[AdmissionController::class, 'delete'])->name('delete');
        Route::get('/find_patient/{id}',[AdmissionController::class ,'find_patient']);
        Route::post('/payment',[AdmissionController::class, 'payment'])->name('payment');
        Route::get('/release/{id}',[AdmissionController::class, 'release'])->name('release');
        Route::post('/cancel',[AdmissionController::class, 'cancel'])->name('cancel');
    });

    // Pharmacy Section start 
    Route::group(['prefix' => 'pharmacy/medicine', 'as' => 'medicine.'], function () {
        Route::get('/',[MedicineController::class,'index'])->name('index');
        Route::post('/store',[MedicineController::class,'store'])->name('store');
        Route::get('/edit/{id}',[MedicineController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}',[MedicineController::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'pharmacy/medicine/supplier', 'as' => 'medicine.supplier.'], function () {
        Route::get('/',[MedicineSupplierController::class,'index'])->name('index');
        Route::post('/store',[MedicineSupplierController::class,'store'])->name('store');
        Route::get('/edit/{id}',[MedicineSupplierController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}',[MedicineSupplierController::class, 'delete'])->name('delete');
        Route::post('/payment',[MedicineSupplierController::class, 'payment'])->name('payment');
        Route::get('/payment/details/{id}',[MedicineSupplierController::class, 'paymentDetails'])->name('paymentDetails');
    });
    Route::group(['prefix' => 'pharmacy/medicine/customer', 'as' => 'medicine.customer.'], function () {
        Route::get('/',[CustomerController::class,'index'])->name('index');
        Route::post('/store',[CustomerController::class,'store'])->name('store');
        Route::get('/edit/{id}',[CustomerController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}',[CustomerController::class, 'delete'])->name('delete');
        Route::post('/payment',[CustomerController::class, 'payment'])->name('payment');
        Route::get('/payment/details/{id}',[CustomerController::class, 'paymentDetails'])->name('paymentDetails');
    });
    Route::group(['prefix' => 'pharmacy/medicine/purchase', 'as' => 'medicine.purchase.'], function () {
        Route::get('/',[MedicinePurchaseController::class, 'index'])->name('index');
        Route::get('/create',[MedicinePurchaseController::class, 'create'])->name('create');
        Route::post('/store',[MedicinePurchaseController::class, 'store'])->name('store');
        Route::get('/edit/{id}',[MedicinePurchaseController::class, 'edit'])->name('edit');
        Route::post('/update/{id}',[MedicinePurchaseController::class, 'update'])->name('update');
        Route::get('/delete/{id}',[MedicinePurchaseController::class, 'delete'])->name('delete');
        Route::get('/find_medicine/{id}',[MedicinePurchaseController::class, 'medicineFind']);
        Route::get('/invoice/{id}',[MedicinePurchaseController::class, 'invoice'])->name('invoice');
        Route::post('payment',[MedicinePurchaseController::class,'payment'])->name('payment');
        Route::get('paymentdelete/{id}',[MedicinePurchaseController::class,'paymentDelete'])->name('paymentDelete');
    });
    Route::group(['prefix' => 'pharmacy/medicine/sale', 'as' => 'medicine.sale.'], function () {
        Route::get('/',[MedicineSaleController::class, 'index'])->name('index');
        Route::get('/create',[MedicineSaleController::class, 'create'])->name('create');
        Route::post('/store',[MedicineSaleController::class, 'store'])->name('store');
        Route::get('/edit/{id}',[MedicineSaleController::class, 'edit'])->name('edit');
        Route::post('/update/{id}',[MedicineSaleController::class, 'update'])->name('update');
        Route::get('/delete/{id}',[MedicineSaleController::class, 'delete'])->name('delete');
        Route::get('/find_medicine/{id}',[MedicineSaleController::class, 'medicineFind'])->name('findMedicine');
        Route::get('/invoice/{id}',[MedicineSaleController::class, 'invoice'])->name('invoice');
        Route::post('payment',[MedicineSaleController::class,'payment'])->name('payment');
        Route::get('paymentdelete/{id}',[MedicineSaleController::class,'paymentDelete'])->name('paymentDelete');
    });
    Route::group(['prefix' => 'pharmacy/glass', 'as' => 'glass.'], function () {
        Route::get('/',[GlassController::class,'index'])->name('index');
        Route::post('/store',[GlassController::class,'store'])->name('store');
        Route::get('/edit/{id}',[GlassController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}',[GlassController::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'pharmacy/frame', 'as' => 'frame.'], function () {
        Route::get('/',[FrameController::class,'index'])->name('index');
        Route::post('/store',[FrameController::class,'store'])->name('store');
        Route::get('/edit/{id}',[FrameController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}',[FrameController::class, 'delete'])->name('delete');
    });
    // Pharmacy section end 
    // academic route section end 

    // hrm section router start 
    Route::group(['prefix' => 'hrm/department', 'as' => 'department.'], function () {
        Route::get('/',[DepartmentController::class, 'index'])->name('index');
        Route::post('/store',[DepartmentController::class, 'store'])->name('store');
        Route::get('/edit/{id}',[DepartmentController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}',[DepartmentController::class, 'delete'])->name('delete');
    });
});

Auth::routes();

