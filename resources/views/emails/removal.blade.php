@component('mail::message')

<h1>Hi {{$admin->name}},</h1>

{{$editor->name}} has send a request to remove {{$removeduser->name}} ('{{$balance->users->where('id',$removeduser->id)->pluck('pivot.nickname')->first()}}') from '{{$balance->name}}'. As you are an admin of that balance you have to approve the removal. Are you sure?

@component('mail::button', ['url' => $url, 'color' => 'blue'])
Approve
@endcomponent

@component('mail::panel')
Upon removal the user has no acces to the balance anymore. Its payments are still visible, but you cannot insert or edit any payment for or from that user. However, if you reassign the user to the balance, all the old payments are reconnected automatically!
@endcomponent

Regards, <br>
{{config('app.name')}}

@component('mail::subcopy')
If you’re having trouble clicking the "Accept" button, copy and paste the URL below
into your web browser: [{{ $url }}]({{ $url }})
@endcomponent

@endcomponent