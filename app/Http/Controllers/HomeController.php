<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;

class HomeController extends Controller
{
    public function index()
    {   
        if(auth::check()){
            return redirect('/dashboard');
        }
        
        $home = true;
        return view('home', compact('home'));
    }
    
    public function faq()
    {   
        return view('faq');
    }

}

