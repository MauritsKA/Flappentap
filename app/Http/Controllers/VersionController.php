<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Balance;
use App\Mutation;
use App\Version;
use Auth;

class VersionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Balance $balance, $mutation_count)
    {    
        
        $mutation = Mutation::where('balance_id', $balance->id)->where('mutation_count',$mutation_count)->first();
        
        $versions = $mutation->versions;
        
        return view('version', compact('versions', 'mutation', 'balance'));
    }
    
    public function history(Balance $balance)
    {    
        $user = Auth::user();
        $mutations = $balance->mutations;
        $users = $balance->users;
        
        $versions=[];
        foreach($mutations as $mutation){
            $versionspermutation = $mutation->versions;
            $versions= $versionspermutation->merge($versions);
        }
        
        $versions = $versions->sortByDesc('updated_at')->all();
        
        return view('history', compact('versions', 'balance'));
    }
}
