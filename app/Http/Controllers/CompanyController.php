<?php

namespace App\Http\Controllers;

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
}
