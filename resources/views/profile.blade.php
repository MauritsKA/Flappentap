@extends('layouts.master')

@section('content')

<div class="container">
      <div class="mt-3">
        <h1>Profile</h1>
      </div>
    <hr>
    @if (session('status'))
        <div class="col-sm-4 alert alert-success">
        {{ session('status') }}
        </div>
    @endif
 
<h5>Hi {{ $user->name}}, </h5>
<br>


<h5>Email</h5>
<p>{{ $user->email}}</p> 
<form class="form-inline" method="POST" id="emailform" action="{{ url('profile/email')}}">
{{ csrf_field() }}  
        

<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="email" name="email" placeholder="new email" required>    

<button type="submit" class="btn btn-primary">Submit</button>
</form>
    
     @if ($errors->has('email'))
        <span class="help-block">
        {{ $errors->first('email') }}
        </span>
    @endif
<br>
    
<h5>IBAN</h5>    
<p>{{ $user->iban}} </p>     
<form class="form-inline" method="POST" id="ibanform" action="{{ url('profile/iban')}}">
{{ csrf_field() }}  
        
<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="iban" name="iban" placeholder="new IBAN" required>    

<button type="submit" class="btn btn-primary">Submit</button>
</form>   
<br>
    
<h5>Password</h5>    

<form class="form-inline" method="POST" id="passwordform" action="{{ url('profile/password')}}">
{{ csrf_field() }}  

<input type="password" class="form-control mb-2 mr-sm-2 mb-sm-0" id="password" name="password" placeholder="new password" required>    

<input type="password" class="form-control mb-2 mr-sm-2 mb-sm-0" id="password_confirmation" name="password_confirmation" placeholder="confirm password" required>    

<button type="submit" class="btn btn-primary">Submit</button>
</form>   
    
@if ($errors->has('password'))
        <span class="help-block">
        {{ $errors->first('password') }}
        </span>
@endif    
    
</div>



  
@endsection





                           
