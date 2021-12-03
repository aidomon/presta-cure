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
        $projects = Auth::user()->projects;

        return view('layouts.projects', [
            'projects' => $projects,
            'not_verified_projects_count' => $projects->where('verified', 0)->count(),
        ]);
    }
}
