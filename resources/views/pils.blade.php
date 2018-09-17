<!DOCTYPE html>

<html lang="nl" >
    
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
    
<body  id="fullbody" >   
<div style="height:1920px; width:1080px; background-image: url('{{url('/images/katalyse.jpg')}}');background-size: cover background-repeat: repeat; color:white; overflow:hidden;">
<div class="container">

<div id="VideoDiv4" style="z-index: 1000;position: absolute;left: 200px;top: 280px; display:none;">
<video id="myVideo4" width="320" muted="muted">
  <source src="{{url('/images/choco.mp4')}}" type="video/mp4">
</video>
</div>

<div id="VideoDiv6" style="z-index: 1000;position: absolute;left: 200px;top: 280px; display:none;">
<video id="myVideo6" width="320" muted="muted">
  <source src="{{url('/images/bal.mp4')}}" type="video/mp4">
</video>
</div>

<button id="fullscreenbutton" onclick="openFullscreen();"></button>

<script> 
var vid4 = document.getElementById("myVideo4"); 
function playVid4() { 
   $("#VideoDiv4").show();
    vid4.play(); 
} 
$('#myVideo4').on('ended',function(){ $("#VideoDiv4").hide(); });
 
var vid6 = document.getElementById("myVideo6"); 
function playVid6() { 
   $("#VideoDiv6").show();
    vid6.play(); 
} 
$('#myVideo6').on('ended',function(){ $("#VideoDiv6").hide(); });
</script> 
    
 <div class="row"> 
        <div style="margin-left: 150px; margin-top: 100px;" class="col-xs-6">            
            <table id="overviewtable" class="table table-striped" style="font-size: 40px">
               <thead>
                 <th></th>
                 <th>Pils</th>
                 <th>Geld</th>
               </thead>         
              <tbody>

                    <?php $count=1 ?>
                @foreach($usernames as $username)       
            <tr>
             
                 <td id=u{{$count}} style="vertical-align:middle;">{{$username}}</td>
                 <td id=p{{$count}} style="vertical-align:middle;"></td>
                <td id=f{{$count}} style="vertical-align:middle;"></td>
            
            </tr>  
            <?php $count++ ?>  
                @endforeach

                 <tr>
             
                 <td style="vertical-align:middle;"></td>
                 <td id=ptotal style="vertical-align:middle;"></td>
                <td id=ftotal style="vertical-align:middle;"></td>
            
            </tr> 
                        
        
             </tbody>
                
            </table>

           <!--  <a class="btn btn-primary" href="pils/deleteall" role="button">Delete all</a>
            <a class="btn btn-primary" onclick="setdata()" role="button">Refresh</a>
            <a class="btn btn-primary" onclick="editlocal(1,false)" role="button">pils</a>
            <a class="btn btn-primary" onclick="editlocal(1,true)" role="button">krat</a> -->
          
      
        </div>
        <div  class="col-xs-6">

        <canvas id="myChart" width="900" height="400"></canvas>
          Auto refresh in <span id="timer"></span> minutes
          <div><p>TOEDLES VAN YOKO EN NOODLES</p></div>
        </div>
    </div>
</div>

</div>

<script>

var elem = document.getElementById("fullbody");
function openFullscreen() {
  if (elem.requestFullscreen) {
    elem.requestFullscreen();
  } else if (elem.mozRequestFullScreen) { /* Firefox */
    elem.mozRequestFullScreen();
  } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari & Opera */
    elem.webkitRequestFullscreen();
  } else if (elem.msRequestFullscreen) { /* IE/Edge */
    elem.msRequestFullscreen();
  }
}

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
var countertimeout;
var countertimeoutlong;

function setupdate() {
    countertimeout = setTimeout(function(){ 
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

    }, 60000); //minute
}

function setupdatelong() {
    countertimeoutlong = setTimeout(function(){ 
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

    }, 600000); //10 minutes
}

function stopupdate() {
    clearTimeout(countertimeout);
}

function stopupdatelong() {
    clearTimeout(countertimeoutlong);
}

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
  
}, 3600000); // 1 hour auto refresh

// Update color
function updatecolor(){
  var maxid = $('#overviewtable > tbody > tr:last > td:nth-child(2)').attr('id');
  var maxint = parseInt(maxid.slice(-1));

  var i;
  for (i = 1; i <= maxint; i++) { 
    currentpcount = parseInt($( "#p"+i ).html());
   currentfcount = parseInt($( "#f"+i ).html());


        if (currentpcount < 0){ 
           $( "#p"+i ).html(currentpcount).removeClass().addClass("negative")
        } else {
          $( "#p"+i ).html(currentpcount).removeClass().addClass("positive")
        }      
      
  }
}

// Local update of page
function addlocal(userid,krat){
  stopupdate()
  setupdate()

  stopupdatelong()
  setupdatelong()

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
  setpilstotal()
}

function deletelocal(userid,krat){
  stopupdate()
  setupdate()

  stopupdatelong()
  setupdatelong()

  currentcount = parseInt($( "#p"+userid ).html());

  if (krat != true){
    nextcount = currentcount+1;

        if (nextcount < 0){ 
           $( "#p"+userid ).html(nextcount).removeClass().addClass("negative")
        } else {
          $( "#p"+userid ).html(nextcount).removeClass().addClass("positive")
        } 
  } else if (krat == true){
    nextcount = currentcount-24;

        if (nextcount < 0){ 
           $( "#p"+userid ).html(nextcount).removeClass().addClass("negative")
        } else {
          $( "#p"+userid ).html(nextcount).removeClass().addClass("positive")
        } 
  } 
  setpilstotal()

}

function setpilstotal(){
  var lastint = parseInt($(".table tr:last").prev().find("td").attr('id').substr(1));

    var pilstotal = 0;
    for(i=1; i<=lastint; i++){
      var pils = parseInt($( "#p"+i ).html());
      pilstotal = pilstotal + pils
    }

    if (pilstotal < 0){          
      var pilsclass = "negative";

      if($( "#ptotal").hasClass("positive")){
        $( "#ptotal" ).removeClass("positive")
      }

    } else {
      var pilsclass = "positive";

      if($( "#ptotal" ).hasClass("negative")){
        $( "#ptotal" ).removeClass("negative")
      }
    } 

    $("#ptotal").addClass(pilsclass).html(pilstotal)

}

// Countdown timer
setInterval(function(){
  updatetimer()
}, 60000);

function settimer(){
  $( "#timer" ).html(60); // change time clock
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
          if ((netpilsresult != currentcount) && (response.userids[i-1]==4)){ playVid4() }
          if ((netpilsresult != currentcount) && (response.userids[i-1]==6)){ playVid6() }
          
          var pilsclass = "negative";

          if($( "#p"+i ).hasClass("positive")){
            $( "#p"+i ).removeClass("positive")
          }

        } else {
          var pilsclass = "positive";

           if($( "#p"+i ).hasClass("negative")){
            $( "#p"+i ).removeClass("negative")
          }
        } 

        if (netresult < 0){ 
          var flapclass = "negative";

          if($( "#f"+i ).hasClass("positive")){
            $( "#f"+i ).removeClass("positive")
          }
        } else {
          var flapclass = "positive";

          if($( "#f"+i ).hasClass("negative")){
            $( "#f"+i ).removeClass("negative")
          }
        } 

        $( "#u"+i ).html(response.usernames[i-1])
        $( "#p"+i ).addClass(pilsclass).html(netpilsresult)
        $( "#f"+i ).addClass(flapclass).html('\u20AC'+netresult.toFixed(2))
    }   

    updatecolor()
    setpilstotal()

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

</div>


@include('layouts.subfooter')                          
