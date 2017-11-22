@extends('layouts.master')

@section('content')

<div class="container">
      <div class="mt-3">
        <h1>Profile</h1>
      </div>
    <hr> 
 
<h5>Hi {{ $user->name}} </h5>
<br>

<h5>Email</h5>
<p>{{ $user->email}}</p> 
<form class="form-inline" method="POST" id="emailform" action="{{ url('profile/email')}}">
{{ csrf_field() }}  
        
<div class="form-group">
<input type="text" class="form-control" id="email" name="email" placeholder="new email" required>    
</div> 
&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-primary">Submit</button>
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
        
<div class="form-group">
<input type="text" class="form-control" id="iban" name="iban" placeholder="new IBAN" required>    
</div> 
&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-primary">Submit</button>
</form>   
    

    
</div>



  
@endsection





                           
