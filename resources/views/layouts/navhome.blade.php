 <!-- Fixed navbar -->
<div class="masthead clearfix fixed-top navbar-inverse navbar navbar-toggleable-m nav-makeup">
    <div class="container">
        <h3 class="masthead-brand">Flappentap</h3>
        
        <nav class="nav nav-masthead">
            
        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('') }}/">Home</a>
        
        <a class="nav-link {{ Request::is('/register') ? 'active' : '' }}" href="{{ url('') }}/register">Register</a>
        
        <a class="nav-link {{ Request::is('/login') ? 'active' : '' }}" href="{{ url('') }}/login">Login</a>
        
        </nav>
    </div>
</div>

 <!-- Direct modals
<a class="nav-link {{ Request::is('register') ? 'active' : '' }}" href="#" role="button" data-toggle="modal" data-target="#register">Register</a>
            
<a class="nav-link {{ Request::is('login') ? 'active' : '' }}" href="#" role="button" data-toggle="modal" data-target="#login">Login</a>

-->
