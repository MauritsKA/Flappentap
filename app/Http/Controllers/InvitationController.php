<?php

namespace App\Http\Controllers;

use App\Balance;
use App\Mutation;
use App\Invitation;
use App\Approval;
use Storage;
use App\Mail\Invitationmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Session;
use Request;

class InvitationController extends Controller
{
    public function __construct()
    {
       
    }
        
    public function accept(Invitation $invitation){
        
        session(['urlinvite' => Request::url()]); 
        session(['emailinvite' => $invitation->email]); 
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
            
            if(!$balance->users->where('id',$user->id)->first()){
                $balance->users()->attach($user->id);
                $balance->users()->updateExistingPivot($user->id, ['nickname' => $nickname]);
                return redirect('/balances/'.$balance->balance_code)->with('status', 'You are succesfully added to the balance!');
            } 
            elseif($balance->users->where('id',$user->id)->pluck('pivot.archived')->first() == 1) {
                $balance->users()->updateExistingPivot($user->id, ['archived' => false]);
                return redirect('/balances/'.$balance->balance_code)->with('status', 'You are succesfully rassigned to the balance!');
            }
            else { 
                return redirect('/balances/'.$balance->balance_code)->with('alert', 'You already accepted the invitation.');
            }
            
        } else{
            Auth::logout();
            return redirect('/login');    
        }
    }
    
    public function approval(Approval $approval){
        
        if($approval->type == 'UserRemoval'){
            return $this->userremoval($approval);
        } 
        
        if($approval->type == 'BalanceDelete'){
            return $this->balancedelete($approval); 
        }
    }
    
    public function userremoval(Approval $approval){
        session(['urlapprove' => Request::url()]);
        
        if(!Auth::check()){
            return redirect('/login');
        } 
        
        $balance = $approval->balance;
        $user = $approval->user;
        
        if($balance->users->where('id',Auth::user()->id)->pluck('pivot.admin')->first() == 1 ){ 
            
        if($balance->users->sum('pivot.admin') == 1 && $balance->users->where('pivot.admin',1)->first()->id == $user->id){
            return redirect('/balances/'.$balance->balance_code)->with('alert', $user->name. ' cannot be removed as long as there are no other admins. Admins can be assigned by the current admin.');
        }
            
        if($balance->users->where('id',$user->id)->pluck('pivot.archived')->first() == 0){
            $balance->users()->updateExistingPivot($user->id, ['archived' => true]);
            
            Approval::find($approval->id)->update(['approved'=>true]);
            
            return redirect('/balances/'.$balance->balance_code)->with('status', 'You succesfully removed '. $user->name .'!');
            
        } else {
            return redirect('/balances/'.$balance->balance_code)->with('alert', $user->name. ' is already removed!');
        }
        } else {
            return redirect('/balances/'.$balance->balance_code)->with('alert', 'You are not permitted to execute this approval'); 
        }
    }
    
    public function balancedelete(Approval $approval){
        session(['urlapprove' => Request::url()]);
        session(['emailinvite' => $approval->user->email]); 
                
        if(!Auth::check()){
            return redirect('/login');
        }
        
        $balance = $approval->balance;
        $user = $approval->user;
        
        if($user->id != Auth::user()->id){
            Auth::logout();
            return redirect('/login');
        }
                
        if($user->id == Auth::user()->id){
            if($approval->approved == true){
                return redirect('/balances/'.$balance->balance_code)->with('alert', 'You already confirmed.');
            }
        Approval::find($approval->id)->update(['approved'=>true]);
        }
        
        $users = $balance->users->where('pivot.archived',0);
        $usercount= $users->count();
        
        $count = 0;
        foreach($users as $user){
             if(Approval::where('user_id',$user->id)->where('type','BalanceDelete')->where('balance_id',$balance->id)->get()->pluck('approved')->first() == true){
                $count++;
             }
        }
        
        if($count == $usercount){
            Balance::find($balance->id)->update(['archived'=>true]);
        
            app('App\Http\Controllers\BalanceController')->confirmremove($balance);
        
        } else {
            return redirect('/balances/'.$balance->balance_code)->with('status', 'You succesfully approved the removal! You\'re still waiting on other approvals.'); 
        }
        
       
    }
}