<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\List;
use Auth;

class ListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function form()
    {
        return view('balanceform');
    }
    
    public function create()
    {
        
       $user = Auth::user();
        
       $company = Company::create([
            'name' => request('name'),
            'user_id' =>  $user->id,
        ]);
        
        $id = $list->id;
        $code = 'L'. $id. str_random(10);
        
        List::find($id)->update(['balance_code'=>$code]);
        
        $list->users()->attach($user->id);
        
        return redirect('/dashboard');
        
    }
}
