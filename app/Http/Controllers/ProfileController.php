<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Company;
use App\Mutation;
    
class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   
    public function index()
    {
        $user = Auth::user();
        
        return view('profile', compact('user'));
        }
    
    public function email(Request $request)
    {
        
        $this->validate(request(), [
        'email' => 'required|unique:users',
        ]);
        
        if (User::where('email', request('email'))->first() == null){
        Auth::user()->update(['email'=>request('email')]);
            return back();
        }
        
    }
    
    public function iban()
    {
        Auth::user()->update(['iban'=>request('iban')]);        
        return back();
    }
}


