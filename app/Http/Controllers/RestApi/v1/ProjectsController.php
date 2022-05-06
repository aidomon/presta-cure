<?php

namespace App\Http\Controllers\RestApi\v1;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectsController extends Controller
{
    /**
     * Display a listing of all projects.
     *
     * @return App\Models\Project
     */
    public function index(Request $request)
    {
        return response($request->user()->projects);
    }

    /**
     * Create new project.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
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
        $project->verified = 0;
        $project->slug = Project::createUrlSlug($project->name);

        if ($project->save()) {
            return response([
                'message' => 'Project successfuly created. Don\'t forget to verify it\'s ownership.',
                'project_slug' => $project->slug,
            ], 201);
        } else {
            return response([
                'message' => 'Something went wrong.',
            ], 500);
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
        $projects = Project::where('name', 'like', '%' . $request->str . '%')
            ->orWhere('url', 'like', '%' . $request->str . '%')
            ->orWhere('created_at', 'like', '%' . $request->str . '%')
            ->orWhere('updated_at', 'like', '%' . $request->str . '%')
            ->get();
        $searched_projects = $projects->where('user_id', $request->user()->id);

        $search_result = array();
        foreach ($searched_projects as $project) {
            array_push($search_result, $project);
        }

        if (!empty($search_result)) {
            return response($search_result);
        } else {
            return response([
                'message' => 'No project with specified string ' . $request->str . ' found',
            ], 400);
        }
    }
}
