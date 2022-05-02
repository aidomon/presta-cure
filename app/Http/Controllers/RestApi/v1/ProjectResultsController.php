<?php

namespace App\Http\Controllers\RestApi\v1;

use App\Http\Controllers\Controller;
use App\Models\Project;
use ErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectResultsController extends Controller
{
    /**
     * Display a listing of project test results.
     *
     * @return App\Models\Project
     */
    public function index(Request $request)
    {
        try {
            $project = Project::findOrFail($request->project_id);
            if (Auth::user()->projects->contains($project) and $project->verified == 1 and $project->history->count() > 0) {
                $results = array();

                foreach ($project->history->sortDesc() as $history) {
                    if ($history->results->count() > 0) {
                        $history_data = array();
                        foreach ($history->results as $result) {
                            $history_data[] = array($result);
                        }
                        array_push($results, array($history->created_at->format('d-m-Y') => $history_data));
                    }
                }
                return response()->json($results);
            } else {
                return response([
                    'message' => 'No tests results for specified project found',
                ], 200);
            }
        } catch (ModelNotFoundException | ErrorException $e) {
            return response([
                'message' => 'Specified project not found',
            ], 400);
        }
    }
}
