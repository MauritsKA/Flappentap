@extends('layouts.master')

@section('content')

@include('usermodal')

<div class="container" style="position:relative;">
      <div class="mt-3">
        <h1 style="max-width: 68%;"><div class="balancetitle">{{$balance->name}} </div><div class='balance_cover_hover' style="background:url('{{url('/storage/uploads/covers')}}/{{$balance->cover_name}}') no-repeat center center;
                background-size: cover;
                -webkit-background-size: cover;
                -moz-background-size: cover; 
                -o-background-size: cover;">
            
            <div class="middle">
            <div class="text">
                <label class="btn-file">
                <img style=" cursor: pointer; cursor: hand;" src="{{url('/images/file_1.png')}}" height="25" width="25">
                    
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
                <td class="{{ $creditoverview[$count]-$debtoverview[$count] < 0 ? "negative" : "positive"}}" style="vertical-align:middle;">&euro;{{number_format($creditoverview[$count]-$debtoverview[$count],2)}}</td>
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
   
  <h4 style="display:inline;">Payments</h4> <span style="float:right">
        <a href="{{url('balances')}}/{{$balance->balance_code}}/history">History</a> &nbsp;
        <a href="{{url('balances')}}/{{$balance->balance_code}}/edit">Edit balance</a> 
    </span>
    
    
    
          <div class="table-responsive">
            <table id="mutationtable" class="table table-striped">
              <thead>
                 <tr>
                <th style="min-width:10px; max-width:10px;">#</th>
                <th style="min-width:10px; max-width:10px;">V</th>
                <th style="min-width:140px; max-width:140px;">Dated at</th>
                <th style="min-width:125px; max-width:125px;">Amount</th>
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
                
             
                  <tbody id="fbody"> 
               <!-- TABLE FORM -->
                  <form class="form-inline" id="mutationform" method="POST" action="{{ url('balances')}}/{{ $balance->balance_code}}" >
                    {{ csrf_field() }}
                  <tr id="formrow">
                      
<!--
                  <td id="Mid"></td> 
                 <td id="Vid"></td> 
-->
               
                  <td colspan="3"> <input type="date"   class="move form-control" id="date" name="date" placeholder="Date" value="{{ old('date') }}"></td> 
                      
                  <td><input onchange="setprice()" type="number" step="0.01" class="move form-control" id="size" name="size" placeholder="Amount" value="{{ old('size') }}"></td>
                      
                   <td><textarea class="move form-control" id="description" name="description" placeholder="Description" rows="1" value="">{{ old('description') }}</textarea></td> 
                       
                    <td><select class="move custom-select" name="user" id="user">
                        @foreach($users as $user)
                        <option id="{{$user->id}}" value="{{$user->id}}" @if(old('user') == $user->id) selected @endif>{{$user->pivot->nickname}}</option>
                        @endforeach
                        </select>
                    </td>
                      
                    <td id="PP"></td>
               <?php $i=1; ?>       
                @foreach($users as $user)
                <td><input onchange="setprice()" type="number" step="1"  min="0" class="move form-control" id="u{{$i}}" name="{{$user->id}}" value="{{ old($user->id) }}"></td>
                <?php $i++; ?> 
                @endforeach
            
                      
                  <td> <button onsubmit="checksum()" type="submit" class="btn btn-outline-primary" id="add">Add</button></td>
                      
                    <td><a  class="btnextra" onclick="clearform('{{ url('balances')}}/{{ $balance->balance_code}}');return false;" style="vertical-align:middle;">clear</a></td>
                  
                      
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
                    
                <td><a onclick="contentEdit('{{$mutation->mutation_count}}','{{ url('balances')}}/{{ $balance->balance_code}}','{{$mutation->mutation_count}}')" class="btnextra"><img src="{{url('/images/edit_1.png')}}" height="20" width="20"></a></td>
                
                <td class="{{ $mutation->show == 0 ? "invisibletd" : "visibletd"}}"><a onclick="contentDelete('{{$mutation->mutation_count}}','{{ url('balances')}}/{{ $balance->balance_code}}/delete/{{$mutation->mutation_count}}')" role="button" class="btnextra"><img src="{{url('/images/trash_1.png')}}" height="25" width="25"></a></td>
                    
                </tr>
                @endforeach
                </tbody>
                
            </table>              
          </div>
           <span style="display:block;padding-top:2px;">
              
               <input id="searchInput" value="Type To Filter" style="width:200px;display:inline-block;" class="form-control" placeholder="Type To Filter">
         
   
    <select style="display:inline-block;float:right;" id="limit" class='custom-select'>
    <option value="1">None</option>
    <option value="11" selected>10</option>
    <option value="21">20</option>
    <option value="51">50</option>
    <option value="101">100</option>
    <option value="">All</option>
</select>
     </span>   
</div>

<script>
$("#searchInput").keyup(function () {
    //split the current value of searchInput
    var data = this.value.toUpperCase().split(" ");
    //create a jquery object of the rows
    var jo = $("#fbody").find("tr:gt(0)");
    if (this.value == "") {
        jo.show();
        return;
    }
    //hide all the rows
    jo.hide();

    //Recusively filter the jquery object to get results.
    jo.filter(function (i, v) {
        var $t = $(this);
        for (var d = 0; d < data.length; ++d) {
            if ($t.text().toUpperCase().indexOf(data[d]) > -1) {
                return true;
            }
        }
        return false;
    })
    //show the rows that match.
    .show();
}).focus(function () {
    this.value = "";
    $(this).css({
        "color": "black"
    });
    $(this).unbind('focus');
}).css({
    "color": "#C0C0C0"
});
</script>

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


                           
