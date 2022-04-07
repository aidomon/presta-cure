<?php

namespace App\Http\Controllers\RestApi\v1;

use App\Models\Test;
use App\Models\Result;
use App\Models\History;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AllTestsController extends Controller
{
     /**
     * Display a listing of all tests.
     *
     * @return App\Models\Test
     */
    public function index()
    {
        return Test::all();
    }

    /**
     * Search for specified name in all tests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return App\Models\Test
     */
    public function search(Request $request)
    {
        return Test::where('name', 'like', '%' . $request->str . '%')
            ->orWhere('description', 'like', '%' . $request->str . '%')
            ->get();
    }

    /**
     * Run all tests and create new resources in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $project_url = auth()->user()->projects->where('id', 1)[0]->url;
            $tests = Test::all();

            $all_test_results = array();

            foreach ($tests as $test) {
                $instance = 'App\Tests\\' . $test->class;

                $test_result = $instance::detect($project_url);

                $history = new History();
                $history->project_id = $request->project_id;
                if (!$history->save()) {
                    return response()->json([
                        'message' => 'Error while connecting to database',
                    ], 400);
                }

                $result = new Result();
                $result->history_id = $history->id;
                $result->test_id = $test_result['test_id'];
                $result->result = $test_result['result'];
                if (!$result->save()) {
                    return response()->json([
                        'message' => 'Error while connecting to database',
                    ], 400);
                }
                array_push($all_test_results, $test_result);
            }

        } catch (ModelNotFoundException $e) {
            return response([
                'message' => 'Specified project or test not found',
            ]);
        }

        return response($all_test_results);


        // return response([
        //     'project' => $request->project_id
        // ]);
    }
}
