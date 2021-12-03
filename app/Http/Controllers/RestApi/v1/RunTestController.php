<?php

namespace App\Http\Controllers\RestApi\v1;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\Project;
use App\Models\Result;
use App\Tests\PrestaShopVersion;
use Illuminate\Http\Request;

class RunTestController extends Controller
{

    /**
     * Run new test and create new resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $project = Project::findOrFail($request->project_id);
        $test_results = PrestaShopVersion::detect($project->url);

        $history = new History();
        $history->project_id = $request->project_id;
        if (!$history->save()) {
            return response()->json([
                'message' => 'Error while connecting to database',
            ], 400);
        }

        $result = new Result();
        $result->history_id = $history->id;
        $result->test_id = $test_results['test_id'];
        $result->result = $test_results['result'];
        if (!$result->save()) {
            return response()->json([
                'message' => 'Error while connecting to database',
            ], 400);
        }

        return response()->json($test_results);
    }
}
