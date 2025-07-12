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

    public function create()
    {
        // Ambil semua kategori untuk ditampilkan di dropdown
        $categories = Category::all();
        return view('threads.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required|min:10',
            'category_id' => 'required|exists:categories,id', // Validasi kategori
        ]);

        $thread = Thread::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'body' => $request->body,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('threads.show', $thread->slug);
    }

    public function show(Thread $thread)
    {
        // Konversi body dari markdown ke html jika perlu
        // $converter = new CommonMarkConverter();
        // $thread->body = Str::of($converter->convert($thread->body));

        // Eager load relasi untuk efisiensi
        $thread->load(['author', 'category']);

        return view('threads.show', compact('thread'));
    }

    public function edit(Thread $thread)
    {
        $this->authorize('update', $thread); // Memastikan hanya pemilik yang bisa mengedit
        $categories = Category::all();
        return view('threads.edit', compact('thread', 'categories'));
    }

    public function update(Request $request, Thread $thread)
    {
        $this->authorize('update', $thread); // Memastikan hanya pemilik yang bisa mengupdate

        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required|min:10',
            'category_id' => 'required|exists:categories,id',
        ]);

        $thread->update([
            'title' => $request->title,
            'body' => $request->body,
            'category_id' => $request->category_id,
            'slug' => Str::slug($request->title), // Update slug based on new title
        ]);

        return redirect()->route('threads.show', $thread->slug)->with('success', 'Thread berhasil diperbarui!');
    }

    public function destroy(Thread $thread)
    {
        $this->authorize('delete', $thread); // Memastikan hanya pemilik yang bisa menghapus

        $thread->delete();

        return redirect()->route('forum.index')->with('success', 'Thread berhasil dihapus!');
    }
}
