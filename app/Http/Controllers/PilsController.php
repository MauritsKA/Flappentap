<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pils;
use App\User;

class PilsController extends Controller
{
     public function pils(Request $request)
    {
    	$userid = request('user');
        $user = User::where('id',$userid)->first();

        $turf = Pils::create([
            'user_id' => $user->id,
        ]);
    }

     public function index()
    {       
    	$pilsjes = Pils::all();
        return view('pils', compact('pilsjes'));
    }
}
