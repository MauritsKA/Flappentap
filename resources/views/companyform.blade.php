@extends('layouts.master')

@section('content')


<div class="container">
    
      <div class="mt-3">
        <h1>Add your company</h1>
      </div>
    <hr>    
        
    <form method="POST" action"{{ url('company/create')}}">
        {{ csrf_field() }}
        
    <div class="row">
        <div class="col-md-6">
            
    <div class="form-group">
    <label for="name">Company name </label>
    <input type="text" class="form-control" id="name" name="name" placeholder="" required>
    </div>
    
    <div class="form-group">
    <label for="email">Company email </label>
    <input type="email" class="form-control" id="email" name="email" required>
    </div>
    
    <div class="form-group">
     <label for="country">Country</label>
     <input type="text" class="form-control" id="country" name="country" required> 
      </div> 
            
        </div>
            
        
        <div class="col-md-6">
     
    
    <div class="form-group">
    <label for="city">City</label>
    <input type="text" class="form-control" id="city" name="city" required>
    </div> 
    
    <div class="form-group">
    <label for="address">Address </label>
    <input type="text" class="form-control" id="address" name="address">
    </div>
    
    <div class="form-group">
    <label for="postalcode">Postalcode </label>
    <input type="text" class="form-control" id="postalcode" name="postalcode">
    </div>  
    
        </div>
    
        <button type="submit" class="btn btn-primary">Create!</button>
        
      </div>
        
    </form>
</div>



  
@endsection





                           
