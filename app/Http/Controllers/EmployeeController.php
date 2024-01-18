<?php

namespace App\Http\Controllers;

use App\Models\Company;
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
            ->with('company')
            ->paginate()
            ->withQueryString()
            ->through(fn($employee)=>[
                'id' => $employee->id,
                'first_name' => $employee->first_name,
                'last_name' => $employee->last_name,
                'email' => $employee->email,
                'company_name' => $employee->company->name
            ]);
        return Inertia::render('Employee/Index', ['employees'=>$employees, 'search'=> $request->search]);
    }

    public function new(){
        $companies = Company::select('id', 'name')->orderBy('name')->get();
        return Inertia::render('Employee/New', ['companies'=>$companies]);
    }

    public function create(Request $request){
        $validated = $request->validate([
            'first_name' => ['required', 'max:256'],
            'last_name' => ['required', 'max:256'],
            'email' => ['required', 'max:256', 'email'],
            'company_id' => ['required', 'exists:companies,id'],
        ]);

        Employee::create($validated);

        return redirect('employees'); 
    }

    public function view(Employee $employee){
        $companies = Company::select('id', 'name')->orderBy('name')->get();
        return Inertia::render('Employee/View', ['companies'=>$companies, 'employee'=>$employee]);
    }

    public function update(Employee $employee, Request $request) {
        $validated = $request->validate([
            'first_name' => ['required', 'max:256'],
            'last_name' => ['required', 'max:256'],
            'email' => ['required', 'max:256', 'email'],
            'company_id' => ['required', 'exists:companies,id']
        ]);
        
        $employee->update($validated);

        return redirect('/employee/' . $employee->id);
    }

    public function destroy(Employee $employee) {
        $employee->delete();
        return redirect('employees'); 
    }
}
