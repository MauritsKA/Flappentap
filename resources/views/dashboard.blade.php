@extends('layouts.master')

@section('content')

<div class="container">
      <div class="mt-3">
        <h1>Dashboard</h1>
      </div>

<hr>
    
    <p>Here you'll find all kinds of personal overviews. You'll be able to customize your overviews with personal and business related elements.</p>
    
    <a class="btn btn-primary" href="balances/create" role="button">Add new balance</a>
    <br>
     <img src="../public/uploads/1.png">
    
    
   

<!--
    <div class="row">
    <div class="col-md-6">
    <h4>Mutations</h4>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                <th>Size</th>
                <th>Item</th>
                <th>Description</th>
                </tr>
              </thead>
                
              <tbody>
                @foreach ($mutations as $mutation)
                <tr>
                <td>{{$mutation->basic_size}}</td>
                <td>{{$mutation->item_id}}</td>
                <td>{{$mutation->description}}</td>
                </tr>
                @endforeach
                   </tbody>
            </table>
          </div>
        </div>
        
        <div class="col-md-6">
        <h4>Mutations</h4>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                <th>Size</th>
                <th>Item</th>
                <th>Description</th>
                </tr>
              </thead>
                
              <tbody>
                @foreach ($mutations as $mutation)
                <tr>
                <td>{{$mutation->basic_size}}</td>
                <td>{{$mutation->item_id}}</td>
                <td>{{$mutation->description}}</td>
                </tr>
                @endforeach
                   </tbody>
            </table>
          </div>
        </div>
    </div>
    <br>
    
    <h4>Mutations</h4>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                <th>ID</th>
                <th>Version</th>
                <th>Dated at</th>
                <th>Size</th>
                <th>Type</th>
                <th>VAT</th>
                <th>Description</th>
                <th>Item</th>
                </tr>
              </thead>
                
              <tbody>
                @foreach ($mutations as $mutation)
                <tr>
                <td>{{$mutation->id}}</td>
                <td>{{$mutation->update_id}}</td>
                <td>{{$mutation->dated_at}}</td>
                <td>{{$mutation->basic_size}}</td>
                <td>{{$mutation->mutation_type}}</td>
                <td>{{$mutation->vat_size}}</td>
                <td>{{$mutation->description}}</td>
                <td>{{$mutation->item_id}}</td>
                </tr>
                @endforeach
                   </tbody>
            </table>
          </div>
    
    <h4>Mutations</h4>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                <th>ID</th>
                <th>Version</th>
                <th>Dated at</th>
                <th>Size</th>
                <th>Type</th>
                <th>VAT</th>
                <th>Description</th>
                <th>Item</th>
                </tr>
              </thead>
                
              <tbody>
                @foreach ($mutations as $mutation)
                <tr>
                <td>{{$mutation->id}}</td>
                <td>{{$mutation->update_id}}</td>
                <td>{{$mutation->dated_at}}</td>
                <td>{{$mutation->basic_size}}</td>
                <td>{{$mutation->mutation_type}}</td>
                <td>{{$mutation->vat_size}}</td>
                <td>{{$mutation->description}}</td>
                <td>{{$mutation->item_id}}</td>
                </tr>
                @endforeach
                   </tbody>
            </table>
          </div>
-->
    
    
    
</div>

@endsection

