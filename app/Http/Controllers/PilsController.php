<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pils;
use App\User;
use App\Balance;
use Auth; 
use App\Mutation;
use App\Version;
use App\Krat;
use Carbon\Carbon;

class PilsController extends Controller
{

     public function pils(Request $request)
    {
       	$userid = request('user');
    	$password = sha1(request('password'));
    	$krat = request('krat');

       	if($password == '26bfc225add76c1afc9736ae547b3752c0614341') {

            if($krat == 'true'){
    			$krat = Krat::create([
    	            'user_id' => $userid,
    	        ]);
            }else {
    	       $turf = Pils::create([
    	            'user_id' => $userid,
    	        ]);
            }

    	} // password protection
    } 

     public function delete(Request $request)
    {
       
        $userid = request('user');
        $password = sha1(request('password'));
        $krat = request('krat');

        if($password == '26bfc225add76c1afc9736ae547b3752c0614341') {

            if($krat == 'true'){
               Krat::all()->sortByDesc('updated_at')->where('user_id',$userid)->where('archived','false')->first()->update(['archived'=>true]);
            }else {
               Pils::all()->sortByDesc('updated_at')->where('user_id',$userid)->where('archived','false')->first()->update(['archived'=>true]);
            }

        } // password protection
    } 

     public function index()
    {         
        
    	$balance = Balance::where('id',1)->first();
    	$usernames = $balance->users->where('pivot.archived',false)->pluck('pivot.nickname')->all();
        $userids = $balance->users->where('pivot.archived',false)->pluck('id')->all();
        return view('pils', compact('usernames','userids'));
    }

     public function pilstotaal()
    {         
        $pilsen = Pils::all();
        return view('pilstotaal', compact('pilsen'));
    }

     public function krattotaal()
    {         
        $kratten = Krat::all();
        return view('krattotaal', compact('kratten'));
    }

 public function turf()
    {    
     
        $balance = Balance::where('id',1)->first();
        $users = $balance->users->where('pivot.archived',false);

        $pilsdebtoverview=[];
        $pilscreditoverview=[];
        foreach($users as $user){
            $totalpilsdebt = $user->pils->where('archived',false)->count();
            $totalpilscredit = $user->kratten->where('archived',false)->count()*24;
                            
            array_push($pilsdebtoverview,$totalpilsdebt);
            array_push($pilscreditoverview,$totalpilscredit);
        }


        $pilsperdag = Pils::select('id', 'user_id', 'created_at')->where('archived',false)
        ->get()
        ->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('d/m/Y'); 
        })->all(); 

        $pilsperuser = Pils::select('id', 'user_id', 'created_at')->where('archived',false)
        ->get()
        ->groupBy('user_id')->all(); 

        $mutations = Mutation::where('balance_id', $balance->id)->orderBy('updated_at','desc')->orderBy('dated_at','desc')->get();
   
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

      
        $userids = $users->pluck('id')->all();
        
        $usernames = [];
        foreach($userids as $userid){
            $nickname = User::where('id', $userid)->first()->balances->where('id', 1)->pluck('pivot.nickname')->first();

            array_push($usernames, $nickname);
        }

        return response()->json(['success' => true, 'debtoverview' => $debtoverview, 'creditoverview' => $creditoverview, 'pilsdebtoverview' => $pilsdebtoverview, 'pilscreditoverview' => $pilscreditoverview,'userids'=>$userids,'usernames'=>$usernames,'pilsperdag'=>$pilsperdag]);
    }

    // public function deleteall(){
    // 	Pils::truncate();
    // 	Krat::truncate();

    // 	return back();
    // }
}
