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
    
    <body  style="background-image: url('{{url('/images/katalyse.jpg')}}');background-size: cover background-repeat: repeat; color:white; ">   

<div class="container">

<div id="VideoDiv" style="z-index: 1000;position: absolute;left: 200px;top: 280px; display:none;">
<video id="myVideo" width="320" muted="muted">
  <source src="{{url('/images/bal.mp4')}}" type="video/mp4">
</video>
</div>

<script> 
var vid = document.getElementById("myVideo"); 

function playVid() { 
   $("#VideoDiv").show();
    vid.play(); 
} 
$('#myVideo').on('ended',function(){ $("#VideoDiv").hide(); });
 
</script> 
    
 <div class="row"> 
        <div class="col-md-6">            
            <table id="overviewtable" class="table table-striped" style="font-size: 40px">
               <thead>
                 <th></th>
                 <th>Pils</th>
                 <th>Geld</th>
               </thead>         
              <tbody>

                    <?php $count=0 ?>
                @foreach($usernames as $username)       
            <tr>
             
                 <td style="vertical-align:middle;">{{$username}}</td>
                 <td id=p{{$userids[$count]}} style="vertical-align:middle;"></td>
                <td id=f{{$userids[$count]}} style="vertical-align:middle;"></td>
            
            </tr>  
            <?php $count++ ?>  
                @endforeach
                        
        
             </tbody>
                
            </table>

           <!--  <a class="btn btn-primary" href="pils/deleteall" role="button">Delete all</a>
            <a class="btn btn-primary" onclick="setdata()" role="button">Refresh</a>
            <a class="btn btn-primary" onclick="editlocal(1,false)" role="button">pils</a>
            <a class="btn btn-primary" onclick="editlocal(1,true)" role="button">krat</a> -->
            Auto refresh in <span id="timer"></span> seconds
      
        </div>
        <div  class="col-md-6">

        <canvas id="myChart" width="400" height="300"></canvas>
        </div>
    </div>
</div>

<script>
//// AJAX calls
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function() {
    setdata()
    settimer()
    
});


// Update interval
setInterval(function(){
  setdata()
  settimer()
  updatecolor()

  try {
    updatetime()
  }
  catch (e) {
      if (e instanceof ReferenceError) {  
      } else {
          throw e;
      }
}
  
}, 5000); // AJAX refresh time

// Update color
function updatecolor(){
  var maxid = $('#overviewtable > tbody > tr:last > td:nth-child(2)').attr('id');
  var maxint = parseInt(maxid.slice(-1));

  var i;
  for (i = 1; i <= maxint; i++) { 
    currentcount = parseInt($( "#p"+i ).html());

        if (currentcount < 0){ 
           $( "#p"+i ).html(currentcount).removeClass().addClass("negative")
        } else {
          $( "#p"+i ).html(currentcount).removeClass().addClass("positive")
        }       
  }
 
}

// Local update of page
function editlocal(userid,krat){
  currentcount = parseInt($( "#p"+userid ).html());

  if (krat != true){
    nextcount = currentcount-1;

        if (nextcount < 0){ 
           $( "#p"+userid ).html(nextcount).removeClass().addClass("negative")
        } else {
          $( "#p"+userid ).html(nextcount).removeClass().addClass("positive")
        } 
  } else if (krat == true){
    nextcount = currentcount+24;

        if (nextcount < 0){ 
           $( "#p"+userid ).html(nextcount).removeClass().addClass("negative")
        } else {
          $( "#p"+userid ).html(nextcount).removeClass().addClass("positive")
        } 
  }  
}

// Countdown timer
setInterval(function(){
  updatetimer()
}, 1000);

function settimer(){
  $( "#timer" ).html(6); // change time clock
  }

function updatetimer(){
  currenttime = $( "#timer" ).html(); 
  $( "#timer" ).html(currenttime -1);
  }

// Call AJAX and update overviews
function setdata(){
 $.get('{{url('/turf')}}', function(response){
    if(response.success)
    
    responsedata = response;
    for(i=1; i<=response.userids.length; i++){

        var netpilsresult = response.pilscreditoverview[i-1]- response.pilsdebtoverview[i-1];
        var netresult = response.creditoverview[i-1]- response.debtoverview[i-1];
        var currentcount = $( "#p"+i).html();   

        if (netpilsresult < 0){ 
          if ((netpilsresult != currentcount) && (i==6)){ playVid() }
          var pilsclass = "negative";
        } else {
          var pilsclass = "positive";
        } 
        if (netresult < 0){ 
          var flapclass = "negative";
        } else {
          var flapclass = "positive";
        } 
        $( "#p"+i ).addClass(pilsclass).html(netpilsresult)
        $( "#f"+i ).addClass(flapclass).html('\u20AC'+netresult.toFixed(2))
    }   

    updatecolor()

    adddata(responsedata)
  }, 'json');
}

// Get data per user per day 
function getgraphdata(responsedata){
  dates = getdates(); 

  // Setup of data arrays
  var pilsppperdag = new Array(responsedata.userids.length);
  for (j=0;j<responsedata.userids.length;j++){
      pilsppperdag[j] = new Array(dates.length+1).join('0').split('').map(parseFloat);
  }

  for(i=0;i<dates.length;i++){

    date = dates[i].toLocaleDateString("en-GB"); // Get correct date format
    pilsperdag = responsedata.pilsperdag[date]; // Get all pils from date

    for (var id in pilsperdag){ // For every pils present      
      for (j=1;j<=responsedata.userids.length;j++){ // For all users
        if( userids[j-1] == pilsperdag[id].user_id) {  // Check if user ID of pils is his 
          pilsppperdag[(j-1)][i]=pilsppperdag[(j-1)][i]+1 // if so add to arrays
        }
      }
    }
  }

  return pilsppperdag
}

// Update data for every user
function adddata(responsedata){
  pilsppperdag = getgraphdata(responsedata)
  for (i=0;i<userids.length;i++){
  myLineChart.data.datasets[i].data = pilsppperdag[i];
  }
  myLineChart.update();
}

////// SETUP OF GRAPH 

// Define users and set their color
<?php 
    $js_usernames = json_encode($usernames);
    echo "var users = ". $js_usernames . ";\n"; 
?>
<?php 
    $js_userids = json_encode($userids);
    echo "var userids = ". $js_userids . ";\n"; 
?>
var colors = ['#00AC50','#f2c235','#9b001b','#e83120','#D2D6DF','#0095D9'];
// for(i=0; i<users.length;i++){
//   colors[i] = "#"+intToRGB(hashCode(users[i]));

// }

// define data & options for graph
dates = getdates(); // find the past 7 dates
var data = {
    labels:  dates ,
    datasets: [ 
    ]
};

var option = {
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

// create line chart
var canvas = document.getElementById('myChart');

var myLineChart = Chart.Line(canvas,{
  data:data,
  options:option
});

// create dataset for every user
for (i=0;i<users.length;i++){
  myLineChart.data.datasets.push({
        label: users[i],
        borderColor: colors[i],
        fill: false,
  })
}
myLineChart.update();

// date functions
function getdates(){
  var dates=[];
  var i = 0;
  for(k=-6; k<1; k++ ){
    dates[i] = newDate(k);
    i++;
  }
  return dates; 
}

function newDate(days) {
    d = new Date();
    d.setDate(d.getDate() + days).toLocaleString("en-GB");
    return d;
}

// java String #hashCode
function hashCode(str) { 
    var hash = 0;
    for (var i = 0; i < str.length; i++) {
       hash = str.charCodeAt(i) + ((hash << 5) - hash);
    }
    return hash;
} 

// Turn hash into RGB color
function intToRGB(i){
    var c = (i & 0x00FFFFFF)
        .toString(16)
        .toUpperCase();

    return "00000".substring(0, 6 - c.length) + c;
}

// Function used to swap columns and rows for pilsperdagpp data

function getCol(matrix, col){
       var column = [];
       for(var i=0; i<matrix.length; i++){
          column.push(matrix[i][col]);
       }
       return column;
    }

</script>


@include('layouts.subfooter')                          
