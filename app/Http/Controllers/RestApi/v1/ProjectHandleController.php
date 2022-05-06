<?php

namespace App\Http\Controllers\RestApi\v1;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\Project;
use App\Models\Result;
use ErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProjectHandleController extends Controller
{
    /**
     * Verify new project.
     *
     * @param  Project  $project
     * @return Response
     */
    public function update(Request $request)
    {
        $requested_project = $request->user()->projects->where('id', $request->project_id)->first();
        $file_check = curl_init($requested_project->url . '/prestacure.html');

        curl_setopt($file_check, CURLOPT_NOBODY, true);
        curl_exec($file_check);
        curl_close($file_check);

        if (curl_getinfo($file_check, CURLINFO_HTTP_CODE) == 200) {
            $requested_project->verified = 1;
            if ($requested_project->save()) {
                return response([
                    'message' => 'Your project has been verified. Start pentesting!',
                ]);
            }
        }

        return response([
            'message' => 'Specified file is not present. Project not verified!',
        ], 400);
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
            return response()->json([
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
