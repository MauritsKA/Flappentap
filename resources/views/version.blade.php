@extends('layouts.master')

@section('content')

<div class="container">
      <div class="mt-3">
      <h1>{{ $balance->name}}</h1>
      </div>
    
    

<hr>   
    <h4>Mutation {{$mutation->mutation_count}}</h4>
    <a href="{{url('balances')}}/{{$balance->balance_code}}">Back</a>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                <th style="min-width:10px; max-width:10px;">V</th>
                <th style="min-width:30px; max-width:30px;">Type</th>
                <th style="min-width:120px; max-width:120px;">At</th>
                <th style="min-width:80px; max-width:80px;">By</th>
                <th style="min-width:120px; max-width:120px;">Dated at</th>
                <th style="min-width:120px; max-width:120px;">Payed by</th>
                <th style="min-width:80px; max-width:80px;">Size</th>
                <th style="min-width:120px; max-width:120px;">Description</th>
                <th style="min-width:200px; ">Over</th>
                </tr>
              </thead>
                
              <tbody>
                  
                
                
                @foreach ($versions as $version)
                  <tr>
                <td>{{$version->version_count}}</td>
                      
                <td>{{$version->updatetype}}</td>
                      
                <td>{{date('d-m-Y H:i:s', strtotime($version->updated_at))}}</td>
                      
                <td>{{$version->user->balances->where('id', $balance->id)->pluck('pivot.nickname')->first()}}</td>
                      
                <td>{{date('d-m-Y', strtotime($version->dated_at))}}</td>
                      
                <td>{{$version->editor->balances->where('id', $balance->id)->pluck('pivot.nickname')->first()}}</td>
                      
                <td>{{$version->size}}</td>
                      
                <td>{{$version->description}}</td>    
            
                <td>{{$version->mutation->users->pluck('name','pivot.weight')}}</td>
                      
                  </tr>
                    @endforeach 
              
                  
                </tbody>
            </table>
          </div>
    
    
</div>

@endsection