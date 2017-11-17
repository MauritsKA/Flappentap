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
    
    public function email()
    {
        Auth::user()->update(['email'=>request('email')]);        
        return back();
    }
    
    public function iban()
    {
        //dd(Auth::user()->iban);
        Auth::user()->update(['iban'=>request('iban')]);        
        return back();
    }
}


