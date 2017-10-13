<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Mutation;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   
    public function index()
    {   
        $mutations = Mutation::all();
        
        return view('dashboard', compact('mutations'));
    }
}
