<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pils;

class PilsController extends Controller
{
     public function pils(Request $request)
    {
        
        $user = request('user');

        $turf = Pils::create([
            'user_id' => $user,
        ]);
        
    }

     public function index()
    {       
    	$pilsjes = Pils::all();
        return view('pils', compact('pilsjes'));
    }
}
