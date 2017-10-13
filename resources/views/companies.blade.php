@extends('layouts.master')

@section('content')

<div class="container">
      <div class="mt-3">
        <h1>Company
          <a href="company/create" class="plus" role="button">&#43</a></h1> 
      </div>

<hr>
    
    <p>An overview of all your important Big Time Business</p>
    
    Your Companies: <br>
    <ul>
        @foreach ($companies as $company)
       <a href="{{ url('') }}/company/{{ $company->company_code }}"> <li> {{$company->name}}</li></a> 
        @endforeach
    </ul>

</div>

@endsection
