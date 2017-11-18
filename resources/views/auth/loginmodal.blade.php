<!-- The Login modal -->
<div class="modal {{ $errors->any() ? ' no' : '' }}fade" id="login" tabindex="-1" role="dialog" aria-labelledby="modalLabelSmall" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h4 class="modal-title" id="modalLabelSmall">Login</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>

<div class="modal-body">
    
    
                            <div class="col-md-8 col-md-offset-4">
                              <a href="{{url('/redirect')}}" class="btn btn-primary facebook"><i class="fa fa-facebook-official"></i> Login with Facebook</a>
                            </div>
     <hr>
    
    
<form method="POST" action="{{ route('login') }}">
     {{ csrf_field() }}
  
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-xl-12 control-label">Email address</label>
                            <div class="col-xl-12">
                                <input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                     {{ $errors->first('email') }}
                                    </span>
                                @endif
                                
                            </div>
                        </div>
  
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-xl-12 control-label">Password</label>
                            <div class="col-xl-12">
                                <input type="password" class="form-control" name="password" required>
                                
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        {{ $errors->first('password') }}
                                    </span>
                                @endif
                            </div>
                        </div>
  

                        <div class="form-group">
                            <div class="checkbox col-xl-12 col-md-offset-4">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                                
                                <div class="form-group">
                            <div class="col-xl-12 col-md-offset-4">
                           <button type="submit" class="btn btn-primary">
                                    Login</button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                                
                            </div>
                    
                    </form> 
   
                       
    
</div>

</div>
</div>
</div>

<script> 
    $('#login').on('shown.bs.modal', function () {
  $('#email').focus()
})
</script>
<!-- End of login modal -->
                        