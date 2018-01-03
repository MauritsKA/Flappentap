@component('mail::message')

<h1>Hi {{$user->name}},</h1>

{{$editor->name}} has send a request to remove the complete balance '{{$balance->name}}'. As you are a member of that balance you have to approve the removal. Are you sure?

@component('mail::button', ['url' => $url, 'color' => 'blue'])
Approve
@endcomponent

@component('mail::panel')
When you click the button your approval is saved. If all members of this balance have approved, the balance is removed from your dashboard. Every member will be send an email with a PDF containing an overview of all remaining debts and a history of all payments. The version history of all payments is still accesible via links in the PDF. This information is never lost!
@endcomponent

Regards, <br>
{{config('app.name')}}

@component('mail::subcopy')
If you’re having trouble clicking the "Accept" button, copy and paste the URL below
into your web browser: [{{ $url }}]({{ $url }})
@endcomponent

@endcomponent