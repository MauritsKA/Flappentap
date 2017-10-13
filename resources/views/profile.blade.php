@extends('layouts.master')

@section('content')

<div class="container">
      <div class="mt-3">
        <h1>Profile</h1>
      </div>
    <hr> 
    
    <p>Logged in as: <br> {{ $user->name}} </p> 
    <p>Your email: <br> {{ $user->email}} </p> 
    
</div>


  
@endsection





                           
