@extends('layouts.master')

@section('css')

<script>
    
$(document).ready(function(){
    $("#addmutations").hide();
});
    
$(function() {
    $( "#showbutton" ).click(function() {
        $( "#addmutations" ).toggle();
    });
});
    

function contentEdit() {
    document.getElementById("selection").contentEditable = true;
}

</script>

@endsection

@section('content')

<div class="container">
      <div class="mt-3">
        <h1>{{ $company->name }}</h1>
      </div>

<hr>
    
     <form method="POST" action"{{ url('company')}}/{{ $company->name }}">
        {{ csrf_field() }}
        <!--<input type="hidden" name="_method" value="PATCH">--> 
        
         
    <div class="row">
        <div class="col-md-6">
        
         <div class="row">
        <div class="col-md-4"><div class="form-group">
        <label for="date">Date</label>
        <input type="date" class="form-control" id="date" name="date" placeholder="Date"></div></div>
        
        <div class="col-md-4"><div class="form-group">
        <label for="size">Amount</label>
        <input type="number" step="0.01"  class="form-control" id="size" name="size" placeholder="Size"></div></div>
        
        <div class="col-md-4"> <div class="form-group">
        <label for="type">Type</label>
        <select name="mutationtype_id" class="form-control">
        @foreach ($mutationtypes as $mutationtype)
        <option value="{{ $mutationtype->id }}">{{$mutationtype->type}}</option>
        @endforeach 
        </select></div></div>
            </div>
       
         <div class="row">
        <div class="col-md-4"><div class="form-group">
        <label for="vat">VAT</label>
        <select name="vattype_id" class="form-control">
        @foreach ($vattypes as $vattype)
        <option value="{{ $vattype->id }}">{{ $vattype->fraction*100 }}% {{ $vattype->type }}</option>
        @endforeach 
        </select></div></div>
        
        <div class="col-md-4"><div class="form-group">
        <label for="item">Item</label>
        <select name="item_id" class="form-control">
        @foreach ($items as $item)
        <option value="{{ $item->id }}">{{ $item->description }}</option>
        @endforeach 
        </select></div></div>
 
            </div>   
         </div>
            
        <div class="col-md-4"><div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" placeholder="Description"></textarea></div></div>
   
        </div>
         <button  type="submit" class="btn btn-outline-primary">&#43</button>
         </form>
    
        <br>
    
     
    
    
  <h4>Mutations <a id="showbutton" href="#" class="plus" role="button">&#43</a></h4>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                 <tr>
                <th>ID</th>
                <th>#</th>
                <th>Version</th>
                <th>Dated at</th>
                <th>Size</th>
                <th>Type</th>
                <th>VAT</th>
                <th>Description</th>
                <th>Item</th>
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
                <td contenteditable="false"><a href="{{ url('company')}}/{{ $company->company_code }}/{{$mutation->mutation_count}}">{{$mutation->version_id}}</a></td>
                <td>{{$mutation->dated_at}}</td>
                <td>{{$mutation->basic_size}}</td>
                <td>{{$mutation->mutationtype->type}}</td>
                
                @if($mutation->vattype_id == null)
                <td>NONE</td>
                @else    
                <td>{{$mutation->vattype->fraction*100}}% = {{$mutation->vat_size}}</td>
                @endif
                    
                <td>{{$mutation->description}}</td>
                    
                @if($mutation->item_id == null)
                <td>NONE</td>
                @else
                <td>{{$mutation->item->description}}</td>    
                @endif
                    
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

@endsection

