@extends('layouts.master')

@section('content')


<div class="container">
    
      <div class="mt-3">
        <h1>{{$balance->name}}</h1>
      </div>
    <hr> 
    
    @if (session('status'))
        <div class="col-sm-6 alert alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
        {{ session('status') }}
        </div>
    @endif
    
    @if (session('alert'))
        <div class="col-sm-6 alert alert-warning">
            <button type="button" class="close" data-dismiss="alert">×</button>
        {{ session('alert') }}
        </div>
    @endif
      
    <h5>Balance name</h5> 
    <form id="upload-form" class="form-inline" method="POST" action="{{ url('balances/')}}/{{$balance->balance_code}}/edit" >
        {{ csrf_field() }}
    
    <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="balancename" name="balancename" placeholder="" required>
        
    <button type="submit" class="btn btn-primary">Change</button>
        
    </form>
       @if ($errors->has('email'))
        <span class="help-block">
        {{ $errors->first('email') }}
        </span>
    @endif
    <br>
    
    @if($balance->users->where('id',Auth::user()->id)->pluck('pivot.admin')->first())
     <h5>Add admin</h5>
    <form id="upload-form" class="form-inline" method="POST" action="{{ url('balances/')}}/{{$balance->balance_code}}/admin">
        {{ csrf_field() }}
        
    <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="adminemail" name="adminemail" placeholder="Type email" required>
    
    <button type="submit" class="btn btn-primary">Submit</button>
        
    </form>
    <br>
    @endif
    
    <a href="{{url('download-pdf')}}/{{$balance->balance_code}}">Download as PDF</a>
    
<hr>
        
    <h3>Add users to balance</h3><br>
     <form id="upload-form" method="POST" action="{{ url('balances/')}}/{{$balance->balance_code}}/addusers">
        {{ csrf_field() }}
       
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

    
   <button onclick="checkSize();"  id="userbutton" type="submit" value="Upload" class="btn btn-primary">Invite users</button>
        
    </form>
    
       @if ($errors->has('email'))
        <span class="help-block">
        {{ $errors->first('email') }}
        </span>
    @endif
    
     <br><a href="{{url('balances')}}/{{$balance->balance_code}}">Back</a>
    
    @if($balance->users->where('id',Auth::user()->id)->pluck('pivot.admin')->first())

    <br><hr>
     <form class="form-inline" method="POST" id="removeform" action="{{ url('balances')}}/{{$balance->balance_code}}/remove">
    {{ csrf_field() }}  
    
   <button type="submit" onclick="return confirm('Are you completely sure to delete this balance?')" class="btn btn-link">Request the complete deletion of this balance</button>
    <small style="padding: 0px 14px; 0px; 14px;" id="deleteHelp" class="form-text text-muted">This option is only visible for balance admins. On request every member of the balance has to approve the deletion through a comfirmation email. All payments and the final balance of debts will be saved as a PDF and emailed to every member on completion.</small>
    </form>  
    
    @endif
    
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





                           
