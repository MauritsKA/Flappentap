<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Balance;
use App\Mutation;
use App\Mutationtype;
use App\Vattype;
use App\Version;
use Auth;

class MutationController extends Controller
{
      public function __construct(Balance $balance)
    {
        $this->middleware('auth');
    }
    
    
    public function create(Balance $balance)
    { 
        $users = $balance->users;
        
        $checkweight = 0;
        foreach($users as $user){
            $tempweight = request($user->id);
            $checkweight += $tempweight;
        }
        
        if($checkweight == 0){
              return redirect()->back()->withInput()->with('alert', 'You did not state who should pay');
        }
        
        $mutation= Mutation::orderBy('id', 'desc')->where('balance_id', $balance->id)->first();
        
        if($mutation == null){ $mutation_count = 1; } 
        else { $mutation_count = $mutation->mutation_count + 1; }
        
        $mutation = Mutation::create([
            'balance_id' => $balance->id,
            'mutation_count' => $mutation_count,
            'user_id' =>  request('user'),
            'dated_at' => request('date'),
            'size' => request('size'),
            'description' => request('description'),
            'show' => true,
        ]);
        
        $version = Version::create([
            'mutation_id' => $mutation->id,
            'version_count' => 1,
            'updatetype' => "create",
            'user_id' => request('user'),
            'editor_id' => Auth::user()->id,
            'dated_at' => request('date'),
            'size' => request('size'),
            'description' => request('description'),
        ]);
        
        foreach($users as $user){
            $weight = request($user->id);
            if($weight != 0 || null){
            $version->users()->attach($user->id);
            $version->users()->updateExistingPivot($user->id, ['weight' => $weight]);
            }
        }
        
        Mutation::find($mutation->id)->update(['PP'=>($mutation->size)/($version->users->sum('pivot.weight'))]);
        
        return back()->with('status', 'Succesfully added payment');
    }
    
    public function edit(Balance $balance, $mutation_count)
    { 
        $archivedusers = $balance->users->where('pivot.archived',1);
        
        if( count($archivedusers) > 0 ){
            return redirect()->back()->withInput()->with('alert', 'You are trying to edit a payment that is connected to a removed user. This is not possible!');
        }
        
        $mutation = Mutation::where('balance_id', $balance->id)->where('mutation_count',$mutation_count)->get()->first();
        
        $version = Version::orderBy('version_count', 'desc')->where('mutation_id', $mutation->id)->first();
        
        $oldusers = $version->users;       
        
        Mutation::find($mutation->id)->update([
            'user_id'=>request('user'), 
            'dated_at' => request('date'),
            'size' => request('size'),
            'description' => request('description')
        ]);
        
        $version = Version::create([
            'mutation_id' => $mutation->id,
            'version_count' => (1+$version->version_count),
            'updatetype' => "edit",
            'user_id' => request('user'),
            'editor_id' => Auth::user()->id,
            'dated_at' => request('date'),
            'size' => request('size'),
            'description' => request('description'),
        ]);
                
        $users = $balance->users;
        foreach($users as $user){
            
            $weight = request($user->id);
            
            if($weight != 0 || null){
            $version->users()->attach($user->id);
            $version->users()->updateExistingPivot($user->id, ['weight' => $weight]);
            }
        }
        
        foreach($archivedusers as $archiveduser){
            if($oldusers->contains($archiveduser->id)){
                $weight = $oldusers->where('id',$archiveduser->id)->pluck('pivot.weight')->first();
                $version->users()->attach($archiveduser->id);
                $version->users()->updateExistingPivot($archiveduser->id, ['weight' => $weight]);
            }
        }
        
        Mutation::find($mutation->id)->update(['PP'=>($version->size)/($version->users->sum('pivot.weight'))]);
        
        $mutation->update(['show'=>true]);
        
        return back();
    }
    
    public function delete(Balance $balance, $mutation_count)
    { 
        $archivedusers = $balance->users->where('pivot.archived',1);
        
        if( count($archivedusers) > 0 ){
            return back()->withInput()->with('alert', 'You are trying to delete a payment that is connected to a removed user. This is not possible!');
        }
        
        $mutation = Mutation::where('balance_id', $balance->id)->where('mutation_count',$mutation_count)->get()->first();
        
        if($mutation->show == 1){
        $mutation->update(['show'=>false]);
            
        $oldversion = Version::orderBy('version_count', 'desc')->where('mutation_id', $mutation->id)->first();
            
        $version = Version::create([
            'mutation_id' => $mutation->id,
            'version_count' => (1+$oldversion->version_count),
            'updatetype' => "delete",
            'user_id' => $oldversion->user->id,
            'editor_id' => Auth::user()->id,
            'dated_at' => $oldversion->dated_at,
            'size' => $oldversion->size,
            'description' => $oldversion->description,
        ]);
               
        foreach($oldversion->users as $user){
            $weight = $oldversion->users->where('id',$user->id)->pluck('pivot.weight')->first();
            $version->users()->attach($user->id);
            $version->users()->updateExistingPivot($user->id, ['weight' => $weight]);
        }
        }
        
        return back();
            
    }
    
}
