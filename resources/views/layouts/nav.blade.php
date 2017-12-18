 <!-- Fixed navbar -->
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