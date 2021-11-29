<?php

namespace App\Http\Controllers;

class HomeShowController extends Controller
{
    /**
     * Show home page.
     *
     * @return view
     */
    public function __invoke()
    {
        return view('welcome');
    }
}
