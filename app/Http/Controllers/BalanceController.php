<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Balance;
use App\Mutation;
use Auth;

class BalanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Balance $balance)
    {       
         $user = Auth::user();
        $mutations = Mutation::all();
        
        return view('balance', compact('balance','user','mutations'));
    }
    
    public function form()
    {
        return view('balanceform');
    }
    
    public function create()
    {
       $user = Auth::user();
       
       $balance = Balance::create([
            'name' => request('name'),
            'user_id' =>  $user->id,
        ]);
        
        $id = $balance->id;
        $code = 'L'. $id. str_random(10);
        
        Balance::find($id)->update(['balance_code'=>$code]);
        
        $balance->users()->attach($user->id);
        
        if(request('cover') != null){
        $cover = request('cover');
        $cover_name = $code.'.'.$cover->getClientOriginalExtension();
        Balance::find($id)->update(['cover_name'=>$cover_name]);
        $cover->move('../storage/uploads/covers', $cover_name);
        }       
        
        return redirect('/dashboard');
    }
    
    public function edit(Balance $balance)
    {
        $user = Auth::user();
        
        $id = $balance->id;
        $code = $balance->balance_code; 
        
        if(request('cover') != null){
        $cover = request('cover');
        $cover_name = $code.'.'.$cover->getClientOriginalExtension();
        Balance::find($id)->update(['cover_name'=>$cover_name]);
        $cover->move('../storage/uploads/covers', $cover_name);
        }       
        
        return back();
    }
}
