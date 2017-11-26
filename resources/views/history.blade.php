@extends('layouts.master')

@section('content')

<div class="container">
      <div class="mt-3">
      <h1>{{ $balance->name}}</h1>
      </div>
    
    

<hr>   
    <h4>Edit history</h4>
    <a href="{{url('balances')}}/{{$balance->balance_code}}">Back</a>
    <ul>
    @foreach($versions as $version)
    @if($version->updatetype != 'create')
    <li>Mutation: <a href="{{url('balances')}}/{{$balance->balance_code}}/{{$version->mutation->mutation_count}}" >{{$version->mutation_id}}</a> - {{$version->updatetype}} - At {{date('d-m-Y H:i:s', strtotime($version->updated_at))}} - By {{$version->editor->balances->where('id', $balance->id)->pluck('pivot.nickname')->first()}} 
      @if($version->updatetype != 'delete')  
        --- &euro;{{$version->size}} -  @foreach($users = $version->users as $user)
                <span>{{$user->pivot->weight}}x {{$user->balances->where('id', $balance->id)->pluck('pivot.nickname')->first()}}</span>
                @endforeach - &euro;{{round(($version->size)/($version->users->sum('pivot.weight')),2)}} PP
    @endif
    </li>
    @endif
    @endforeach
    </ul>
    
</div>

@endsection

        
           <!-- &euro;{{round(($version->size)/($version->users->sum('pivot.weight')),2)}} -->