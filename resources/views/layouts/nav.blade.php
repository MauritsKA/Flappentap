 <!-- Fixed navbar -->
<!--
<div class="masthead clearfix fixed-top navbar-inverse navbar navbar-toggleable-m nav-makeup">
    <div class="container">
        <h3 class="masthead-brand">Flappentap</h3>
        
        <nav class="nav nav-masthead">
        
        @if(Auth::check())
        <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{url('')}}/dashboard">Dashboard</a>
            
        <a class="nav-link {{ Request::is('faq') ? 'active' : '' }}" href="{{url('')}}/faq">FAQ</a>
            
        <a class="nav-link {{ Request::is('profile') ? 'active' : '' }}" href="{{url('')}}/profile">Profile</a>
            
        <a  class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> Logout </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> {{ csrf_field() }}</form>
        @else 
         <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('') }}/">Home</a>
        
         <a class="nav-link {{ Request::is('faq') ? 'active' : '' }}" href="{{url('')}}/faq">FAQ</a>
        
        <a class="nav-link {{ Request::is('/register') ? 'active' : '' }}" href="{{ url('') }}/register">Register</a>
        
        <a class="nav-link {{ Request::is('/login') ? 'active' : '' }}" href="{{ url('') }}/login">Login</a>
        @endif
            
        </nav>
    </div>
</div>
-->


 <nav class="navbar navbar-expand-lg nav-makeup fixed-top">
      <div class="container">
        <h3 class="masthead-brand">Flappentap</h3>
          
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample07">
          <ul class="navbar-nav mr-auto">
            @if(Auth::check())
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{url('')}}/dashboard">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ Request::is('faq') ? 'active' : '' }}" href="{{url('')}}/faq">FAQ</a>
            </li>
            <li class="nav-item">
               <a class="nav-link {{ Request::is('profile') ? 'active' : '' }}" href="{{url('')}}/profile">Profile</a>
            </li>
            <li class="nav-item">
             <a  class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> Logout </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> {{ csrf_field() }}</form>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('') }}/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('faq') ? 'active' : '' }}" href="{{url('')}}/faq">FAQ</a>
            </li>
            <li class="nav-item active">
                 <a class="nav-link {{ Request::is('/register') ? 'active' : '' }}" href="{{ url('') }}/register">Register</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link {{ Request::is('/login') ? 'active' : '' }}" href="{{ url('') }}/login">Login</a>
            </li>
            @endif
          </ul>
    
        </div>
      </div>
    </nav>

