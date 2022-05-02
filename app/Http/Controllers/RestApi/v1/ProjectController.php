<?php

namespace App\Http\Controllers\RestApi\v1;

use ErrorException;
use App\Models\Result;
use App\Models\History;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProjectController extends Controller
{
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
     * Display info about the specified test.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        request()->validate([
            'project_id' => 'required|int',
        ]);
        $requested_project = $request->user()->projects->where('id', $request->project_id)->first();
        if (!empty($requested_project)) {
            return response($requested_project);
        } else {
            return response([
                'message' => 'No project with ID=' . $request->project_id . ' found',
            ], 400);}
    }

    /**
     * destroy
     *
     * @param  Request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        try {
            $histories = History::where('project_id', $request->project_id);

            foreach ($histories->get() as $history) {
                Result::where('history_id', $history->id)->delete();
            }

            $histories->delete();

            Project::findOrFail($request->project_id)->delete();

            return response()->json([
                'message' => 'Project successfully deleted',
            ], 200);

        } catch (ModelNotFoundException | ErrorException $e) {
            return response()->json([
                'message' => 'Error while connecting to database',
            ], 500);
        }
    }
}
