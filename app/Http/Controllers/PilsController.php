<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pils;

class PilsController extends Controller
{
     public function pils($userid)
    {
        $user = User::where('id',$userid)->first();

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
