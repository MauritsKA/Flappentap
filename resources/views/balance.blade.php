@extends('layouts.master')

@section('content')

<div class="container">
      <div class="mt-3">
        <h1 style="   max-width: 68%;">{{$balance->name}} <div class='balance_cover_hover' style="background:url(../../storage/uploads/covers/{{$balance->cover_name}}) no-repeat center center;
                background-size: cover;
                -webkit-background-size: cover;
                -moz-background-size: cover; 
                -o-background-size: cover;">
            
            <div class="middle">
            <div class="text">
                <label class="btn-file">
                <img src="../../public/images/file_1.png" height="25" width="25">
                    
                    <form id="upload-form" method="POST" action="{{ url('balances/edit')}}/{{$balance->balance_code}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input accept="image/x-png, image/gif, image/jpeg" type="file" name="cover" id="cover" data-max-size="2097152" hidden >        
                    </form>
                
                </label>
                </div>
                </div>
            
            </div></h1>
      </div>
    <hr> 
    
    
    

    <form method="POST" action"{{ url('balances')}}/{{ $balance->balance_code}}">
        {{ csrf_field() }}
        
        <div class="col-md-12">
        <div class="row">
        <div class="col-md-6">
        <div class="form-group">
        <label for="date">Date</label>
        <input type="date" class="form-control" id="date" name="date" placeholder="Date"></div>
        
     <div class="form-group">
        <label for="size">Amount</label>
        <input type="number" step="0.01"  class="form-control" id="size" name="size" placeholder="Size"></div>
        
     <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" placeholder="Description"></textarea></div>
            
        <button type="submit" class="btn btn-outline-primary">Add</button>
            
        </div>   
            
        <div class="col-md-6">
        <label>Balance</label>
            <div class="table-responsive">
            <table class="table table-striped">                
              <tbody> 
                  
                  @foreach($users as $user)
                <tr>
                <td>{{$user->pivot->nickname}}</td>
                <td>stand</td>
                </tr>
                  @endforeach
                </tbody>
                
            </table>
          </div>
        </div>        
        </div>
        </div>
            
        </form>
    
        <br>
    
    
  <h4>Mutations</h4>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                 <tr>
                <th>ID</th>
                <th>#</th>
                <th>Version</th>
                <th>Dated at</th>
                <th>Size</th>
                <th>Description</th>
                @foreach($users as $user)
                <th>{{$user->pivot->nickname}}</th>
                @endforeach
                <th></th>
                <th></th>
                <th></th>
                </tr>
              </thead>
                
              <tbody> 
                  
                  
                   @foreach ($mutations as $mutation)
                <tr id="selection">
                <td contenteditable="false">{{$mutation->id}}</td>
                <td contenteditable="false">{{$mutation->mutation_count}}</td>
                <td contenteditable="false"><a href="{{ url('balance')}}/{{ $balance->balance_code }}/{{$mutation->mutation_count}}">{{$mutation->version_id}}</a></td>
                <td>{{$mutation->dated_at}}</td>
                <td>&euro;{{$mutation->size}}</td>                    
                <td>{{$mutation->description}}</td>
                    
                @foreach($users as $user)
                <td></td>
                @endforeach
                    
                <td><a href="#" role="button" onclick="contentEdit()"><img src="../../public/images/edit_1.png" height="20" width="20"></a></td>
                <td><a href="#" role="button"><img src="../../public/images/trash_1.png" height="25" width="25"></a></td>
                <td><label class="btn-file">
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





@endsection


                           
