<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProjects = Project::count();
        $activeProjects = Project::where('status', 'active')->count();
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        
        $recentProjects = Project::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProjects',
            'activeProjects', 
            'totalUsers',
            'activeUsers',
            'recentProjects'
        ));
    }
}
