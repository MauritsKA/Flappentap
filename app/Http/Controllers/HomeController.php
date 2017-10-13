<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    public function index()
    {   
        if(auth::check()){
            return redirect('/dashboard');
        }
        
        return view('home');
    }
}

