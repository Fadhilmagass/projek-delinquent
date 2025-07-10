<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\CommonMarkConverter;

class ArticleController extends Controller
{
    protected $converter;

    public function __construct()
    {
        // Memastikan hanya user yang sudah login yang bisa mengakses metode tertentu
        $this->middleware('auth')->except(['index', 'show']);
        $this->converter = new CommonMarkConverter();
    }

    public function index(Request $request)
    {
        $query = Article::with('author', 'tags')->latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('excerpt', 'like', '%' . $search . '%')
                  ->orWhere('body', 'like', '%' . $search . '%');
            });
        }

        $articles = $query->paginate(9);

        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        $this->authorize('create', Article::class);
        return view('articles.create', [
            'article' => new Article(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Article::class);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'required|max:300',
            'body' => 'required|min:50',
            'tags' => 'required|string|regex:/^[\w\s,-]+$/',
            'image' => 'nullable|image|max:2048', // Maks 2MB
        ]);

        $article = auth()->user()->articles()->create($validated);

        if ($request->hasFile('image')) {
            $article->image = $request->file('image')->store('articles', 'public');
            $article->save();
        }

        // Proses tags
        $tags = array_map('trim', explode(',', $request->tags));
        $article->syncTags($tags);

        return redirect()->route('articles.show', $article)->with('success', 'Artikel berhasil dipublikasikan!');
    }

    public function show(Article $article)
    {
        // Konversi body dari markdown ke html
        $article->body = Str::of($this->converter->convert($article->body));

        return view('articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        $this->authorize('update', $article);
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $this->authorize('update', $article);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'required|max:300',
            'body' => 'required|min:50',
            'tags' => 'required|string|regex:/^[\w\s,-]+$/',
            'image' => 'nullable|image|max:2048',
        ]);

        $article->update($validated);

        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $article->image = $request->file('image')->store('articles', 'public');
            $article->save();
        } elseif ($request->input('remove_image') == '1' && $article->image) {
            Storage::disk('public')->delete($article->image);
            $article->image = null;
            $article->save();
        }

        $tags = explode(',', $request->tags);
        $article->syncTags($tags);

        return redirect()->route('articles.show', $article)->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);
        $article->delete(); // Soft delete
        return redirect()->route('articles.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
