@extends('layouts.master')

@section('content')

<div class="container">
      <div class="mt-3">
        <h1>{{ $company->name}}</h1>
      </div>

<hr>   
    <h4>Mutation {{$mutation->mutation_count}}</h4>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                <th>#</th>
                <th>Version</th>
                <th>Type</th>
                <th>By</th>
                <th>At</th>
                <th>Dated at</th>
                <th>Size</th>
                <th>Type</th>
                <th>VAT</th>
                <th>Description</th>
                <th>Item</th>
                </tr>
              </thead>
                
              <tbody>
                  
                
                
                    @foreach ($versions as $version)
                  <tr>
                <td>{{$version->id}}</td>
                <td>{{$version->version_count}}</td>
                <td>{{$version->updatetype->type}}</td>
                <td>{{$version->user->name}}</td>
                <td>{{$version->updated_at}}</td>
                <td>{{$version->dated_at}}</td>
                <td>{{$version->size}}</td>
                <td>{{$version->mutationtype->type}}</td>
                    
                @if($version->vattype_id == null)
                <td>NONE</td>
                @else
                <td>{{$version->vattype->type}}</td>
                @endif
                      
                <td>{{$version->description}}</td>
                
                @if($version->item_id == null)
                <td>NONE</td>
                @else
                <td>{{$version->item->description}}</td>
                @endif
                      
                    </tr>
                    @endforeach 
              
             
                  
                </tbody>
            </table>
          </div>
    
    
</div>

@endsection