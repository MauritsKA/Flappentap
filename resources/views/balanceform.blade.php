@extends('layouts.master')

@section('content')


<div class="container">
    
      <div class="mt-3">
        <h1>Add your list</h1>
      </div>
    <hr>    
        
    <form method="POST" action"{{ url('lists/create')}}">
        {{ csrf_field() }}
        
    <div class="row">
        <div class="col-md-6">
            
    <div class="form-group">
    <label for="name">List name</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="" required>
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





                           
