<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    // PUBLIC
    public function index(Request $request)
    {
        $query = Blog::with('category')->where('is_active', true);

        if ($request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        return response()->json($query->latest()->paginate(9));
    }

    public function show($slug)
    {
        $blog = Blog::with('category')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $related = Blog::with('category')
            ->where('category_id', $blog->category_id)
            ->where('id', '!=', $blog->id)
            ->where('is_active', true)
            ->latest()
            ->take(3)
            ->get();

        return response()->json([
            'blog' => $blog,
            'related' => $related,
        ]);
    }

    // ADMIN
    public function adminIndex()
    {
        return response()->json(
            Blog::with('category')->latest()->paginate(15)
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'thumbnail' => 'required|string',
            'content' => 'required|string',
        ]);

        $blog = Blog::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'thumbnail' => $request->thumbnail,
            'content' => $request->content,
            'meta_title' => $request->meta_title ?? $request->title,
            'meta_description' => $request->meta_description,
            'is_active' => $request->is_active ?? true,
        ]);

        return response()->json($blog->load('category'), 201);
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'thumbnail' => 'required|string',
            'content' => 'required|string',
        ]);

        $blog->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . $blog->id,
            'thumbnail' => $request->thumbnail,
            'content' => $request->content,
            'meta_title' => $request->meta_title ?? $request->title,
            'meta_description' => $request->meta_description,
            'is_active' => $request->is_active ?? true,
        ]);

        return response()->json($blog->load('category'));
    }

    public function destroy($id)
    {
        Blog::findOrFail($id)->delete();
        return response()->json(['message' => 'Blog berhasil dihapus.']);
    }
}
