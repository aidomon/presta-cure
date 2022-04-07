<?php

namespace App\Http\Controllers\RestApi\v1;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\History;
use App\Models\Project;
use App\Models\Result;
use ErrorException;

class TestController extends Controller
{
    /**
     * Display info about the specified test.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            return Test::findOrFail($request->test_id);
        } catch (ModelNotFoundException) {
            return response()->json([
                'message' => 'nothing found',
            ], 400);
        }
    }

    /**
     * Run specific tests and create new resources in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $project = auth()->user()->projects->where('id', $request->project_id)[0]->url;
            $instance = 'App\Tests\\' . Test::findOrFail($request->test_id)->class;
            $test_results = $instance::detect($project);

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

        } catch (ModelNotFoundException | ErrorException $e2) {
            return response([
                'message' => 'Specified project or test not found',
            ]);
        }

        return response($test_results);
    }
}
