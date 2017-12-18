@extends('layouts.master')


@section('css')
<link href="{{ asset('css/cover.css') }}" rel="stylesheet">

@endsection

@section('content')

@include('auth.registermodal')
@include('auth.loginmodal')

 <div class="container">
     <div class="home">
            <h1 class="cover-heading">Keep track of your cash</h1>
            <p class="lead">Flappentap provides a basic and intuitive platform for group expenditures and personal finance.</p>
              
            <p class="lead">    
            <a class="btn btn-lg btnsecondary" href="{{ url('') }}/register" role="button">Get started</a></p>
   
         
         </div>
          </div>

@endsection
