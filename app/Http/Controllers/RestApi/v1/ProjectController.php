<?php

namespace App\Http\Controllers\RestApi\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
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
}
