@component('mail::message')

<h1>Hi!</h1>

You are invited to join the balance '{{$balance->name}}' on Flappentap from {{$user->name}}.

@component('mail::button', ['url' => $url, 'color' => 'blue'])
Let's start!
@endcomponent

@component('mail::panel')
Flappentap provides a basic and intuitive platform for start-up financials, group expenditures and personal finance.
@endcomponent

Regards, <br>
{{config('app.name')}}

@endcomponent