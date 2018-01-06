<?php 

use App\Mutation;

function getPDF($balance,$user)
    {
        
        $mutations = $balance->mutations;
           
        $versions=null;
        $version1=null;
        foreach($mutations as $mutation){
           
            $versionpermutation = $mutation->versions->sortByDesc('updated_at')->first();
            if(!$versions){
                if(!$version1){
                    $version1 = $versionpermutation;
                } else {
                    $versions = collect([$version1, $versionpermutation]);
                }
            } else {
                $versions->push($versionpermutation);
            }
        }
        
    
        if($versions){
        $versions = $versions->sortByDesc('dated_at');
        } 
        
        if($version1 && !$versions){
           $versions = $version1; 
        } 
        
        if(!$version1 && !$versions){
            return false;
        }  
               
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

        
    	$pdf = PDF::loadView('pdfoverview', compact('versions', 'balance','creditoverview','debtoverview','users'));

		return $pdf;
}