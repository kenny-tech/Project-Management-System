@extends('layouts.app')

@section('content')
      <!-- The justified navigation menu is meant for single line per list item.
           Multiple lines will require custom code not provided by Bootstrap. -->
      <!-- Jumbotron -->
      <div class="jumbotron">
        <h1>{{ $company->name }}</h1>
        <p class="lead">{{ $company->description }}</p>
        <!-- <p><a class="btn btn-lg btn-success" href="#" role="button">Get started today</a></p> -->
      </div>

      <!-- Example row of columns -->
      <div class="row">
      @foreach($company->projects as $project)
        <div class="col-lg-4">
          <h2>{{ $project->name }}</h2>
          <p class="text-danger">{{ $project->description }}</p>
          <p><a class="btn btn-primary" href="/projects/{{ $project->id }}" role="button">View details »</a></p>
        </div>
      @endforeach
    </div>
@endsection