<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Mutation;
use Auth;

class CompanyController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

     public function index()
    {   
        
        $companies = Auth::user()->companies;
        
        return view('companies', compact('companies'));
    }
    
    public function form()
    {
        return view('companyform');
    }
    
    public function create()
    {
        
       $user = Auth::user();
        
       $company = Company::create([
            'name' => request('name'),
            'user_id' =>  $user->id,
            'email' => request('email'),
            'country' => request('country'),
            'city' => request('city'),
            'postalcode' => request('postalcode'),
            'address' => request('address')
        ]);
        
        $id = $company->id;
        $code = 'C'. $id. str_random(10);
        
        Company::find($id)->update(['company_code'=>$code]);
        
        $company->users()->attach($user->id);
        
        return redirect('/dashboard');
        
    }
}
                
       