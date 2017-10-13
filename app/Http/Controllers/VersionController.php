<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Mutation;
use App\Mutationtype;
use App\Vattype;
use App\Version;
use Auth;

class VersionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function show(Company $company, $mutation_count)
    {    
        
        $mutation_id = Mutation::where('company_id', $company->id)->where('mutation_count',$mutation_count)->first()->id;
        
        $mutation = Mutation::where('id', $mutation_id)->first();
        $versions = $mutation->versions;
        
        $items = $company->items;
        $vattypes = $company->vattypes;        
        $mutationtypes = Mutationtype::all();

        return view('version', compact('versions', 'mutation', 'company', 'items', 'vattypes', 'mutationtypes'));
    }
}
