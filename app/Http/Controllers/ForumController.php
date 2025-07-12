<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua kategori beserta jumlah thread di dalamnya
        $categories = Category::withCount('threads')->get();

        return view('forum.index', compact('categories'));
    }
}
