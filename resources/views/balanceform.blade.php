@extends('layouts.master')

@section('content')


<div class="container">
    
      <div class="mt-3">
        <h1>Add your list</h1>
      </div>
    <hr>    
        
    <form method="POST" action"{{ url('lists/create')}}" enctype="multipart/form-data">
        {{ csrf_field() }}
        
    <div class="row">
        <div class="col-md-6">
            
    <div class="form-group">
    <label for="name">List name</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="" required>
    </div>
  
    
    <div class="form-group">
    <label class="btn-file">
    <img src="../../public/images/file_1.png" height="25" width="25"> 
    <input type="file" name="cover" id="cover" ></label>
    </div>
    
   <button type="submit" value="Upload" class="btn btn-primary">Create!</button>
    
        </div>
    
      
        
      </div>
        
    </form>
</div>



  
@endsection





                           
