<footer class="footer {{ Auth::check() || Request::url() == url('/faq')? 'normalfooter' : 'invertedfooter' }}">
      <div class="container">
          <div class="mastfoot">
    A platform by <a href="https://www.linkedin.com/in/mauritskorthalsaltes">Maurits</a>
            
      </div>
          </div>
    </footer>