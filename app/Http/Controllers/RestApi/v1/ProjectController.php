<?php

namespace App\Http\Controllers\RestApi\v1;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of all tests.
     *
     * @return App\Models\Project
     */
    public function index()
    {
        return Auth::user()->projects;
    }

    /**
     * Display info about the specified test.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            return Project::findOrFail($request->project_id);
        } catch (ModelNotFoundException) {
            return response()->json([
                'message' => 'nothing found',
            ], 400);
        }
    }

    /**
     * Search for specified name in all tests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return App\Models\Project
     */
    public function search(Request $request)
    {
        return Project::where('name', 'like', '%' . $request->str . '%')
            ->orWhere('id', 'like', '%' . $request->str . '%')
            ->get();
    }

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
}
