@component('mail::message')

<h1>Hi {{$user->name}},</h1>

Thank you for making an account at Flappentap. If you've any questions, feel free to contact us!

@component('mail::button', ['url' => url('/dashboard'), 'color' => 'blue'])
Let's start
@endcomponent

@component('mail::panel')
Flappentap provides a basic and intuitive platform for group expenditures and personal finance.
@endcomponent

Regards, <br>
{{config('app.name')}}

@endcomponent