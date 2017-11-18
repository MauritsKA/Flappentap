<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Balance;
use App\Mutation;
use App\Mutationtype;
use App\Vattype;
use App\Version;
use Auth;

class MutationController extends Controller
{
      public function __construct(Company $company)
    {
        $this->middleware('auth');
    }
    
    
    public function create(Balance $balance)
    { 
            
        $mutation= Mutation::orderBy('id', 'desc')->where('balance_id', $balance->id)->first();
        
        if($mutation == null){ $mutation_count = 1; } 
        else { $mutation_count = $mutation->mutation_count + 1; }
        
        $mutation = Mutation::create([
            'balance_id' => $balance->id,
            'mutation_count' => $mutation_count,
            'version_id' => 1,
            'user_id' =>  Auth::user()->id,
            'dated_at' => request('date'),
            'size' => request('size'),
            'description' => request('description'),
            'show' => true,
        ]);
        
        $mutation_id= Mutation::orderBy('id', 'desc')->where('balance_id', $balance->id)->first()->id;
        
        $version = Version::create([
            'mutation_id' => $mutation_id,
            'version_count' => 1,
            'updatetype' => "create",
            'user_id' => Auth::user()->id,
            'dated_at' => request('date'),
            'size' => request('size'),
            'description' => request('description'),
        ]);
        
        return back()->withInput();
    }
    
    public function delete(Balance $balance, $mutation_count)
    { 
      
        $mutation = Mutation::where('balance_id', $balance->id)->where('mutation_count',$mutation_count)->get()->first();
        
        Mutation::find($mutation->id)->update(['show'=>false]);
        
        $version = Version::orderBy('version_count', 'desc')->where('mutation_id', $mutation->id)->first();
            
        $version = Version::create([
            'mutation_id' => $mutation->id,
            'version_count' => (1+$version->version_count),
            'updatetype' => "delete",
            'user_id' => Auth::user()->id,
            'dated_at' => $version->dated_at,
            'size' => $version->size,
            'description' => $version->description,
        ]);
        
        return back();
            
    }
    
    public function oldcreate(Company $company)
    { 
    
        $size = request('size');
        $vatfraction = Vattype::where('id',request('vattype_id'))->pluck('fraction')->first(); 
        $basicsize = $size / (1+$vatfraction); 
        $vatsize = $size - $basicsize;
        
        $mutation= Mutation::orderBy('id', 'desc')->where('company_id', $company->id)->first();
        
        if($mutation == null){
            $mutation_count = 1;
        } 
        else {
            $mutation_count = $mutation->mutation_count + 1;
        }
        
        $mutation = Mutation::create([
            'company_id' => $company->id,
            'mutation_count' => $mutation_count,
            'version_id' => 1,
            'user_id' =>  Auth::user()->id,
            'dated_at' => request('date'),
            'size' => $size,
            'description' => request('description'),
            'item_id' => request('item_id'),
            'mutationtype_id' => request('mutationtype_id'),
            'vattype_id' => request('vattype_id'),
            'basic_size' => $basicsize,
            'vat_size' => $vatsize,
            'show' => true,
        ]);
        
        $mutation_id= Mutation::orderBy('id', 'desc')->where('company_id', $company->id)->first()->id;
        
        $version = Version::create([
            'mutation_id' => $mutation_id,
            'version_count' => 1,
            'updatetype_id' => 1,
            'user_id' => Auth::user()->id,
            'dated_at' => request('date'),
            'size' => $size,
            'description' => request('description'),
            'item_id' => request('item_id'),
            'mutationtype_id' => request('mutationtype_id'),
            'vattype_id' => request('vattype_id'),
        ]);
        
        
        return back()->withInput();
    }
}
