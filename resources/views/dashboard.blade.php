@extends('layouts.master')

@section('content')

<div class="container">
      <div class="mt-3">
        <h1>Dashboard</h1>
      </div>

<hr>
    
    <a class="btn btn-primary" href="balances/create" role="button">Add new balance</a>
    <br> <br>
     
     <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Balance</th>
            </tr>
            </thead>
                
            <tbody> 
            @foreach ($balances as $balance)
            <tr>
                <td><a href="{{url('')}}/balances/{{$balance->balance_code}}"><div class='balance_cover' style="background:url(../storage/uploads/covers/{{$balance->cover_name}}) no-repeat center center;
                background-size: cover;
                -webkit-background-size: cover;
                -moz-background-size: cover; 
                -o-background-size: cover;"></div></a></td>
                <td></td>
                <td></td>
            </tr>
            @endforeach
            </tbody>
                
        </table>
        </div>
    
</div>

@endsection

