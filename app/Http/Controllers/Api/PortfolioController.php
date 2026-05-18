<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    // PUBLIC
    public function index()
    {
        return response()->json(
            Portfolio::where('is_active', true)
                ->latest()
                ->paginate(12)
        );
    }

    public function show($slug)
    {
        $portfolio = Portfolio::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return response()->json($portfolio);
    }

    // ADMIN
    public function adminIndex()
    {
        return response()->json(Portfolio::latest()->paginate(15));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'required|string',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'images' => 'nullable|array',
        ]);

        $portfolio = Portfolio::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'thumbnail' => $request->thumbnail,
            'description' => $request->description,
            'location' => $request->location,
            'images' => $request->images,
            'is_active' => $request->is_active ?? true,
        ]);

        return response()->json($portfolio, 201);
    }

    public function update(Request $request, $id)
    {
        $portfolio = Portfolio::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'required|string',
        ]);

        $portfolio->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . $portfolio->id,
            'thumbnail' => $request->thumbnail,
            'description' => $request->description,
            'location' => $request->location,
            'images' => $request->images,
            'is_active' => $request->is_active ?? true,
        ]);

        return response()->json($portfolio);
    }

    public function destroy($id)
    {
        Portfolio::findOrFail($id)->delete();
        return response()->json(['message' => 'Portfolio berhasil dihapus.']);
    }
}
