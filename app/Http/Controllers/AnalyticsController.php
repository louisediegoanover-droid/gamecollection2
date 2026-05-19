<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $userCount = User::where('role', 'user')->count();

        $activeCount = User::where('status', 'active')->count();
        $inactiveCount = User::where('status', 'inactive')->count();

        $activeUsers = User::where('status', 'active')
          ->select('id', 'name', 'email', 'role', 'status', 'avatar')
            ->limit(10)
            ->get();

        $inactiveUsers = User::where('status', 'inactive')
           ->select('id', 'name', 'email', 'role', 'status', 'avatar')
            ->limit(10)
            ->get();

        $recentActivities = [
            ['title' => 'John updated profile', 'time' => '2 mins ago', 'icon' => '👤'],
            ['title' => 'Sarah played 5 games', 'time' => '15 mins ago', 'icon' => '🎮'],
            ['title' => 'Mike made purchase', 'time' => '1 hour ago', 'icon' => '💰'],
            ['title' => 'Admin approved user', 'time' => '3 hours ago', 'icon' => '✅'],
        ];

        return view('analytics', compact(
            'totalUsers',
            'adminCount',
            'userCount',
            'activeCount',
            'inactiveCount',
            'activeUsers',
            'inactiveUsers',
            'recentActivities'
        ));
    }
}