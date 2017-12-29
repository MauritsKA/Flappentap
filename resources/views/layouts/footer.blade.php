<footer class="footer {{ Auth::check() || Request::url() == url('/faq')? 'normalfooter' : 'invertedfooter' }}">
      <div class="container">
        
          <span> A platform by <a href="https://www.linkedin.com/in/mauritskorthalsaltes">Maurits</a></span>
   
        <span style="float:right"><a href="mailto:support@flappentap.com">support@flappentap.com</a></span>
      </div>
         
    </footer>