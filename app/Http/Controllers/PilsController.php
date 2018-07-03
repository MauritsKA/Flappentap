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
               Krat::all()->sortByDesc('updated_at')->first()->delete();
            }else {
               Pils::all()->sortByDesc('updated_at')->first()->delete();
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

 public function turf()
    {    
     
        $balance = Balance::where('id',1)->first();
        $users = $balance->users->where('pivot.archived',false);

        $pilsdebtoverview=[];
        $pilscreditoverview=[];
        foreach($users as $user){
            $totalpilsdebt = $user->pils->count();
            $totalpilscredit = $user->kratten->count()*24;
                            
            array_push($pilsdebtoverview,$totalpilsdebt);
            array_push($pilscreditoverview,$totalpilscredit);
        }


        $pilsperdag = Pils::select('id', 'user_id', 'created_at')
        ->get()
        ->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('d/m/Y'); 
        })->all(); 

        $pilsperuser = Pils::select('id', 'user_id', 'created_at')
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

        return response()->json(['success' => true, 'debtoverview' => $debtoverview, 'creditoverview' => $creditoverview, 'pilsdebtoverview' => $pilsdebtoverview, 'pilscreditoverview' => $pilscreditoverview,'userids'=>$userids,'pilsperdag'=>$pilsperdag]);
    }

    public function deleteall(){
    	Pils::truncate();
    	Krat::truncate();

    	return back();
    }
}
