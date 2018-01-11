@extends('layouts.master')

@section('content')


<div class="container">
    
      <div class="mt-3">
        <h1>Create new balance</h1>
      </div>
    <hr>  
    
    @if (session('alert'))
        <div class="col-sm-6 alert alert-warning">
        {{ session('alert') }}
        </div>
    @endif
        
    <form id="upload-form" method="POST" action="{{ url('balances/create')}}" enctype="multipart/form-data">
        {{ csrf_field() }}
        
<div class="row">
    <div class="col-md-6">        
    <div class="form-group">
    <label for="name">Balance name</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="" value="{{ old('name') }}" required>
    </div>
    </div>
    
    <div class="col-md-6">
    <div class="form-group">
    <label>Add picture</label><br>
    <label class="btn-file">
    <input accept="image/*" type="file" name="cover" id="cover" data-max-size="2097152"></label>
    </div>
    </div>
            
</div>
<hr>
        
    <h3>Add users to balance</h3><br>
<div class="form-group row">
    <div class="col-sm-1">
    <label for="user" "col-form-label">Email</label>
    </div>
    <div class="col-md-5">
    <input type="text" class="form-control" id="email1" name="email1" placeholder="" value="{{ old('email1') }}" required>
    </div>
        
    <div class="col-sm-1">
    <label for="user">Name</label></div>
    <div class="col-md-5">
    <input type="text" class="form-control" id="member1" name="member1" placeholder="" value="{{ old('member1') }}" required>
    </div>
</div>
        
<div id="usercontainer">
</div>  
        
<div class="row">
    <div class="col-md-2">
    <a onclick="appendform(null,null)"><img class="btnextra" src="{{url('/images/plus.png')}}" height="25" width="25"></a>&nbsp;&nbsp;
    <a onclick="cutform()"><img class="btnextra" src="{{url('/images/minus.png')}}" height="25" width="25"></a>
    </div>
</div><br>
    
   <button onclick="checkSize();"  type="submit" value="Upload" class="btn btn-primary">Create!</button>
        
    </form>
</div>

@if(session('usernumber') != null) 
<script>
var old_emails = null;
var old_members = null;

<?php $i = session('usernumber'); 

if($i > 1){
        $oldemails[] = null;
        $oldmembers[] =  null;
    $second = old('email'.$i);
    for($j = 0; $j <= $i-2; $j++){
        $oldemails[$j] =  old('email'.($j+2));
        $oldmembers[$j] =  old('member'.($j+2));
    }

    $old_emails = json_encode($oldemails);
    $old_members = json_encode($oldmembers);
    
    echo "var old_emails = ". $old_emails . ";\n";
    echo "var old_members = ". $old_members . ";\n";

}
?>

    if ({{$i}} > 1 ) {    
       for (nr = 1; nr < {{$i}}; nr++) {  
        var old_email = old_emails[nr-1];
        var old_member = old_members[nr-1];
        appendform(old_email, old_member);
        } 
    }

</script>
@endif


<script>
  $(function(){
    $('#upload-form').submit(function(e){
        var fileInput = $('#cover');
        var maxSize = fileInput.data('max-size');
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





                           
