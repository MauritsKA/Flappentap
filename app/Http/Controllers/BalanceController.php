<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Balance;
use App\Mutation;
use Storage;
use Auth;
use user;

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
        $users = $balance->users;
        
        return view('balance', compact('balance','user','mutations','users'));
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
        $code = 'B'. $id. str_random(10);
        
        Balance::find($id)->update(['balance_code'=>$code]);
        
        if(request('cover') != null){
        $cover = request('cover');
        $cover_name = $code.'.'.$cover->getClientOriginalExtension();
        Balance::find($id)->update(['cover_name'=>$cover_name]);
        $cover->move('../storage/uploads/covers', $cover_name);
        }   
        
        $balance->users()->attach($user->id);
        
        return redirect('/dashboard');
    }
    
    public function edit(Balance $balance)
    {
        $user = Auth::user();
        
        $id = $balance->id;
        $code = $balance->balance_code; 
        
        $base = base_path();
        
        if(request('cover') != null){
        unlink($base. '/storage/uploads/covers/'. $balance->cover_name); 
        $cover = request('cover');
        $cover_name = $code.'.'.$cover->getClientOriginalExtension();
        Balance::find($id)->update(['cover_name'=>$cover_name]);
        $cover->move('../storage/uploads/covers', $cover_name);
        }       
        
        return back();
    }
    
    public function edituser(Balance $balance, $user_id)
    {

        $balance->users()->updateExistingPivot($user_id, ['nickname' => request('newnickname')]);
        
        return back();
    }
}
