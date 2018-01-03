@component('mail::message')

<h1>Hi {{$user->name}},</h1>

Everyone has approved the removal of the balance '{{$balance->name}}'. As you are a member of that balance you hereby receive a PDF with the complete overview. 

@component('mail::panel')
The balance is now removed from your dashboard. Every member will be send this email with a PDF containing an overview of all remaining debts and a history of all payments. The version history of all payments is still accesible via links in the PDF. This information is never lost!
@endcomponent

Regards, <br>
{{config('app.name')}}

@endcomponent