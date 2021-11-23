<?php

namespace App\Http\Controllers\RestApi\v1;

use App\Models\Test;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Test::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            return Test::findOrFail($request->test_id);
        }
        catch (ModelNotFoundException) {
            return response()->json([
                'message'   => 'nothing found'
             ],400);
        }
        
    }

    /**
     * Search for specified name.
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        return Test::where('name', 'like', '%' . $request->name . '%')
            ->orWhere('description', 'like', '%' . $request->name . '%')
            ->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
