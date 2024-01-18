<?php

namespace App\Http\Controllers;

use App\Jobs\SendNotification;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class CompanyController extends Controller
{

    public function index(Request $request) {
        $companies = Company::when($request->search, 
            fn($q)=>$q->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('email', 'like', '%'.$request->search.'%'))
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
            'logo' => [
                'required',
                File::image()
                    ->dimensions(Rule::dimensions()->minWidth(100)->minHeight(100)),
            ]
        ]);

        $validated['logo'] = $request->logo->store('logos');
        
        $company = Company::create($validated);

        dispatch(new SendNotification($company));

        return redirect('companies'); 
    }

    public function update(Company $company, Request $request) {        
        $validated = $request->validate([
            'name' => ['required', 'max:256'],
            'email' => ['required', 'max:256', 'email'],
            'phone' => ['required', 'max:256'],
            'logo' => [
                File::image()
                    ->dimensions(Rule::dimensions()->minWidth(100)->minHeight(100)),
            ]
        ]);
        
        if( $request->hasFile('logo') && !empty($company->logo)) {
            if (file_exists(Storage::path($company->logo))) {
                unlink(Storage::path($company->logo));
            }
            $validated['logo'] = $request->logo->store('logos');    
        }        
 
        $company->update($validated);

        return redirect('/company/' . $company->id);
    }

    public function destroy(Company $company) {
        $company->delete();
        return redirect('companies'); 
    }
}
