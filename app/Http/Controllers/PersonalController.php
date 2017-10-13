<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mutation;
use Auth;

class PersonalController extends Controller
{
      public function __construct()
    {
        $this->middleware('auth');
    }

   
    public function index()
    {   
        
        $mutations = Mutation::all();
        
        return view('personal', compact('mutations'));
    }
}
