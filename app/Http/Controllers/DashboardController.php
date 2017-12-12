<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Mutation;
use Auth;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   
    public function index()
    {   
        $user = Auth::user();
        
        $balances = Auth::user()->balances->where('pivot.archived',0);
        
        $debtoverview=[];
        $creditoverview=[];
        foreach($balances as $balance){
           $mutations = $balance->mutations; 
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
        $lastweek = Carbon::now()->subWeek();
        
        $recentmutations = $user->versions->sortbyDesc('id')->unique('mutation_id')->where('updated_at','>',$lastweek)->take(10);
        
        return view('dashboard', compact('mutations','balances','creditoverview','debtoverview','recentmutations'));
    }
}
