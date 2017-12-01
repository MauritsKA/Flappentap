<?php

namespace App\Http\Controllers;

use App\Balance;
use App\Mutation;
use App\Invitation;
use Storage;
use App\Mail\Invitationmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Session;
use Request;

class BalanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['invitation']]);
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
        
        $i = 1;
        while(request('email'.$i)){
            $nickname = request('member'.$i);
            $email = request('email'.$i);
            $i++;
            
            $checkuser = \App\User::where('email',$email)->first();
            if($checkuser){
                $user_id = $checkuser->id;
            } else {
                $user_id = null;
            }
            
            $token = 'B'.$id.str_random(30);
            while (\App\Invitation::where('token',$token)->first()){
                $token = 'B'.$id.str_random(15);
            } 
            
            $invitation = \App\Invitation::create([
                'balance_id' => $id,
                'email' => $email,
                'nickname' => $nickname,
                'user_id' => $user_id,
                'token' => $token,
            ]);
            
            $url = url('invitation').'/'.$token;
            \Mail::to($email)->send(new Invitationmail($user,$balance,$url));
        }
        
        return redirect('/dashboard')->with('status', 'Succesfully added balance!');
    }
    
    public function invitation(Invitation $invitation){
        
        session(['urlinvite' => Request::url()]); 
        $balance = $invitation->balance;
        $user = $invitation->user;
        if(!$user){
        $user = \App\User::where('email',$invitation->email)->first();
        }    
    
        if(!$user){
            Auth::logout();
            
            return redirect('/register');
        } else {
            if(!Auth::check()){
            return redirect('/login');
            }
        }

        if($user->email == Auth::user()->email){
            
            if(!$invitation->nickname){$nickname=$user->name;} else{ $nickname = $invitation->nickname;}
            
            if(!$balance->users()->where('id',$user->id)->first()){
            $balance->users()->attach($user->id);
            $balance->users()->updateExistingPivot($user->id, ['nickname' => $nickname]);
            return redirect('/balances/'.$balance->balance_code)->with('status', 'You are succesfully added to the balance!');
            } 
            else { 
            return redirect('/balances/'.$balance->balance_code)->with('status', 'You already accepted the invitation.');
            }
            
        } else{
            return redirect('/dashboard');      
        }
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
