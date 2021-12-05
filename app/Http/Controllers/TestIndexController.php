<?php

namespace App\Http\Controllers;

use App\Models\Test;

class TestIndexController extends Controller
{
    /**
     * Index all available tests.
     *
     * @return view
     */
    public function __invoke()
    {
        return view('layouts.tests', [
            'tests' => Test::all(),
        ]);
    }
}
