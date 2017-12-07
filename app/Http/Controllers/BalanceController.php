<?php

namespace App\Http\Controllers;

use App\Balance;
use App\Mutation;
use App\Invitation;
use App\Mail\Userdelete;
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
        $this->middleware('auth');
    }
    
    public function index(Balance $balance)
    {   
        $user = Auth::user();
        
        $mutations = Mutation::where('balance_id', $balance->id)->orderBy('updated_at','desc')->get();
    
        $otherusers = $balance->users->where('pivot.archived',false)->whereNotIn('id',$user->id);
        
        $thisuser = $balance->users->where('pivot.archived',false)->where('id',$user->id);
        
        $users = $thisuser->merge($otherusers);

        $debtoverview=[];
        $creditoverview=[];
        foreach($users as $user){
            $totaldebt = 0;
            $totalcredit = 0;
            
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
        }
        
        return view('balance', compact('balance','user','mutations','users','creditoverview','debtoverview'));
    }
    
    public function balance(Balance $balance){
        return view('balanceinfo', compact('balance'));
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
        $balance->users()->updateExistingPivot($user->id, ['admin' => true]);
        
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
    
    public function editcover(Balance $balance)
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
    
    public function removeuser(Balance $balance, $user_id)
    {
        $removeduser=\App\User::where('id',$user_id)->get()->first();
        $mutations = $balance->mutations; 
        
        $totaldebt = 0;
        $totalcredit = 0;
        foreach($mutations as $mutation){
            $version = $mutation->versions->last();
                
            if($version->updatetype != 'delete'){
                $debt = $version->users->where('id',$removeduser->id)->pluck('pivot.weight')->first()*$mutation->PP;
                $totaldebt = $debt+$totaldebt;
                
                if($version->user->id == $removeduser->id){
                $totalcredit = $version->size+$totalcredit; 
                }
            }        
        }
        
        $result = $totalcredit-$totaldebt; 
        if($result < 0.01 && $result > -0.01){
            
        $token = 'B'.$balance->id.str_random(30);
        while (\App\Invitation::where('token',$token)->first()){
            $token = 'B'.$balance->id.str_random(30);
        } 
        $editor = Auth::user();  
            
        $approval = \App\Approval::create([
                'type' => 'removal',
                'balance_id' => $balance->id,
                'user_id' => $removeduser->id,
                'editor_id' => Auth::user()->id,
                'token' => $token,
        ]);
            
        $url = url('approval').'/'.$token;
            
        $admins = $balance->users->where('pivot.admin',1)->all();
            
        foreach($admins as $admin){
            \Mail::to($admin->email)->send(new Userdelete($editor,$balance,$url,$removeduser,$admin));
        }
            
        return back()->with('status', 'Succesfully sent approval to admins for removal of '. $removeduser->name); 
         
        } else {
            return back()->with('alert', 'Cannot remove '. $removeduser->name. ' as debt is not zero!');
        }
    }
    
    public function edituser(Balance $balance, $user_id)
    {

        $balance->users()->updateExistingPivot($user_id, ['nickname' => request('newnickname')]);
        
        return back();
    }
    
    public function edit(Balance $balance){
        if(!request('balancename')){
        
        $user = Auth::user();
        
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
            
            $token = 'B'.$balance->id.str_random(30);
            while (\App\Invitation::where('token',$token)->first()){
                $token = 'B'.$balance->id.str_random(30);
            } 
            
            $invitation = \App\Invitation::create([
                'balance_id' => $balance->id,
                'email' => $email,
                'nickname' => $nickname,
                'user_id' => $user_id,
                'token' => $token,
            ]);
            
            $url = url('invitation').'/'.$token;
            \Mail::to($email)->send(new Invitationmail($user,$balance,$url));
        }
        
        return redirect('/balances/'.$balance->balance_code)->with('status', 'Succesfully invited new user');
        } else{
         Balance::find($balance->id)->update(['name'=>request('balancename')]);  
         return redirect('/balances/'.$balance->balance_code)->with('status', 'Succesfully changed balance name.');
        }
    }
}
