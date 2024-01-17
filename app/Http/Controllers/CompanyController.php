<?php

namespace App\Http\Controllers;

use App\Jobs\SendNotification;
use App\Models\Company;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function index(Request $request) {
        $companies = Company::when($request->search, fn($q)=>$q->where('name', 'like', '%'.$request->search.'%'))
            ->paginate()
            ->withQueryString()
            ->through(fn($company)=>[
                'id' => $company->id,
                'name' => $company->name,
                'email' => $company->email,
                'phone' => $company->phone
            ]);
        return Inertia::render('Company/Index', ['companies'=>$companies, 'search'=> $request->search]);
    }

    public function create(Request $request) {
        $validated = $request->validate([
            'name' => ['required', 'max:256'],
            'email' => ['required', 'max:256', 'email'],
            'phone' => ['required', 'max:256'],
            'logo' => ['image', 'mimes:jpg,png']
        ]);

        $validated['logo'] = $request->logo->store('logos');
        
        $company = Company::create($validated);

        dispatch(new SendNotification($company));

        return redirect('companies'); 
    }

    public function destroy(Company $company) {
        $company->delete();
        return redirect('companies'); 
    }
}
