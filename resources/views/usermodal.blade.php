<!-- The User modal -->
<div class="modal {{ $errors->any() ? ' no' : '' }}fade" id="usermodal" tabindex="-1" role="dialog" aria-labelledby="modalLabelSmall" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content usermodal">

<div class="modal-header">
<h4 class="modal-title" id="modalLabelSmall">User info <span id="JSnickname"></span></h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>

<div class="modal-body">
    
<div class="modalitem">    
<h5>Name</h5>
<span id="JSusername"></span></div> 

<div class="modalitem">
<h5>Email</h5>
<span id="JSemail">none</span></div> 
 
<div class="modalitem">
<h5>IBAN</h5>
<span id="JSiban"></span></div>

<div class="modalitem">
    <form class="form-inline" method="POST" id="nicknameform" action="{{ url('balances/users')}}/{{$balance->balance_code}}/">
    {{ csrf_field() }}  
        
    <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="newnickname" name="newnickname" placeholder="new nickname" required>    

   <button type="submit" class="btn btn-primary">Submit</button>
    </form>   
</div>

<hr>
    
<div class="modalitem">
    <form class="form-inline" method="POST" id="removeform" action="{{ url('balances/users')}}/{{$balance->balance_code}}/">
    {{ csrf_field() }}  
    
    <input id="JSuserid" name="userid" type="hidden">   
    
   <button type="submit" onclick="return confirm('Are you completely sure to remove this user?')" class="btn btn-link">Request removal of user from balance</button>
        <small style="padding: 0px 14px; 0px; 14px;" id="deleteHelp" class="form-text text-muted">This request is emailed to all admins. Any admin can approve the removal. If you wish to re-add a user, simply send an invitation to the same email. All past payments will be reconnected.</small>
    </form>   
</div>

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
                        