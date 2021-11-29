<?php

namespace App\Http\Controllers\RestApi\v1;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TestController extends Controller
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
}
