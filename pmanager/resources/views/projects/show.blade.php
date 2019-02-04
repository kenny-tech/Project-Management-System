@extends('layouts.app')

@section('content')
    <div class="col-sm-9 col-md-9 col-lg-9 pull-left">
            <!-- The justified navigation menu is meant for single line per list item.
                Multiple lines will require custom code not provided by Bootstrap. -->
            <!-- Jumbotron -->
            <div class="well well-lg">
                <h1>{{ $project->name }}</h1>
                <p class="lead">{{ $project->description }}</p>
                <!-- <p><a class="btn btn-lg btn-success" href="#" role="button">Get started today</a></p> -->
            </div>

            <!-- Example row of columns -->
            <div class="row" style="background-color:white; margin:10px">
            
            @include('partials.comments')

            <div class="row container-fluid" style="margin:10px">
                    <form method="post" action="{{ route('comments.store') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="commentable_type" value="App\Project">
                        <input type="hidden" name="commentable_id" value="{{ $project->id }}">

                        <div class="form-group">
                            <label for="comment-content">Comment<span class="required">*</span></label>
                            <textarea   placeholder="Enter comment"
                                        style="resize: vertical"
                                        id="comment-content"
                                        name="body"
                                        rows="3"
                                        spellcheck="false"
                                        class="form-control autosize-target text-left">
                            </textarea>
                        </div>

                        <div class="form-group">
                            <label for="comment-content">Proof of work done<span class="required">*</span></label>
                            <textarea   placeholder="Enter url or screenshots"
                                        style="resize: vertical"
                                        id="comment-content"
                                        name="url"
                                        rows="2"
                                        spellcheck="false"
                                        class="form-control autosize-target text-left">
                            </textarea>
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="submit">
                        </div>
                    </form>
            </div>            
        </div>
    </div>

    <div class="col-sm-3 col-md-3 col-lg-3 pull-right">
          <!-- <div class="sidebar-module sidebar-module-inset">
            <h4>About</h4>
            <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
          </div> -->
          <div class="sidebar-module">
            <h4>Actions</h4>
            <ol class="list-unstyled">
              <li><a href="/projects/{{ $project->id }}/edit">Edit</a></li>
              <li><a href="/projects/create">Create New project</a></li>
              <li><a href="/projects">My projects</a></li>
              
              @if($project->user_id == Auth::user()->id)
              <li>  
                <br/>            
                <a href="#"
                    onclick="
                    var result = confirm('Are you sure you want to delete this project?');
                        if( result ) {
                            event.preventDefault();
                            document.getElementById('delete-form').submit();
                        }"
                >
                    Delete
                </a>
                <form id="delete-form" action="{{ route('projects.destroy',[$project->id]) }}" 
                    method="POST" style="display: none;">
                    <input type="hidden" name="_method" value="delete">
                    {{ csrf_field() }}
                </form>
              </li>
              @endif
              
            </ol>
            <hr/>
            <h4>Add members</h4>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12  col-sm-12 ">
                    <form id="add-user" action="{{ route('projects.adduser') }}"  method="POST">
                        {{ csrf_field() }}
                        <div class="input-group"> 
                            <input class="form-control" name="project_id" id="project_id" value="{{$project->id}}" type="hidden">
                            <input type="text" required class="form-control" id="email"  name="email" placeholder="Email">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit" id="addMember" >Add!</button>
                            </span>
                        </div><!-- /input-group -->
                    </form>
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
            <br/>
            <h4>Team Members</h4>
                <ol class="list-unstyled" id="member-list">
                    <!-- loop through project model users method to get project users-->
                    @foreach($project->users as $user)
                        <li><a href="#">{{ $user->email }}</a></li>
                    @endforeach
                </ol>
                </div>
            </div>
    </div>
@endsection