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
        'email' => 'required|string|email|max:255|unique:users',
        ]);
        
        if(User::where('email', request('email'))->first() == null){
        Auth::user()->update(['email'=>request('email')]);
        }
        
        return back()->with('status', 'Succesfully changed your email!');
        
    }
    
    public function password(Request $request)
    {
        
        $this->validate(request(), [
        'password' => 'required|string|min:6|confirmed',
        ]);
        
       if ($request->password == $request->password_confirmation){
        Auth::user()->update(['password'=> bcrypt($request->password)]);

        return back()->with('status', 'Succesfully changed your password!');
        } 
        
      return back()->with('alert', 'Something went wrong!');
        
    }
    
    public function iban()
    {
        Auth::user()->update(['iban'=>request('iban')]);        
        return back()->with('status', 'Succesfully changed your IBAN!');
    }
}


