<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use League\CommonMark\CommonMarkConverter;

class ThreadController extends Controller
{
    public function index(Category $category)
    {
        $threads = $category->threads()->with('author')->latest()->paginate(10);
        return view('threads.index', compact('category', 'threads'));
    }

    public function create(Category $category)
    {
        return view('threads.create', compact('category'));
    }

    public function store(Request $request, Category $category)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required|min:10',
        ]);

        $category->threads()->create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return redirect()->route('threads.index', $category);
    }

    public function show(Category $category, Thread $thread)
    {
        // Konversi body dari markdown ke html
        $converter = new CommonMarkConverter();
        $thread->body = Str::of($converter->convert($thread->body));

        return view('threads.show', compact('category', 'thread'));
    }
}
