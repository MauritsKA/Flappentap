@extends('layouts.master')

@section('content')

<div class="container">
      <div class="mt-3">
        <h1>Frequently Asked Questions</h1>
      </div>

<hr>
    
    <h5>What is Flappentap?</h5>
    <p>Flappentap provides a basic and intuitive platform to keep track of group expenses. By adding mutations to a balance you can clearly see how much each person in the group owes the rest. You can state who payed how much, when and what for and who should share this cost. The total sum is everything you payed minus everything you owe.</p>
    
    <h5>Can I cheat the system?</h5>
    <p>No, you cannot delete or edit old mutations to cheat the amount you owe. It is possible to edit or 'delete', but the system is build on extensive version control. This means that everything that is changed is tracked and made visible to all other members of the group. Even a delete is just an update of the payment. It cannot actually be removed.<p>
    
    <h5>Are there any costs involved?</h5>
    <p>No, this platform is completely free.</p>
    
    <h5>And what about privacy?</h5>
    <p>All information is stored securely and will not be shared with other parties. The platform is extensively tested and runs on the most modern version of the secure Laravel framework.</p>
    
    <h5>Can I remove members of a balance?</h5>
    <p>Yes, any group member can request the removal of a member. This is one of the options when you tick the nickname in the overview of the balance. An email is send to all the admins. Every admin can then accept the request.</p>
    
    <h5>I removed a user, but can I add him/her again?</h5>
    <p>Yes, just send an invitation to the same email. On acceptance all old mutations are automaticaly rebinded to that person. No information is lost!</p>
    
    <h5>Can I edit a mutation that is connected with a removed user?</h5>
    <p>No you cannot do this, as this would change the users debt in that balance.</p>
    
    <h5>Are there any costs involved?</h5>
    <p>No, this platform is completely free.</p>
    
    <h5>Will you send me emails?</h5>
    <p>Yes, for account verification, invitations to balances and requests towards the admins of a balance. There is no commercial usage of your email.</p>
</div>

@endsection