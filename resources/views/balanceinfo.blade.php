@extends('layouts.master')

@section('content')


<div class="container">
    
      <div class="mt-3">
        <h1>{{$balance->name}}</h1>
      </div>
    <hr>    
    <form id="upload-form" method="POST" action="{{ url('balances/')}}/{{$balance->balance_code}}/edit" enctype="multipart/form-data">
        {{ csrf_field() }}
        
<div class="row">
    <div class="col-md-6">        
    <div class="form-group">
    <label for="name">Balance name</label>
    <input type="text" class="form-control" id="balancename" name="balancename" placeholder="" required>
    </div>
    </div>            
</div>
        
         <button type="submit" value="Upload" class="btn btn-primary">Change name</button>
        
    </form>
<hr>
        
    <h3>Add users to list</h3><br>
     <form id="upload-form" method="POST" action="{{ url('balances/')}}/{{$balance->balance_code}}/edit" enctype="multipart/form-data">
        {{ csrf_field() }}
         
<div class="form-group row">
    <div class="col-sm-1">
    <label for="user" "col-form-label">Email</label>
    </div>
    <div class="col-md-5">
    <input type="text" class="form-control" id="email1" name="email1" placeholder="" required>
    </div>
        
    <div class="col-sm-1">
    <label for="user">Name</label></div>
    <div class="col-md-5">
    <input type="text" class="form-control" id="member1" name="member1" placeholder="" required>
    </div>
</div>
        
<div id="usercontainer">
</div>  
        
<div class="row">
    <div class="col-md-2">
    <a onclick="appendform()"><img class="btnextra" src="../../../public/images/plus.png" height="25" width="25"></a>&nbsp;&nbsp;
    <a onclick="cutform()"><img class="btnextra" src="../../../public/images/minus.png" height="25" width="25"></a>
    </div>
</div><br>

    
   <button onclick="checkSize();"  type="submit" value="Upload" class="btn btn-primary">Invite users</button>
        
    </form>
 <br><a href="{{url('balances')}}/{{$balance->balance_code}}">Back</a>
</div>


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

<script>
var lastid = 1;
    
function appendform() {
    
    var lastinputid = $('#usercontainer > div:last > :nth-child(2) > input').attr('id');
    if(lastinputid){
    var lastid = parseInt(lastinputid.substring(5))+1;
    } else {
        var lastid = 2;
    }
   
    var container = document.getElementById("usercontainer");
    var block = document.createElement("div");
    block.className = "form-group row";
    container.appendChild(block);
    
    // email input
    var column = document.createElement("div");
    column.className = "col-sm-1";
    block.appendChild(column);
    var label = document.createElement("label");
    var t = document.createTextNode("Email");  
    label.appendChild(t);  
    column.appendChild(label);
    
    var column = document.createElement("div");
    column.className = "col-md-5";
    block.appendChild(column);
    var input = document.createElement("input");
    input.type = "text";
    input.className= "form-control"
    input.id = 'email' + lastid;
    input.name = 'email' + lastid;
    input.required = true;
    column.appendChild(input);
    
    // name input
    var column = document.createElement("div");
    column.className = "col-sm-1";
    block.appendChild(column);
    var label = document.createElement("label");
    var t = document.createTextNode("Name");  
    label.appendChild(t);  
    column.appendChild(label);
    
    var column = document.createElement("div");
    column.className = "col-md-5";
    block.appendChild(column);
    var input = document.createElement("input");
    input.type = "text";
    input.className= "form-control"
    input.id = 'member' + lastid;
    input.name = 'member' + lastid;
    input.required = true;
    column.appendChild(input);
   
}

function cutform() {
    var emailinput = $('#usercontainer > div:last > :nth-child(2) > input');
    console.log(emailinput.val());
    var nameinput = $('#usercontainer > div:last > div:last > input');
    var lastrow = $('#usercontainer > div:last');
    if(emailinput && emailinput.val() || nameinput && nameinput.val()){
     if(window.confirm("Are you sure? You are removing a line with a name and/or email!")){
        lastrow.remove();
     }
    } else {
    lastrow.remove();
    }
}
    
    
//https://stackoverflow.com/questions/14853779/adding-input-elements-dynamically-to-form
</script>
  
@endsection





                           
