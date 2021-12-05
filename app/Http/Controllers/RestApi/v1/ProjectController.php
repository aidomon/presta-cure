<?php

namespace App\Http\Controllers\RestApi\v1;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of all tests.
     *
     * @return App\Models\Project
     */
    public function index()
    {
        return Project::all();
    }

    /**
     * Display info about the specified test.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            return Project::findOrFail($request->project_id);
        } catch (ModelNotFoundException) {
            return response()->json([
                'message' => 'nothing found',
            ], 400);
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
        return Project::where('name', 'like', '%' . $request->str . '%')
            ->orWhere('id', 'like', '%' . $request->str . '%')
            ->get();
    }
}
