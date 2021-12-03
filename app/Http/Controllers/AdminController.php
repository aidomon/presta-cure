<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Tests\LoadAllTests;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        LoadAllTests::loadTests();
        return response()->json(['status'=>'SUCCESS']);
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
