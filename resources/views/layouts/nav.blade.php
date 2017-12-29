<nav class="navbar navbar-expand-md navbar-light fixed-top">
<div class="container">
    
  <a class="navbar-brand" href="{{url('/')}}">Flappentap</a>
    
  <button class="navbar-toggler navbar-toggler-right custom-toggler" type="button" data-toggle="collapse" data-target="#Mynavbar" aria-controls="Mynavbar" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse " id="Mynavbar">
     <ul class="navbar-nav ml-auto ">
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


