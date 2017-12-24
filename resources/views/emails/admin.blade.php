@component('mail::message')

<h1>Hi {{$user->name}},</h1>

{{$inviter->name}} has added you as an admin of '{{$balance->name}}'. As an admin you can approve removals of users, approve the complete removal of the balance, and you can add other admins. These requests will be send to your email. 

Regards, <br>
{{config('app.name')}}

@endcomponent