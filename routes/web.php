<?php

use App\Http\Controllers\BloodGroupController;
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
use App\Http\Controllers\GenderController;
use App\Http\Controllers\GroupController;
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
    
    Route::group(['prefix' => 'academy/room', 'as' => 'room.'], function () {
        Route::get('/',[RoomController::class, 'index'])->name('index');
        Route::post('/store',[RoomController::class, 'store'])->name('store');
        Route::get('/edit/{id}',[RoomController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}',[RoomController::class, 'delete'])->name('delete');
    });
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

