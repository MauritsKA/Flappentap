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
        
        $mutations = Mutation::where('balance_id', $balance->id)->orderBy('updated_at','desc')->get()->all();
        $users = $balance->users;
        
        $totaldebt = 0;
        $totalcredit = 0;
        $debtoverview=[];
        $creditoverview=[];
        foreach($users as $user){
            foreach($mutations as $mutation){
                $version = $mutation->versions->last();
                
                if($version->updatetype != 'delete'){
                    $debt = $version->users->where('id',$user->id)->pluck('pivot.weight')->first()*$mutation->PP;
                    $totaldebt = $debt+$totaldebt;
                
                    if($version->user->id == $user->id){
                    $totalcredit = $version->size+$totalcredit; 
                    }
                }
                
            }
            array_push($debtoverview,$totaldebt);
            array_push($creditoverview,$totalcredit);
            $totaldebt = 0;
            $totalcredit = 0;
        }
        
        return view('balance', compact('balance','user','mutations','users','creditoverview','debtoverview'));
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
        $balance->users()->updateExistingPivot($user->id, ['nickname' => $user->name]);
        
        return redirect('/dashboard');
    }
    
    public function edit(Balance $balance)
    {
        $user = Auth::user();
        
        $id = $balance->id;
        $code = $balance->balance_code; 
        
        $base = base_path();
        
        if(request('cover') != null){
            if($balance->cover_name != "default.jpg"){
            unlink($base. '/storage/uploads/covers/'. $balance->cover_name);
            }
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
