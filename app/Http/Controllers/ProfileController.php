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
}


