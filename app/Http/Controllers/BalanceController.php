<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Balance;
use Auth;

class BalanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
        $cover_name = $balance->id.'.'.$cover->getClientOriginalExtension();
        Balance::find($id)->update(['cover_name'=>$cover_name]);
        $cover->move('uploads', $cover_name);
        }       
        
        return redirect('/dashboard');
    }
}
