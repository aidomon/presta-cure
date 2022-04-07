<?php

namespace App\Http\Controllers\RestApi\v1;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    /**
     * Display a listing of all tests.
     *
     * @return App\Models\Project
     */
    public function index(Request $request)
    {
        return response($request->user()->projects);
    }

    /**
     * Display info about the specified test.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $requested_project = $request->user()->projects->where('id', $request->project_id)->first();
        if (!empty($requested_project)) {
            return response($requested_project);
        } else {
            return response([
                'message' => 'No project with ID=' . $request->project_id . ' found',
            ], 400);}
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
