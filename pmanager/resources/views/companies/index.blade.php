@extends('layouts.app')

@section('content')
<div class="panel panel-primary col-md-6 col-lg-6">
  <div class="panel-heading">Companies</div>
  <div class="panel-body">
    <ul class="list-group">
      @foreach($companies as $company)
        <li class="list-group-item">{{ $company->name }}</li>
      @endforeach
    </ul>
  </div>
</div>
@endsection