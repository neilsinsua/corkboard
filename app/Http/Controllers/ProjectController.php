<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        //index projects
        $projects =  auth()->user()->projects;
        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        abort_if( auth()->user()->isNot($project->user), 403);
         return view('projects.show', compact('project'));
    }

    public function store()
    {
        //validate request
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        //persist data
        auth()->user()->projects()->create($attributes);
        //redirect back
        return redirect('/projects');
    }
}
