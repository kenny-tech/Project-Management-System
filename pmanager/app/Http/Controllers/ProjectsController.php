<?php

namespace App\Http\Controllers;

use App\Project;
use App\Company;
use App\User;
use App\ProjectUser;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // checks if user is logged in and load projects
        if ( Auth::check() ) 
        {
            $projects = Project::where('user_id', Auth::user()->id)->get();
            return view('projects.index', ['projects' => $projects]);    
        }
        return view('auth.login');
    }

    public function adduser(Request $request)
    {
        // take a project, add a user to it

        // get details of the project that has the project id
        $project = Project::find($request->input('project_id'));

        // checks if logged in user is the one that creates the project
        if(Auth::user()->id == $project->user_id)
        {
            $user = User::where('email', $request->input('email'))->first(); // single record

            // checks if user is already added to the project
            $projectUser = ProjectUser::where('user_id', $user->id)
                                        ->where('project_id', $project->id)
                                        ->first();
            
            if($projectUser)
            {
                // if user already exists, exit
                return redirect()->route('projects.show', ['project'=>$project->id])
                ->with('success', $request->input('email').' is already a member of this project');    
            }

            if($user && $project)
            {
                // attach the user to the project
                // creates a record in the join table
                $project->users()->attach($user->id);
                
                return redirect()->route('projects.show', ['project'=>$project->id])
                ->with('success', $request->input('email').' was added to project successfully');    
            }    
        }
        return redirect()->route('projects.show', ['project'=>$project->id])
        ->with('errors', 'Error adding user to project');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( $company_id = null )
    {
        //
        $companies = null;

        if(!$company_id) {
            $companies = Company::where('user_id', Auth::user()->id)->get();
        }
        return view('projects.create', ['company_id'=>$company_id, 'companies'=>$companies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // check if user is lgged in and allow him create a new account
        if(Auth::check()) {
            $project = Project::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'company_id' => $request->input('company_id'),
                'user_id' => Auth::user()->id
            ]);

            if($project) {
                return redirect()->route('projects.show', ['projects' => $project->id])
                        ->with('success', 'Project created successfully');
            }
        }

        return back()->withInput()->with('errors', 'Error creating new Project');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $Project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
        //$Project = Project::where('id', $Project->id)->first();
        $comments = Project::find($project->id);
        return view('projects.show', ['project' => $project, 'comments' => $comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $Project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
        $project = Project::find($project->id);
        return view('projects.edit', ['project' => $project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $Project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        // save data
        $projectUpdate = Project::where('id', $project->id)
                            ->update([
                                'name' => $request->input('name'),
                                'description' => $request->input('description')
                            ]);
        if($projectUpdate) {
            return redirect()->route('projects.show', ['project'=>$project->id])
                    ->with('success', 'Project updated successfully');
        }

        // redirect
        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $Project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
        $findProject = Project::find($project->id);
        if($findProject->delete()) {
            return redirect()->route('projects.index')
                    ->with('success', 'Companny deleted successfully');
        }
        return back()->withInput()->with('error', 'Project could not be deleted');
    }
}
