<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Eager load counts for statistics
        $user->loadCount(['threads', 'comments', 'followers', 'following']);

        // Get recent activities
        $threads = $user->threads()->with('category')->latest()->limit(5)->get();
        $comments = $user->comments()->with('commentable')->latest()->limit(5)->get();

        // Merge and sort activities
        $activities = $threads->concat($comments)->sortByDesc('created_at')->take(10);

        return view('dashboard', [
            'user' => $user,
            'activities' => $activities,
        ]);
    }
}