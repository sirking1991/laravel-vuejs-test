<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');
    
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies');
    Route::get('/company/new', fn() => Inertia::render('Company/New'));
    Route::post('/company', [CompanyController::class, 'create']);
    Route::delete('/company/{company}', [CompanyController::class, 'destroy']);
    Route::get('/company/{company}', function(Company $company){
        return Inertia::render('Company/View', ['company'=>$company]);
    });
    Route::put('/company/{company}', [CompanyController::class, 'update']);

    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees');
    Route::get('/employee/new', [EmployeeController::class, 'new']);
    Route::post('/employee', [EmployeeController::class, 'create']);
    Route::delete('/employee/{employee}', [EmployeeController::class, 'destroy']);
    Route::get('/employee/{employee}', [EmployeeController::class, 'view']);
    Route::put('/employee/{employee}', [EmployeeController::class, 'update']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// public files
Route::get('/file', function (){
    return response()->file(Storage::path(request('path')));
});

require __DIR__.'/auth.php';
