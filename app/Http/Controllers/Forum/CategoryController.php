<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::query()
            ->withCount('threads') // Nanti kita akan buat relasi 'threads'
            ->orderBy('name')
            ->get();

        return view('forum.categories.index', compact('categories'));
    }
}
