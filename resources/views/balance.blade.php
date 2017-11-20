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
                    
                    <form id="upload-form" method="POST" action="{{ url('balances/edit')}}/{{$balance->balance_code}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input accept="image/x-png, image/gif, image/jpeg" type="file" name="cover" id="cover" data-max-size="2097152" hidden >        
                    </form>
                
                </label>
                </div>
                </div>
            
            </div></h1>
      </div>
    <hr class="backdropline"> 
            
        <div class="col-md-6">
        <label>Balance</label>             
            <div class="table-responsive">
            <table class="table table-striped">
                
              <thead>
                 <tr> </tr>
              </thead>
                
              <tbody>
 
               
            <tr>
               @foreach($users as $user)
                 <td><button type="button" class="btn btn-link" onclick="openUsermodal('{{$user->name}}','{{$user->pivot->nickname}}','{{$user->id}}','{{$user->iban}}')">{{$user->pivot->nickname}}</button></td>
                @endforeach
            </tr>            
                  
             </tbody>
                
            </table>
          </div>
        </div>
    
        <br>
    
    
  <h4>Mutations</h4>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                 <tr>
                <th style="min-width:10px; max-width:10px;">#</th>
                <th style="min-width:10px; max-width:10px;">V</th>
                <th style="min-width:120px; max-width:120px;">Dated at</th>
                <th style="min-width:120px; max-width:120px;">Size</th>
                <th style="min-width:200px; max-width:200px;">Description</th>
                <th>User</th>
                <th>PP</th>
                @foreach($users as $user)
                <th style="min-width:80px; max-width:80px;">{{$user->pivot->nickname}}</th>
                @endforeach
                <th></th>
                <th></th>
                <th></th>
                </tr>
              </thead>
                
              <tbody> 
                  
                    <form class="form-inline" method="POST" action="{{ url('balances')}}/{{ $balance->balance_code}}">
        {{ csrf_field() }}
                  <tr>
                      
                  <td></td> 
                  <td></td> 
               
                  <td> <input type="date" class="form-control" id="date" name="date" placeholder="Date"></td> 
                  <td><input type="number" step="0.01"  class="form-control" id="size" name="size" placeholder="Size"></td> 
                    <td><textarea class="form-control" id="description" name="description" placeholder="Description" rows="1"></textarea></td> 
                       
                       <td><select class="custom-select" name="user">
                            @foreach($users as $user)
                           <option value="{{$user->id}}">{{$user->pivot->nickname}}</option>
                           @endforeach
                           </select></td>
                       <td></td>
                      
                       @foreach($users as $user)
                <td><input type="number" step="1"  class="form-control" id="{{$user->id}}" name="{{$user->id}}"></td>
                @endforeach
            
                      
                  <td> <button type="submit" class="btn btn-outline-primary">Add</button></td>
                    <td></td>
                       <td></td>
                      </tr>     
                  </form>
                  
                @foreach ($mutations as $mutation)
                <tr class="{{ $mutation->show == 0 ? "invisiblerow" : "visiblerow"}}">
                <td class="noline">{{$mutation->mutation_count}}</td>
                <td class="noline"><a href="{{ url('balances')}}/{{ $balance->balance_code }}/{{$mutation->mutation_count}}">{{$mutation->versions->last()->version_count}}</a></td>
                <td>{{$mutation->dated_at}}</td>
                <td>&euro;{{$mutation->size}}</td>                    
                <td>{{$mutation->description}}</td>
                    <td></td>
                <td></td>
                    
                @foreach($users as $user)
                <td></td>
                @endforeach
                    
                <td><a href="{{ url('balances')}}/{{ $balance->balance_code}}/edit/{{$mutation->mutation_count}}" role="button" onclick="contentEdit()"><img src="../../public/images/edit_1.png" height="20" width="20"></a></td>
                
                
                <td class="{{ $mutation->show == 0 ? "invisibletd" : "visibletd"}}"><a onclick="return confirm('Are you sure?')" href="{{ url('balances')}}/{{ $balance->balance_code}}/delete/{{$mutation->mutation_count}}" role="button"><img src="../../public/images/trash_1.png" height="25" width="25"></a></td>
                    
                <td class="{{ $mutation->show == 0 ? "invisibletd" : "visibletd"}}"><label class="btn-file">
                <img src="../../public/images/file_1.png" height="25" width="25"> <input type="file" hidden></label></td>
                    
                </tr>
                @endforeach
                </tbody>
                
            </table>
          </div>
    
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
function openUsermodal(username,nickname,userid,iban) {
    
    document.getElementById("JSnickname").innerHTML = nickname;
    document.getElementById("JSusername").innerHTML = username;
    document.getElementById("JSiban").innerHTML = iban;
    document.getElementById("nicknameform").action = "{{ url('balances/users')}}/{{$balance->balance_code}}/" + userid;
    $('#usermodal').modal('show');
}
</script>

@endsection


                           
