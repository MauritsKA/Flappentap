@component('mail::message')

<h1>Hi {{$user->name}},</h1>

Welcome to Flappentap.

@component('mail::button', ['url' => url('/dashboard'), 'color' => 'blue'])
Let's start!
@endcomponent

@component('mail::panel')
Flappentap provides a basic and intuitive platform for start-up financials, group expenditures and personal finance.
@endcomponent

Regards, <br>
{{config('app.name')}}

@endcomponent