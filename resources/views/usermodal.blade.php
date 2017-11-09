<!-- The User modal -->
<div class="modal {{ $errors->any() ? ' no' : '' }}fade" id="usermodal" tabindex="-1" role="dialog" aria-labelledby="modalLabelSmall" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h4 class="modal-title" id="modalLabelSmall">Login</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>

<div class="modal-body">
<p id="pname">Super veel verschillende tekst waarvan we graag een JSUSERNAME willen vervangen.</p>
    
<p id="currentusername" hidden>JSUSERNAME</p>
    
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
                        