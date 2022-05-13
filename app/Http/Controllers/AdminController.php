<?php

namespace App\Http\Controllers;

use App\Tests\LoadAllTests;

class AdminController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        try {
            LoadAllTests::loadTests();
            return response()->json(['status' => '<p style="color:#16a44a">Success</p>']);
        } catch (\Throwable $th) {
            return response()->json(['status' => '<p style="color:red">Something went wrong. Check test files syntax.</p>']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('layouts.administration');
    }
}
