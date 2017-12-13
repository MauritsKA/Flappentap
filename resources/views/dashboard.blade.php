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
        <div class="table-responsive borderless">
        <table class="table-hover">
       <tr class="nohover"><th></th><th class="tableline" colspan="3" style="text-align:center"><H5>Your total</H5></th> </tr>    
       <tr class="nohover"><td></td><td colspan="3" style="text-align:center">&euro;{{ number_format(array_sum($creditoverview)-array_sum($debtoverview),2)}}</td></tr> 
        <tr><th style="height:20px;"></th></tr>
        <tr class="nohover"><th></th><th class="tableline" colspan="3" style="text-align:center" > <H5>Recent activity</H5></th> </tr> 
       <tr class="nohover"> <th style="width:20px;"></th><th style="min-width:80px">Amount</th>
            <th style="min-width:80px">By</th>
            <th>For</th></tr>
        @foreach($recentmutations as $recent)
        <tr onclick="document.location.href='{{url('')}}/balances/{{$recent->mutation->balance->balance_code}}';return false;" class="btnextra">
            <td></td>
            <td>&euro;{{number_format($recent->mutation->PP*$recent->users->where('id',Auth::user()->id)->pluck('pivot.weight')->first(),2)}}</td>
            <td>{{$recent->user->balances->where('id',$recent->mutation->balance->id)->pluck('pivot.nickname')->first()}}</td>
            <td>{{$recent->description}}</td>
        </tr>
        @endforeach
        </table>
        </div>

        </div>
    </div>
    
</div>

@endsection
