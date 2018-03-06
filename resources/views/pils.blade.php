<!DOCTYPE html>

<html lang="nl">
    
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" type="image/png" href="{{url('/images/favicon.ico')}}" sizes="32x32" />
    
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
        <script src="../node_modules/chart.js/dist/chart.js">
        </script>   
        
    </head>
    
    <body>   

<div class="container">
    
 <div class="row"> 
        <div class="col-md-6">            
            <table id="overviewtable" class="table table-striped" style="font-size: 40px">
                
             <!--  <thead>
                 <tr>
                     <th>Huisgenoot</th>
                     <th>Pils</th>
                     <th>Geld</th>
                  </tr>
              </thead>  -->               
              <tbody>

                    <?php $count=0 ?>
                @foreach($users as $user)       
            <tr>
             
                 <td style="vertical-align:middle;">{{$user->pivot->nickname}}</td>
                <td class="{{ $pilscreditoverview[$count]-$pilsdebtoverview[$count] < 0 ? "negative" : "positive"}}" style="vertical-align:middle;">{{$pilscreditoverview[$count]-$pilsdebtoverview[$count]}}</td>
                <td class="{{ $creditoverview[$count]-$debtoverview[$count] < 0 ? "negative" : "positive"}}" style="vertical-align:middle;">&euro;{{number_format($creditoverview[$count]-$debtoverview[$count],2)}}</td>
            
            </tr>  
            <?php $count++ ?>  
                @endforeach
                        
        
             </tbody>
                
            </table>

            <a class="btn btn-primary" href="pils/delete" role="button">Delete all</a>

          

        </div>
        <div  class="col-md-6">

        <canvas id="myChart" width="400" height="300"></canvas>

        </div>
    </div>  
</div>

<script>



<?php $colors = array("#000000", "#FF0000", "#FFFF00", "#008000", "#0000FF", "#800080"); ?>


new Chart(document.getElementById("myChart"), {
  type: 'line',
  data: {
    labels: [newDate(-6),newDate(-5),newDate(-4),newDate(-3),newDate(-2),newDate(-1),newDate(0)], datasets:[
    <?php $j=0; ?>
    @foreach($users as $user) 
         { 
        data: [

        @for($i = 6; $i > -1; $i--)

<?php 
$day = Carbon\Carbon::now()->subDays($i)->format('d/m/Y');

if(array_key_exists($day, $pilsperdag)){
    $pilsperdagpp = $pilsperdag[$day]->where('user_id',$user->id)->count('user_id');
    echo $pilsperdagpp . ',';
} else {
    echo '0,';
}
?>

  @endfor

        ],
        label: "{{$user->pivot->nickname}}",
        borderColor: '{{$colors[$j]}}',
        fill: false
      },
 <?php $j++; ?>
    @endforeach

    ]
  },
  options: {
    animation: {
        duration: 0
    },
    scales: {
            xAxes: [{
               type: 'time',
                time: {
                    displayFormats: {
                        day: 'D MMM'
                    }
                }
            }]
        }
  }
});





function newDate(days) {
    d = new Date();
    d.setDate(d.getDate() + days).toLocaleString();
    return d;
}

console.log(newDate(-3))

</script>


@include('layouts.subfooter')                          
