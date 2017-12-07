@extends('layouts.master')

@section('content')

@include('usermodal')

<div class="container">
      <div class="mt-3">
        <h1 style="max-width: 68%;"><div class="balancetitle">{{$balance->name}} </div><div class='balance_cover_hover' style="background:url(../../storage/uploads/covers/{{$balance->cover_name}}) no-repeat center center;
                background-size: cover;
                -webkit-background-size: cover;
                -moz-background-size: cover; 
                -o-background-size: cover;">
            
            <div class="middle">
            <div class="text">
                <label class="btn-file">
                <img style=" cursor: pointer; cursor: hand;" src="../../public/images/file_1.png" height="25" width="25">
                    
                    <form id="upload-form" method="POST" action="{{ url('balances/editcover')}}/{{$balance->balance_code}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input accept="image/x-png, image/gif, image/jpeg" type="file" name="cover" id="cover" data-max-size="2097152" hidden >        
                    </form>
                
                </label>
                </div>
                </div>
            
            </div></h1>
      </div>
    <hr class="backdropline"> 
    
    @if (session('status'))
        <div class="col-sm-6 alert alert-success">
        {{ session('status') }}
        </div>
    @endif
    
    @if (session('alert'))
        <div class="col-sm-6 alert alert-warning">
        {{ session('alert') }}
        </div>
    @endif
    
    <br>
        <div class="row"> 
        <div class="col-md-6">            
            <div class="table-responsive">
            <table class="table table-striped">
                
              <thead>
                 <tr>
                     <th>&nbsp;&nbsp;&nbsp;&nbsp;User</th>
                     <th>Balance</th>
                  </tr>
              </thead>
                
              <tbody>
            <?php $count=0 ?>
               @foreach($users as $user) 
                 
            <tr>
               
                 <td style="vertical-align:middle;"><button type="button" class="btn btn-link" onclick="openUsermodal('{{$user->name}}','{{$user->pivot->nickname}}','{{$user->id}}','{{$user->iban}}','{{$user->email}}')">{{$user->pivot->nickname}}</button></td>
                <td class="{{ $creditoverview[$count]-$debtoverview[$count] < 0 ? "negative" : "positive"}}" style="vertical-align:middle;">&euro;{{round($creditoverview[$count]-$debtoverview[$count],2)}}</td>
                <?php $count++ ?>
            </tr>            
                @endforeach    
             </tbody>
                
            </table>
          </div>
        </div>
        <div  class="col-md-6">
        </div>
    </div>  
    
        <br>
    
    
  <h4>Mutations</h4>
          <div class="table-responsive">
            <table id="mutationtable" class="table table-striped">
              <thead>
                 <tr>
                <th style="min-width:10px; max-width:10px;">#</th>
                <th style="min-width:10px; max-width:10px;">V</th>
                <th style="min-width:180px; max-width:180px;">Dated at</th>
                <th style="min-width:150px; max-width:120px;">Size</th>
                <th style="min-width:200px; max-width:200px;">Description</th>
                <th>User</th>
                <th>PP</th>
                @foreach($users as $user)
                <th style="min-width:80px; max-width:80px;">{{$user->pivot->nickname}}</th>
                @endforeach
                <th></th>
                <th></th>
                </tr>
              </thead>
                
              <tbody> 
                  
               <!-- TABLE FORM -->
                  <form class="form-inline" id="mutationform" method="POST" action="{{ url('balances')}}/{{ $balance->balance_code}}" >
                    {{ csrf_field() }}
                  <tr id="formrow">
                      
                  <td id="Mid"></td> 
                  <td id="Vid"></td> 
               
                  <td> <input type="date" class="form-control" id="date" name="date" placeholder="Date"></td> 
                      
                  <td><input onchange="setprice()" type="number" step="0.01"  class="form-control" id="size" name="size" placeholder="Size"></td>
                      
                    <td><textarea class="form-control" id="description" name="description" placeholder="Description" rows="1"></textarea></td> 
                       
                    <td><select class="custom-select" name="user" id="user">
                        @foreach($users as $user)
                        <option id="{{$user->id}}" value="{{$user->id}}">{{$user->pivot->nickname}}</option>
                        @endforeach
                        </select>
                    </td>
                      
                    <td id="PP"></td>
               <?php $i=1; ?>       
                @foreach($users as $user)
                <td><input onchange="setprice()" type="number" step="1"  min="0" class="form-control" id="u{{$i}}" name="{{$user->id}}"></td>
                <?php $i++; ?> 
                @endforeach
            
                      
                  <td> <button onsubmit="checksum()" type="submit" class="btn btn-outline-primary" id="add">Add</button></td>
                      
                    <td><a  class="btnextra" onclick="clearform('{{ url('balances')}}/{{ $balance->balance_code}}');return false;" style="vertical-align:middle;">clear</a></td>
                    <td></td>
                      
                </tr></form>
                  
                <!-- TABLE DISPLAY -->
                @foreach ($mutations as $mutation)
                <tr id="mut{{$mutation->mutation_count}}" class="{{ $mutation->show == 0 ? "invisiblerow" : "visiblerow"}}">
                    
                <td class="noline">{{$mutation->mutation_count}}</td>
                    
                <td class="noline"><a href="{{ url('balances')}}/{{ $balance->balance_code }}/{{$mutation->mutation_count}}">{{$mutation->versions->last()->version_count}}</a></td>
                    
                <td>{{date('d-m-Y', strtotime($mutation->dated_at))}}</td>
                    
                <td>&euro;{{$mutation->size}}</td>
                    
                <td>{{$mutation->description}}</td>
                
                <td>{{$mutation->user->balances->where('id', $balance->id)->pluck('pivot.nickname')->first()}}</td>
                    
                <td>&euro;{{$mutation->PP}}</td>
                    
                @foreach($users as $user)
                <td>{{$user->mutations->where('id',$mutation->versions->sortByDesc('id')->first()->id)->pluck('pivot.weight')->first()}}</td>
                @endforeach
                    
                <td><a onclick="contentEdit('{{$mutation->mutation_count}}','{{ url('balances')}}/{{ $balance->balance_code}}','{{$mutation->mutation_count}}')" class="btnextra"><img src="../../public/images/edit_1.png" height="20" width="20"></a></td>
                
                <td class="{{ $mutation->show == 0 ? "invisibletd" : "visibletd"}}"><a onclick="return confirm('Are you sure to delete this item?')" href="{{ url('balances')}}/{{ $balance->balance_code}}/delete/{{$mutation->mutation_count}}" role="button"><img src="../../public/images/trash_1.png" height="25" width="25"></a></td>
                    
                </tr>
                @endforeach
                </tbody>
                
            </table>
          </div>
        <a href="{{url('balances')}}/{{$balance->balance_code}}/history">History</a><br>
        <a href="{{url('balances')}}/{{$balance->balance_code}}/edit">Edit balance</a>
    
</div>

<script type="text/javascript">
        $('#cover').bind('change', function() {
            var fileSize = this.files[0].size;
            var maxSize = 2097152;
            if(fileSize>maxSize){
                alert('File size is more then 2 MB, please choose an other picture!');
                return false;
            } else {
                 document.getElementById("upload-form").submit();
            }
        });
</script>

<script>
    function checksum(){
        
    var countTD=$("#mutationtable > tbody > tr:first > td").length;
    var users = [];
    for (var i=1; i < countTD-8; i++){
    var weight = parseInt($("#u"+i).val());

    if(isNaN(weight)){var weight=0;}
    users.push(weight);
    }
    
    function getSum(total, num) {
    return total + num;
    }
    
    var sum = users.reduce(getSum);
    return sum; 
    }
</script>

<script>
function contentEdit(mutid,link,mutcount){
    
    var countTD=$("#mutationtable > tbody > tr:first > td").length;
    
    var date = $('#mut'+mutid+' td:nth-child(3)').text(); 
    var size = $('#mut'+mutid+' td:nth-child(4)').text().substring(1);
    var description = $('#mut'+mutid+' td:nth-child(5)').text();
    var user = $('#mut'+mutid+' td:nth-child(6)').text();
    var PP = $('#mut'+mutid+' td:nth-child(7)').text();
    var newdate = date.split("-").reverse().join("-");
    var userid = $('option:contains("'+user+'")').attr('id');
    
    var users = [];
    for (var i=8; i < countTD-2; i++){
   users.push($('#mut'+mutid+' td:nth-child('+i+')').text());
    }
    
    $('#mutationform').prop('action', link+'/edit/'+mutcount);
    $("#Mid").text(mutid);
    $("#date").val(newdate);
    $("#size").val(size);
    $("#PP").text(PP);
    $("#description").text(description);
    $("#user").val(userid);
    for (var i=1; i < countTD-9; i++){
    $("#u"+i).val(users[i-1]);
    }
    $("#add").text("edit");
    
    var $form = $('form');
    editformstate = setform(); 
    return editformstate;
}    
</script>

<script>
function setprice(){
    
    var size = parseInt($("#size").val());
    console.log(size);
    if(isNaN(size)){var size=0;}
    var sum = checksum();
    if(sum !== 0){
    $("#PP").text('\u20AC'+ Math.round((size/sum)*100)/100);
    }
}
</script>

<script>
function clearform(link){
    $("#mutationform")[0].reset();
    $('#description').val('');
    $("#Mid").text('');
    $("#add").text("add");
    $('#mutationform').prop('action', link);
    $("#PP").text('');
  return false; 
};
</script>

<script>
function setform(){
    var $form = $('form');
    var setForm = $form.serialize();
    return setForm;
}
   
var formstate = setform();
var editformstate = "";

    
$('#mutationform').submit(function(e) {
var $form = $('form');
var sum = checksum();
if  (sum == 0){
    alert('You did not state who should pay');
    e.preventDefault();
    return false; 
}
if ($form.serialize() !== formstate) {
    if ($form.serialize() !== editformstate) {
    } else {
    alert('You did not change any value');
    e.preventDefault();
    return false; 
    }
} else {
    alert('You did not change any value');
    e.preventDefault();
    return false; 
}
});

</script>

<script>
function openUsermodal(username,nickname,userid,iban,email) {
    
    document.getElementById("JSnickname").innerHTML = nickname;
    document.getElementById("JSusername").innerHTML = username;
    document.getElementById("JSiban").innerHTML = iban;
    document.getElementById("JSemail").innerHTML = email;
    document.getElementById("JSuserid").value= userid;
    document.getElementById("removeform").action = "{{ url('balances/users')}}/{{$balance->balance_code}}/remove/" + userid;
    document.getElementById("nicknameform").action = "{{ url('balances/users')}}/{{$balance->balance_code}}/" + userid;
    $('#usermodal').modal('show');
}
</script>

@endsection


                           
