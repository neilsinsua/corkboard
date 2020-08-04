<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        //index projects
        $projects =  Project::all();
        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    public function store()
    {
        //validate request
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $attributes['user_id'] = auth()->user()->id;
        //persist data
        Project::create($attributes);
        //redirect back
        return redirect('/projects');
    }
}
