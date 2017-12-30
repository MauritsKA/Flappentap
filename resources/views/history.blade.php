@extends('layouts.master')

@section('content')

<div class="container">
      <div class="mt-3">
      <h1>{{ $balance->name}}</h1>
      </div>
    
<hr> 
    
    <h4>Edit history</h4>
@if($versions)
<div class="table-responsive">
<table border="0" class="table" id="historytable">
<thead>
    <tr>
    <th>ID</th>
    <th>Time of edit</th>
    <th>Done by</th>
    <th>Amount</th>
    <th>Payed by</th>
    <th>Price PP</th>
    <th>Weights</th>
    </tr>
</thead>
    
<tbody>
@foreach($versions as $version)
@if($version->updatetype != 'create')
    <tr>
        <td><a href="{{url('balances')}}/{{$balance->balance_code}}/{{$version->mutation->mutation_count}}" >{{$version->mutation_id}}</a></td>
        <td> {{date('d-m-Y H:i:s', strtotime($version->updated_at))}}</td>
        <td>{{$version->editor->balances->where('id', $balance->id)->pluck('pivot.nickname')->first()}}</td>
        @if($version->updatetype != 'delete')
        <td>&euro;{{number_format($version->size,2)}}</td>
        <td>{{$version->user->balances->where('id', $balance->id)->pluck('pivot.nickname')->first()}}</td>
        <td>&euro;{{number_format(($version->size)/($version->users->sum('pivot.weight')),2)}}</td>
        <td> @foreach($users = $version->users as $user)
            <span>{{$user->pivot->weight}}x {{$user->balances->where('id', $balance->id)->pluck('pivot.nickname')->first()}}</span>
            @endforeach</td>
        @else
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        @endif        
    </tr>
@endif
@endforeach
</tbody>
    
</table>
 @endif
</div>
 <select id="limit" class='custom-select'>
    <option value="10" selected>10</option>
    <option value="20">20</option>
    <option value="50">50</option>
    <option value="100">100</option>
    <option value="">All</option>
</select> &nbsp;
    
<a href="{{url('balances')}}/{{$balance->balance_code}}">Back</a>
    
</div>

<script>
function show (min, max) {
    var $table = $('#historytable'), $rows = $table.find('tbody tr');
    min = min ? min - 1 : 0;
    max = max ? max : $rows.length;
    $rows.hide().slice(min, max).show();
    return false;    
}
    
$('#limit').bind('change', function () {
    show(0, this.value);
});

$( document ).ready(function() {
    show(0,10);
});
</script>

@endsection