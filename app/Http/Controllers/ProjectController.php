<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Create new project.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return view
     */
    public function create(Request $request)
    {
        request()->validate([
            'new_project' => 'required|url',
        ]);

        $project = new Project;

        $project->name = Project::extractProjectNameFromUrl($request->new_project);
        $project->user_id = Auth::id();
        $project->url = $request->new_project;
        $project->slug = Project::createUrlSlug($project->name);

        $project->save();

        return redirect('/dashboard')->with('success', 'Your project has been created.');
    }

    /**
     * Display specific project.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        if (Auth::user()->projects->contains($project)) {
            return view('layouts.project', [
                'project_details' => $project,
                'project_history' => $project->history->sortDesc(),
            ]);
        } else {
            return abort(404);
        }
    }
}
