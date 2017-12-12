@extends('layouts.master')

@section('content')

<div class="container">
      <div class="mt-3">
        <h1>Dashboard</h1>
      </div>
<hr>
    
    @if (session('status'))
        <div class="col-sm-4 alert alert-success">
        {{ session('status') }}
        </div>
    @endif
    
    <a class="btn btn-primary" href="balances/create" role="button">Add new balance</a>
    <br> <br>
    <div class="row">
     <div class="col-md-8">   
     <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th></th>
                <th style="text-align:center">Name</th>
                <th style="text-align:center">Balance</th>
            </tr>
            </thead>
                
            <tbody> 
            <?php $count=0 ?>
            @foreach ($balances as $balance)
            <tr onclick="document.location.href='{{url('')}}/balances/{{$balance->balance_code}}';return false;" class="btnextra">
                <td style="min-width:80px; max-width:80px;"><a href="{{url('')}}/balances/{{$balance->balance_code}}"><div class='balance_cover' style="background:url(../storage/uploads/covers/{{$balance->cover_name}}) no-repeat center center;
                background-size: cover;
                -webkit-background-size: cover;
                -moz-background-size: cover; 
                -o-background-size: cover;"></div></a></td>
                <td style="vertical-align:middle; text-align:center;"><h5>{{$balance->name}}</h5></td>
                <td class="{{ $creditoverview[$count]-$debtoverview[$count] < 0 ? "negative" : "positive"}}" style="vertical-align:middle; text-align:center;">&euro;{{round($creditoverview[$count]-$debtoverview[$count],2)}}</td>
            </tr>
            <?php $count++ ?>
            @endforeach
            
            </tbody>
                
        </table>
        </div>
         </div>
        <br>
        <div class="col-md-4"> 
       
            <ul class="overview">
            <H5>Your total</H5>
            <li>Total sum: &euro;{{ number_format(array_sum($creditoverview)-array_sum($debtoverview),2)}}</li>
            <br>
            <H5>Recent</H5>
            @foreach($recentmutations as $recent)
            <li>
            &euro;{{number_format($recent->mutation->PP*$recent->users->where('id',Auth::user()->id)->pluck('pivot.weight')->first(),2)}} by                 
            {{$recent->user->balances->where('id',$recent->mutation->balance->id)->pluck('pivot.nickname')->first()}} for 
            {{$recent->description}}
          
            </li>
            @endforeach
            </ul>
<!--
            <h5 style="text-align:center; font-size: 26px;">Your total:</h5>
            <h5 style="text-align:center; font-size: 26px;">&euro;{{ array_sum($creditoverview)-array_sum($debtoverview)}}</h5>
-->
        </div>
        </div>
    
</div>

@endsection
