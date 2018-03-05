@extends('layouts.master')

@section('content')

<div class="container">
      <div class="mt-3">
        <h1>Pils</h1>
      </div>
    <hr>
   
   <ul>
       @foreach($pilsjes as $pils)
       <li>{{$pils->user->name}}</li>
       @endforeach
   </ul>
</div>
 
@endsection





                           
