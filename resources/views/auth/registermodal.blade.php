<!-- The register modal -->
<div class="modal {{ $errors->any() ? ' no' : '' }}fade" id="register" tabindex="-1" role="dialog" aria-labelledby="modalLabelSmall" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h4 class="modal-title" id="modalLabelSmall">Register</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>

<div class="modal-body">
<form method="POST" action="{{ route('register') }}">
   {{ csrf_field() }}                      
  
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-xl-12 control-label">Name</label>
                            <div class="col-xl-12">
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required autofocus>
                                 
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        {{ $errors->first('name') }}
                                    </span>
                                @endif
                            </div>
                            
                        </div>
  
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-xl-12 control-label">Email address</label>
                            <div class="col-xl-12">
                                <input type="email" class="form-control" name="email" required>
                                
                               @if ($errors->has('email'))
                                    <span class="help-block">
                                        {{ $errors->first('email') }}
                                    </span>
                                @endif
                            </div>
                        </div>
  
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-xl-12 control-label">Password</label>
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
                            <label class="col-xl-12 control-label">Confirm Password</label>
                            <div class="col-xl-12">
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
  
                        <div class="form-group">
                            <div class="col-xl-12 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form> 
</div>

</div>
</div>
</div>

<script> 
    $('#register').on('shown.bs.modal', function () {
  $('#name').focus()
})
</script>