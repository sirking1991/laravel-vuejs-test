<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    public function index(Request $request) {
        $employees = Employee::when($request->search, 
            fn($q)=>$q->where('first_name', 'like', '%'.$request->search.'%')
                ->orWhere('last_name', 'like', '%'.$request->search.'%')
                ->orWhere('email', 'like', '%'.$request->search.'%'))
            ->paginate()
            ->withQueryString()
            ->through(fn($employee)=>[
                'id' => $employee->id,
                'first_name' => $employee->first_name,
                'last_name' => $employee->last_name,
                'email' => $employee->email,
                'phone' => $employee->phone
            ]);
        return Inertia::render('Employee/Index', ['employees'=>$employees, 'search'=> $request->search]);
    }

    public function create(Request $request){

    }

    public function update(Employee $employee, Request $request) {

    }

    public function destroy(Employee $employee) {
        $employee->delete();
        return redirect('employees'); 
    }
}
