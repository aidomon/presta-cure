<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Project;
use App\Models\Result;
use App\Models\Test;
use ErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
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
        $project->verified = 0;
        $project->slug = Project::createUrlSlug($project->name);

        $project->save();

        return redirect('/dashboard')->with('status', 'To start pentesting, verify your project by placing prestacure.html file to the web root.');
    }

    /**
     * Display specific project.
     *
     * @param  Project $project
     * @return view
     */
    public function show(Project $project)
    {
        if (Auth::user()->projects->contains($project) and $project->verified == 1) {
            return view('layouts.project', [
                'project_details' => $project,
                'project_history' => $project->history->sortDesc(),
                'tests' => Test::all(),
            ]);
        } else {
            return abort(404);
        }
    }

    /**
     * Verify new project.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $requested_project = Auth::user()->projects->where('id', $request->project_id)->first();
        $file_check = curl_init($requested_project->url . '/prestacure.html');

        curl_setopt($file_check, CURLOPT_NOBODY, true);
        curl_exec($file_check);
        curl_close($file_check);

        if (curl_getinfo($file_check, CURLINFO_HTTP_CODE) == 200) {
            $requested_project->verified = 1;
            $requested_project->save();
            return redirect('/dashboard')->with('status', 'Your project has been verified!');
        }

        return redirect('/dashboard')->with('status', 'Specified file is not present. Project not verified');
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
