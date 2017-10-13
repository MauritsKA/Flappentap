<!DOCTYPE html>

<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">
        
        <title>Flappentap</title>
        
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://v4-alpha.getbootstrap.com/dist/css/bootstrap.min.css">
        
    

        <!-- Custom styles for this template -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        
        @yield('css')               
        
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">  
        
         <!-- JS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
    </head>
    
    <body>
    
    @if (Auth::check())
    @include('layouts.nav') 
    @else
    @include('layouts.navhome') 
    @endif  
         
        
    @yield('content')
    
    
    @if (Request::url() == url('/') || Request::url() == url('/register') || Request::url() == url('/login'))
    @include('layouts.footerhome') 
    @else
    @include('layouts.footer')
    @endif  
        
        
    @include('layouts.subfooter')
        
