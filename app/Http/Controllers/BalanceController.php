<?php

namespace App\Http\Controllers;

use App\Balance;
use App\Mutation;
use App\Invitation;
use App\Mail\Userdelete;
use App\Mail\Balancedelete;
use App\Mail\Balancedeleteconfirm;
use App\Mail\Adminmail;
use Storage;
use App\Mail\Invitationmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Session;
use Request;
use PDF;
use App\Version;
use App\Jobs\SendAdminEmail;
use App\Jobs\SendUserDeleteEmail;
use App\Jobs\SendInvitationEmail;
use App\Jobs\SendDeleteBalanceEmail;

class BalanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

     public function setmax(Balance $balance,$setmax)
    {   
        session(['take_max' => $setmax]);
        return redirect('balances/'.$balance->balance_code);
    }
       
    
    public function index(Balance $balance)
    {   
       
        $value = session('take_max');
        if (!$value){
             session(['take_max' => 10]);
        }


        if($balance->archived == true){
            return back();
        }
        
        $user = Auth::user();
        
        $mutations = Mutation::where('balance_id', $balance->id)->orderBy('updated_at','desc')->orderBy('dated_at','desc')->get();
    
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
        
        $netsum = array_sum($debtoverview)-array_sum($creditoverview);
        
        $mutations = $mutations->take(session('take_max'));

        if($netsum <= -.01 || $netsum >= 0.01){
            Session::flash('alert', 'Something doesn\'t add up. The net sum = &euro;'.$netsum.'! Please contact support.'); 
            
            return view('balance', compact('balance','user','mutations','users','creditoverview','debtoverview'));
        }
        
        return view('balance', compact('balance','user','mutations','users','creditoverview','debtoverview'));
    }
    
    public function balance(Balance $balance){
        if($balance->archived == true){
            return back();
        }
        return view('balanceinfo', compact('balance'));
    }
    
    
    public function form()
    {
        return view('balanceform')->with('usernumber',null);
    }
    
    public function create()
    {        
        $user = Auth::user();
              
        $checkemail = true; 
        $i = 1;
        while(request('email'.$i)){
            $email = request('email'.$i);
            $result = filter_var($email, FILTER_VALIDATE_EMAIL);
            if($result == false){ $checkemail = false; }
            $i++;
        }
        
        if($checkemail == false){
            return redirect()->back()->withInput()->with('alert', 'You entered an incorrect email.')->with('usernumber',$i-1);
        }            
        
        if(filesize(request('cover')) >= 2097152){
              return redirect()->back()->withInput()->with('alert', 'The file you uploaded is too large.')->with('usernumber',$i-1);
        }
        
       $balance = Balance::create([
            'name' => request('name'),
            'user_id' =>  $user->id,
        ]);
        
        $id = $balance->id;
        $code = 'B'. $id. str_random(10);
        
        Balance::find($id)->update(['balance_code'=>$code]);
        
        if(request('cover') != null){
        $cover = request('cover');
        $cover_name = $code.str_random(5).'.'.$cover->getClientOriginalExtension();
        Balance::find($id)->update(['cover_name'=>$cover_name]);
        $cover->move('../public/storage/uploads/covers', $cover_name);
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
            
            $this->dispatch(new SendInvitationEmail($email, $user,$balance,$url));
        
        }
        
        return redirect('/dashboard')->with('status', 'Succesfully added balance!');
    }
    
    public function editcover(Balance $balance)
    {
        $user = Auth::user();
        
        $id = $balance->id;
        $code = $balance->balance_code; 
        
        if(filesize(request('cover')) >= 2097152){
              return back()->with('alert', 'The file you uploaded is too large.');
        }
        
        $base = base_path();
        
        if(request('cover') != null){
            if($balance->cover_name != "default.jpg"){
            unlink($base. '/public/storage/uploads/covers/'. $balance->cover_name);
            }
        $cover = request('cover');
        $cover_name = $code.str_random(5).'.'.$cover->getClientOriginalExtension();
        Balance::find($id)->update(['cover_name'=>$cover_name]);
        $cover->move('../public/storage/uploads/covers', $cover_name);
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
                'type' => 'UserRemoval',
                'balance_id' => $balance->id,
                'user_id' => $removeduser->id,
                'editor_id' => Auth::user()->id,
                'token' => $token,
        ]);
            
        $url = url('approval').'/'.$token;
            
        $admins = $balance->users->where('pivot.admin',1)->where('pivot.archived',0)->all();
            
        foreach($admins as $admin){
           
            
            $this->dispatch(new SendUserDeleteEmail($editor,$balance,$url,$removeduser,$admin)); 
        }
            
        return back()->with('status', 'Succesfully sent request to the admins for the removal of '. $removeduser->name); 
         
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
         Balance::find($balance->id)->update(['name'=>request('balancename')]);
        
         return redirect('/balances/'.$balance->balance_code)->with('status', 'Succesfully changed balance name.');
        
    }
    
    public function addusers(Balance $balance){        
        $user = Auth::user();
        
        $checkemail = true; 
        $i = 1;
        while(request('email'.$i)){
            $email = request('email'.$i);
            $result = filter_var($email, FILTER_VALIDATE_EMAIL);
            if($result == false){ $checkemail = false; }
            $i++;
        }
        
        if($checkemail == false){
            return redirect()->back()->withInput()->with('alert', 'You entered an incorrect email.')->with('usernumber',$i-1);
        }   
                
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
            
           $this->dispatch(new SendInvitationEmail($email, $user,$balance,$url));
        }
        
        return redirect('/balances/'.$balance->balance_code)->with('status', 'Succesfully invited new user');
    }
    
    public function admin(Balance $balance){ 
        
        $inviter = Auth::user();
        
        $user = \App\User::where('email',request('adminemail'))->first();
                
        if($user == null){
            
            return back()->with('alert', 'This is not a valid email.');
            
        } elseif(!$balance->users->contains('id',$user->id)){
             
            return back()->with('alert', 'This email does not correspond with a member of this balance.');
            
        } elseif($balance->users->where('id',$user->id)->pluck('pivot.archived')->first()){
            
             return back()->with('alert', 'This user has been removed from the balance. Add the user before assigning as admin.');
            
        }
                    
        $balance->users()->updateExistingPivot($user->id, ['admin' => true]);
        
        $this->dispatch(new SendAdminEmail($user,$balance,$inviter)); 
        
        return redirect('/balances/'.$balance->balance_code)->with('status', 'Succesfully added new admin');
    }
    
    public function remove(Balance $balance)
    {    
        $users = $balance->users->where('pivot.archived',0)->all();
        
        foreach($users as $user){
        
        $token = 'B'.$balance->id.str_random(30);
        while (\App\Invitation::where('token',$token)->first()){
            $token = 'B'.$balance->id.str_random(30);
        } 
        
        $editor = Auth::user();  
            
        $approval = \App\Approval::create([
                'type' => 'BalanceDelete',
                'balance_id' => $balance->id,
                'editor_id' => Auth::user()->id,
                'user_id' => $user->id,
                'token' => $token,
        ]);
            
        $url = url('approval').'/'.$token;
          
        $this->dispatch(new SendDeleteBalanceEmail($editor,$balance,$url,$user));     
        }
            
        return back()->with('status', 'Succesfully sent request to all users for the removal of this balance'); 
         
    }  
    
     public function downloadPDF(Balance $balance)
    {
        $user = Auth::user();
        $pdf = getPDF($balance,$user);
        
        if($pdf == false){
            return back()->with('alert', 'No payments found to save as PDF yet.');
        }
        return $pdf->download($balance->name.'.pdf');
    }
        
}
