<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\NpnController;
use App\Http\Controllers\CustomerenquiryController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\CategoryController;
use App\Mail\SendMailsToUsers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

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
//route login
Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'process']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');


Route::get('/user/change-password', [UserController::class, 'changePassword']);
Route::post('/change-password', [UserController::class, 'changePasswordSave'])->name('postChangePassword');

// route dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/', [DashboardController::class, 'index'])->middleware('auth');

//route barang
// Route::resource('/barang', BarangController::class)->middleware('auth');

//route user
Route::resource('/user', UserController::class)->middleware('auth');

Route::put('/user/{id}','UserController@update');

//route location
Route::resource('/location', LocationController::class)->middleware('auth');

//route role
Route::resource('/role', RoleController::class)->middleware('auth');

//route task
Route::resource('/task', TaskController::class)->middleware('auth');
//Route::get('tasks/export', [TaskController::class, 'exportToExcel'])->name('tasks.export');
Route::get('task-export', [TaskController::class, 'taskExport'])->name('task-export');

//route task
//Route::get('/download/{file}', [TaskController::class, 'download'])->name('download')->middleware('auth');

//route Supplier
Route::resource('/supplier', SupplierController::class)->middleware('auth');

//route Category
Route::resource('/category', CategoryController::class)->middleware('auth');

//route Npn
Route::resource('/npn', NpnController::class)->middleware('auth');

//route CustomerEnquiry
Route::resource('/customerenquiry', CustomerenquiryController::class)->middleware('auth');

//route timesheet
Route::resource('/timesheet', TimesheetController::class)->middleware('auth');

//route Agency
Route::resource('/agency', AgencyController::class)->middleware('auth');

//route Employee
Route::resource('/employee', EmployeeController::class)->middleware('auth');

//route Machine
Route::resource('/machine', MachineController::class)->middleware('auth');

Route::get('/download/{filename}', [FileController::class, 'download'])->name('file.download');

Route::resource('/file', FileController::class)->middleware('auth');

Route::get('/file/create', [FileController::class, 'create'])->middleware('auth');

Route::post('/upload', [FileController::class, 'upload'])->name('file.upload');

Route::get('/file/execute/{file_id}', [FileController::class, 'execute'])->name('file.execute');
