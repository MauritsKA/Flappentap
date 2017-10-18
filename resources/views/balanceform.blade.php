@extends('layouts.master')

@section('content')


<div class="container">
    
      <div class="mt-3">
        <h1>Add your list</h1>
      </div>
    <hr>    
        
    <form id="upload-form" method="POST" action="{{ url('balances/create')}}" enctype="multipart/form-data">
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
    <input accept="image/x-png, image/gif, image/jpeg" type="file" name="cover" id="cover" data-max-size="2097152" ></label>
    </div>
    
   <button onclick="checkSize();"  type="submit" value="Upload" class="btn btn-primary">Create!</button>
    
        </div>
    
      
        
      </div>
        
    </form>
</div>


<script>
  $(function(){
    var fileInput = $('#cover');
    var maxSize = fileInput.data('max-size');
    $('#upload-form').submit(function(e){
        if(fileInput.get(0).files.length){
            var fileSize = fileInput.get(0).files[0].size; // in bytes
            if(fileSize>maxSize){
                alert('File size is more then 2 MB, please choose an other picture!');
                return false;
            }
        }
        
    });
});
</script>
  
@endsection





                           
