@extends('layouts.master')

@section('content')

<div class="container">
      <div class="mt-3">
        <h1>Frequently Asked Questions</h1>
      </div><br>

    
    <div class="toggle">
	<div class="toggle-title ">
		<h5>
		<i></i>
		<span class="title-name">What is Flappentap?</span>
		</h5>
	</div>
	<div class="toggle-inner">
		<p>Flappentap provides a basic and intuitive platform to keep track of group expenses. By adding mutations to a balance you can clearly see how much each person in the group owes the rest. You can state who payed how much, when and what for and who should share in this cost. The total sum is everything you payed minus everything you owe.</p>
	</div>
	</div><!-- END OF TOGGLE -->
    
    <div class="toggle">
	<div class="toggle-title ">
		<h5>
		<i></i>
		<span class="title-name">Can I cheat the system?</span>
		</h5>
	</div>
	<div class="toggle-inner">
		<p>No, you cannot delete or edit old mutations to cheat the amount you owe. It is possible to edit or 'delete', but the system is build on extensive version control. This means that everything that is changed is tracked and made visible to all other members of the group. Even a delete is just an update of the payment. It cannot actually be removed.</p>
	</div>
	</div><!-- END OF TOGGLE -->
    
    <div class="toggle">
	<div class="toggle-title ">
		<h5 class="toggle-h5">
		<i></i>
		<span class="title-name">Are there any costs involved?</span>
		</h5>
	</div>
	<div class="toggle-inner">
		<p>No, this platform is completely free!</p>
	</div>
	</div><!-- END OF TOGGLE -->
    
        <div class="toggle">
	<div class="toggle-title ">
		<h5 class="toggle-h5">
		<i></i>
		<span class="title-name">And what about privacy?</span>
		</h5>
	</div>
	<div class="toggle-inner">
		<p>All information is stored securely and will not be shared with other parties. The platform is extensively tested and runs on the most modern version of the secure Laravel framework.</p>
	</div>
	</div><!-- END OF TOGGLE -->
    
      <div class="toggle">
	<div class="toggle-title ">
		<h5 class="toggle-h5">
		<i></i>
		<span class="title-name">Can I remove members of a balance?</span>
		</h5>
	</div>
	<div class="toggle-inner">
		<p>Yes, any group member can request the removal of a member. This is one of the options when you tick the nickname in the overview of the balance. An email with the request is send to all the admins. Every admin can then accept the request.</p>
	</div>
	</div><!-- END OF TOGGLE -->
    
     <div class="toggle">
	<div class="toggle-title ">
		<h5 class="toggle-h5">
		<i></i>
		<span class="title-name">I removed a user, but can I add him/her again?</span>
		</h5>
	</div>
	<div class="toggle-inner">
		<p>Yes, just send an invitation to the same email. On acceptance all old mutations are automaticaly rebinded to that person. No information is lost!</p>
	</div>
	</div><!-- END OF TOGGLE -->
    
    <div class="toggle">
	<div class="toggle-title ">
		<h5 class="toggle-h5">
		<i></i>
		<span class="title-name">Can I edit a mutation that is connected with a removed user?</span>
		</h5>
	</div>
	<div class="toggle-inner">
		<p>No you cannot do this, as this would change the users debt in that balance. Re adding the user enables this option again.</p>
	</div>
	</div><!-- END OF TOGGLE -->
    
    <div class="toggle">
	<div class="toggle-title ">
		<h5 class="toggle-h5">
		<i></i>
		<span class="title-name">Will you send me emails?</span>
		</h5>
	</div>
	<div class="toggle-inner">
		<p>Yes, for account verification, invitations to balances and requests towards the admins of a balance. There is no commercial usage of your email.</p>
	</div>
	</div><!-- END OF TOGGLE -->
    
     <div class="toggle">
	<div class="toggle-title ">
		<h5 class="toggle-h5">
		<i></i>
		<span class="title-name">Is a mobile app available?</span>
		</h5>
	</div>
	<div class="toggle-inner">
		<p>No, for the time being not. The website is optimized for pc but completely compatible for mobile. Work is in progress to create an Android app.</p>
	</div>
	</div><!-- END OF TOGGLE -->
  
</div>

<script>
    if( $(".toggle .toggle-title").hasClass('active') ){
		$(".toggle .toggle-title.active").closest('.toggle').find('.toggle-inner').show();
  
	}
    
    //onclick="openUsermodal()"
    
$(".toggle .toggle-title").click(function(){
   
		if( $(this).hasClass('active') ){
			$(this).removeClass("active");            
            $(this).closest('.toggle').find('.toggle-inner').slideToggle(200);
		}
		else{	        
            $(this).addClass("active");
            $(this).closest('.toggle').find('.toggle-inner').slideToggle(200);
		}
	});
</script>
@endsection