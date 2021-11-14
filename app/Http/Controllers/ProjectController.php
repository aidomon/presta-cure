<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    // create new project
    public function create(Request $request)
    {
        request()->validate([
            'new_project' => 'required|max:12|min:3',
        ]);

        $project = new Project;

        $project->name = $request->new_project;
        $project->user_id = Auth::id();
        $project->slug = Project::createUrlSlug($project->name);

        $project->save();

        return redirect('/dashboard')->with('success', 'Your account has been created.');
    }
}
