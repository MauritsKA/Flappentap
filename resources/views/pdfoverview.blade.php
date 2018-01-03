<!DOCTYPE html>

<html>

<head>

	<title>Load PDF</title>

	<style type="text/css">
        body{
            font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
        }
        
        .payments{
			border:1.5px solid #EF5E57;
            border-collapse:collapse;
            width: 100%;
		}
        
        .payments th{
            border-bottom:0.5px solid #ECEEEF;
        }
        
        .payments td{
            border-bottom:0.5px solid #ECEEEF;
        }

        .invisiblerow{
            text-decoration: line-through;
        }

      .noline{
            text-decoration-line: none;
            color: green;
        }

        .positive{
            color: green;
        }

        .negative{
            color: red;
        }
        
        h1{ 
            color:#EF5E57; 
            font-size: 34px;
            line-height: 1;
            font-weight:200;
        } 
        
        .title{
            width:30%;
            height: 50px;
            text-align: center;
            margin-bottom: 5px;
            display:inline-block;
        }
        
        hr{
            size: 1px;
            border-color:#ECEEEF;
        }
        
        .overview{
              margin: 0 auto; /* or margin: 0 auto 0 auto */
        }
        
        .overview td {
             padding:0 10px 0 10px;
        }
        
         .overview th {
             padding:0 10px 0 10px;
        }
        
        .overviewdiv{
            width:100%;

        }

	</style>

</head>

<body>
    <div style="display:block;">
    <span class="title" style="float:right"><h1>Flappentap</h1></span>
    
    <span>
<h1>{{ $balance->name}}</h1></span></div> 
    <div class="overviewdiv">
      <table class="overview">
               
              <thead>
                 <tr>
                     <th  style="text-align:right">User</th>
                     <th  style="text-align:left">Balance</th>
                  </tr>
              </thead>
                
              <tbody>
            <?php $count=0 ?>
               @foreach($users as $user) 
                 
            <tr>
               
                 <td  style="text-align:right">{{$user->pivot->nickname}}</td>
                <td style="text-align:left" class="{{ $creditoverview[$count]-$debtoverview[$count] < 0 ? "negative" : "positive"}}" style="vertical-align:middle;">&euro;{{round($creditoverview[$count]-$debtoverview[$count],2)}}</td>
                <?php $count++ ?>
            </tr>            
                @endforeach    
             </tbody>
                
            </table>
        </div>
    <br>
    
<table class="payments">
<thead>
    <tr>
    <th style="width:35px">ID</th>
    <th style="width:90px;">Dated at</th>
    <th style="width:75px;">Amount</th>
    <th style="width:150px;">Description</th>
    <th style="width:90px;">Payed by</th>
    <th style="width:75px;">Price PP</th>
    <th >Weights</th>
    </tr>
</thead>
    
<tbody>
@if($versions[1] != null)        
@foreach($versions as $version)

    <tr class="{{ $version->updatetype == 'delete' ? "invisiblerow" : "visiblerow"}}">
        
        <td class="noline"><a style=" text-decoration-line: none;" href="{{url('balances')}}/{{$balance->balance_code}}/{{$version->mutation->mutation_count}}" >{{$version->mutation->mutation_count}}</a></td>
        
        <td> {{date('d-m-Y', strtotime($version->dated_at))}}</td>
        
        <td>&euro;{{number_format($version->size,2)}}</td>
      
        <td>{{$version->description}}</td>
        
        <td>{{$version->user->balances->where('id', $balance->id)->pluck('pivot.nickname')->first()}}</td>
            
        <td>&euro;{{number_format(($version->size)/2,2)}}</td>
        
        <td> @foreach($users = $version->users as $user)
            <span>{{$user->pivot->weight}}x {{$user->balances->where('id', $balance->id)->pluck('pivot.nickname')->first()}}</span>
            @endforeach</td>     
    </tr>
@endforeach

@else
<?php $version = $versions ?>    
 <tr class="{{ $version->updatetype == 'delete' ? "invisiblerow" : "visiblerow"}}">
        
        <td class="noline"><a style=" text-decoration-line: none;" href="{{url('balances')}}/{{$balance->balance_code}}/{{$version->mutation->mutation_count}}" >{{$version->mutation->mutation_count}}</a></td>
        
        <td> {{date('d-m-Y', strtotime($version->dated_at))}}</td>
        
        <td>&euro;{{number_format($version->size,2)}}</td>
      
        <td>{{$version->description}}</td>
        
        <td>{{$version->user->balances->where('id', $balance->id)->pluck('pivot.nickname')->first()}}</td>
            
        <td>&euro;{{number_format(($version->size)/2,2)}}</td>
        
        <td> @foreach($users = $version->users as $user)
            <span>{{$user->pivot->weight}}x {{$user->balances->where('id', $balance->id)->pluck('pivot.nickname')->first()}}</span>
            @endforeach</td>     
    </tr>
    
@endif
</tbody>
    
</table>



</body>

</html>

<!--($version->users->sum('pivot.weight')-->