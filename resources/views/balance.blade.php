@extends('layouts.master')

@section('content')

@include('usermodal')

<div class="container" style="position:relative;">
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
            <table id="overviewtable" class="table table-striped">
                
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
                <th style="min-width:150px; max-width:120px;">Amount</th>
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
               
                  <td> <input type="date" class="move form-control" id="date" name="date" placeholder="Date"></td> 
                      
                  <td><input onchange="setprice()" type="number" step="0.01"  class="move form-control" id="size" name="size" placeholder="Size"></td>
                      
                    <td><textarea class="move form-control" id="description" name="description" placeholder="Description" rows="1"></textarea></td> 
                       
                    <td><select class="move custom-select" name="user" id="user">
                        @foreach($users as $user)
                        <option id="{{$user->id}}" value="{{$user->id}}">{{$user->pivot->nickname}}</option>
                        @endforeach
                        </select>
                    </td>
                      
                    <td id="PP"></td>
               <?php $i=1; ?>       
                @foreach($users as $user)
                <td><input onchange="setprice()" type="number" step="1"  min="0" class="move form-control" id="u{{$i}}" name="{{$user->id}}"></td>
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
                    
                <td>&euro;{{number_format($mutation->size, 2)}}</td>
                    
                <td>{{$mutation->description}}</td>
                
                <td>{{$mutation->user->balances->where('id', $balance->id)->pluck('pivot.nickname')->first()}}</td>
                    
                <td>&euro;{{number_format($mutation->PP,2)}}</td>
                    
                @foreach($users as $user)
                <td>{{$user->versions->where('id',$mutation->versions->sortByDesc('id')->first()->id)->pluck('pivot.weight')->first()}}</td>
                @endforeach
                    
                <td><a onclick="contentEdit('{{$mutation->mutation_count}}','{{ url('balances')}}/{{ $balance->balance_code}}','{{$mutation->mutation_count}}')" class="btnextra"><img src="../../public/images/edit_1.png" height="20" width="20"></a></td>
                
                <td class="{{ $mutation->show == 0 ? "invisibletd" : "visibletd"}}"><a onclick="contentDelete('{{$mutation->mutation_count}}','{{ url('balances')}}/{{ $balance->balance_code}}/delete/{{$mutation->mutation_count}}')" role="button"><img src="../../public/images/trash_1.png" height="25" width="25"></a></td>
                    
                </tr>
                @endforeach
                </tbody>
                
            </table>
          </div>
    <select id="limit" class='custom-select'>
    <option value="1">None</option>
    <option value="11" selected>10</option>
    <option value="21">20</option>
    <option value="51">50</option>
    <option value="101">100</option>
    <option value="">All</option>
</select> &nbsp;
        <a href="{{url('balances')}}/{{$balance->balance_code}}/history">History</a> &nbsp;
        <a href="{{url('balances')}}/{{$balance->balance_code}}/edit">Edit balance</a>
        
</div>

<script>    
function show (min, max) {
    var $table = $('#mutationtable'), $rows = $table.find('tbody tr');
    min = min ? min - 1 : 0;
    max = max ? max : $rows.length;
    $rows.hide().slice(min, max).show();
    return false;    
}
    
$('#limit').bind('change', function () {
    show(0, this.value);
});

$( document ).ready(function() {
    var type = window.location.hash;
    var index = $(type).index();
    
    if(type && index>11){
        show(0,index-1);  
       $("#limit").val("1").attr("selected", "selected");
    } else{
        show(0,11);
    }
});


</script>

<script>
$('select').on('keydown', function(e){
    if(e.keyCode === 37 || e.keyCode === 39) { //up or down
        e.preventDefault();
        return false;
    }
});
    
$("#date").focus();
    
$(document).ready(function(){
$('.move').keydown(function(e){
     if (e.keyCode == 39) { 
         var inputID = $(this).closest('td').next().attr('id')
 
         if(inputID == 'PP'){
            $(this).closest('td').next().next().find('.move').focus();
         }
       $(this).closest('td').next().find('.move').focus();
    }
    
    if (e.keyCode == 37) { 
        var inputID = $(this).closest('td').prev().attr('id')
         if(inputID == 'PP'){
            $(this).closest('td').prev().prev().find('.move').focus();
         }
       $(this).closest('td').prev().find('.move').focus();
    }
});
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
function contentDelete(mutid, url){
       
    var size = parseFloat($('#mut'+mutid+' td:nth-child(4)').text().substring(1));
    var user = $('#mut'+mutid+' td:nth-child(6)').text();
    var PP = $('#mut'+mutid+' td:nth-child(7)').text();
    var countTD=$("#mutationtable > tbody > tr:first > td").length;
    
    var users = [];
    for (var i=8; i < countTD-2; i++){
    var weight = parseInt($('#mut'+mutid+' td:nth-child('+i+')').text());
    
    if(isNaN(weight)){var weight=0;}
    users.push(weight);
    }
    
    function getSum(total, num) {
    return total + num;
    }
    var sum = users.reduce(getSum);
    
    var expectedtotal = sum*parseFloat(PP.substring(1));
     
    if(!$('#overviewtable tr > td:contains("'+user+'")').length || (expectedtotal < 0.98*size || expectedtotal > 1.02*size)){
        alert('You are trying to delete a mutation that is connected to a removed user. This is not possible!');
        return false; 
    } else{
        var check = confirm('Are you sure to delete this item?');
        if(check){
            window.location.href = url; 
        }
        return false;
    }
   
};
    
function contentEdit(mutid,link,mutcount){
    
    var countTD=$("#mutationtable > tbody > tr:first > td").length;
    
    var date = $('#mut'+mutid+' td:nth-child(3)').text(); 
    var size = parseFloat($('#mut'+mutid+' td:nth-child(4)').text().substring(1));
    var description = $('#mut'+mutid+' td:nth-child(5)').text();
    var user = $('#mut'+mutid+' td:nth-child(6)').text();
    var PP = $('#mut'+mutid+' td:nth-child(7)').text();
    var newdate = date.split("-").reverse().join("-");
    var userid = $('option:contains("'+user+'")').attr('id');
    
    var users = [];
    for (var i=8; i < countTD-2; i++){
    var weight = parseInt($('#mut'+mutid+' td:nth-child('+i+')').text());
   
    if(isNaN(weight)){var weight=0;}
    users.push(weight);
    }
    
    function getSum(total, num) {
    return total + num;
    }
    var sum = users.reduce(getSum);
 

    var expectedtotal = sum*parseFloat(PP.substring(1));
    
    if(!$('#overviewtable tr > td:contains("'+user+'")').length || (expectedtotal < 0.98*size || expectedtotal > 1.02*size)){    
        alert('You are trying to edit a mutation that is connected to a removed user. This is not possible!');
        return false; 
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

@endsection


                           
