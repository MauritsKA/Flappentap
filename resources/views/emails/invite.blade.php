@component('mail::message')

<h1>Hi!</h1>

You are invited to join the balance '{{$balance->name}}' on Flappentap from {{$user->name}}.

@component('mail::button', ['url' => $url, 'color' => 'blue'])
Accept
@endcomponent

@component('mail::panel')
Flappentap provides a basic and intuitive platform for group expenditures and personal finance.
@endcomponent

Regards, <br>
{{config('app.name')}}

@component('mail::subcopy')
If you’re having trouble clicking the "Accept" button, copy and paste the URL below
into your web browser: [{{ $url }}]({{ $url }})
@endcomponent

@endcomponent