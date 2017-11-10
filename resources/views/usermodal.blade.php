<!-- The User modal -->
<div class="modal {{ $errors->any() ? ' no' : '' }}fade" id="usermodal" tabindex="-1" role="dialog" aria-labelledby="modalLabelSmall" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content usermodal">

<div class="modal-header">
<h4 class="modal-title" id="modalLabelSmall">User info</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>

<div class="modal-body">
    
<h5><span id="JSnickname"></span></h5>
<div class="modalitem">
    <form class="form-inline">
    <div class="form-group">
    <input type="text" class="form-control" id="nickname" placeholder="new nickname" required>    
    </div> 
    
    &nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-primary">Submit</button>
    </form>   
</div>
    
<div class="modalitem">    
<h5>Name</h5>
<span id="JSusername"></span></div> 

<div class="modalitem">
<h5>Email</h5>
<span id="JSemail"></span></div> 
 
<div class="modalitem">
<h5>IBAN</h5>
<span id="JSiban"></span></div>
    
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
                        