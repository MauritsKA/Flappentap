<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Mutation;
use Auth;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   
    public function index()
    {   
        $balances = Auth::user()->balances;
        $mutations = Mutation::all();
        
        
        return view('dashboard', compact('mutations','balances'));
    }
}
