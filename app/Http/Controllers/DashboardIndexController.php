<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardIndexController extends Controller
{
    /**
     * Index projects on dashboard page.
     *
     * @return view
     */
    public function __invoke()
    {
        return view('layouts.projects', [
            'projects' => Auth::user()->projects,
        ]);
    }
}
