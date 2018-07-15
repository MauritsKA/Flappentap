<!DOCTYPE html>

<html lang="nl">
    
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" type="image/png" href="{{url('/images/favicon.ico')}}" sizes="32x32" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
    
        <title>Flappentap - Keep track of your cash</title>
        <meta name="description" content="Flappentap provides a basic and intuitive platform for group expenditures and personal finance.">
        
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">

        <!-- Custom styles for this template -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">             
        
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">  
        
         <!-- JS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="{{ asset('js/main.js') }}?3"></script>

        <script src="https://cdn.jsdelivr.net/npm/moment@2.21.0/moment.min.js"></script>    
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.2/dist/Chart.js">
        </script>   
        
    </head>
    
    <body >

    <ul>
    @foreach($pilsen as $pils)
    <li> {{$pils}} </li>
    @endforeach
    </ul>

@include('layouts.subfooter')                          
