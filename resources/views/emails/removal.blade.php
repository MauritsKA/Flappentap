@component('mail::message')

<h1>Hi {{$admin->name}},</h1>

{{$editor->name}} has send a request to remove {{$removeduser->name}} ('{{$balance->users->where('id',$removeduser->id)->pluck('pivot.nickname')->first()}}') from '{{$balance->name}}'. As you are an admin of that balance you have to aprove the removal. Are you sure?

@component('mail::button', ['url' => $url, 'color' => 'blue'])
Approve
@endcomponent

@component('mail::panel')
Upon removal a user has no acces to the balance anymore. Its mutations are still visible, but you cannot insert or edit any payment for or from that user. If you reassign the user to the balance, all the old mutations are reconnected automatically!
@endcomponent

Regards, <br>
{{config('app.name')}}

@component('mail::subcopy')
If you’re having trouble clicking the "Accept" button, copy and paste the URL below
into your web browser: [{{ $url }}]({{ $url }})
@endcomponent

@endcomponent