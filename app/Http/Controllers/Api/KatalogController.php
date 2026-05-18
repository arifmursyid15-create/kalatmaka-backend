<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Katalog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KatalogController extends Controller
{
    // PUBLIC
    public function index(Request $request)
    {
        $query = Katalog::with('category')->where('is_active', true);

        if ($request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->badge) {
            $query->where('badge', $request->badge);
        }

        return response()->json($query->latest()->paginate(12));
    }

    public function show($slug)
    {
        $katalog = Katalog::with('category')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return response()->json($katalog);
    }

    // ADMIN
    public function adminIndex()
    {
        return response()->json(
            Katalog::with('category')->latest()->paginate(15)
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'thumbnail' => 'required|string',
            'price' => 'required|numeric|min:0',
            'badge' => 'in:none,best_seller,promo,new',
        ]);

        $katalog = Katalog::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'thumbnail' => $request->thumbnail,
            'description' => $request->description,
            'spesifikasi' => $request->spesifikasi,
            'price' => $request->price,
            'badge' => $request->badge ?? 'none',
            'images' => $request->images,
            'is_active' => $request->is_active ?? true,
        ]);

        return response()->json($katalog->load('category'), 201);
    }

    public function update(Request $request, $id)
    {
        $katalog = Katalog::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'thumbnail' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);

        $katalog->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . $katalog->id,
            'thumbnail' => $request->thumbnail,
            'description' => $request->description,
            'spesifikasi' => $request->spesifikasi,
            'price' => $request->price,
            'badge' => $request->badge ?? 'none',
            'images' => $request->images,
            'is_active' => $request->is_active ?? true,
        ]);

        return response()->json($katalog->load('category'));
    }

    public function destroy($id)
    {
        Katalog::findOrFail($id)->delete();
        return response()->json(['message' => 'Katalog berhasil dihapus.']);
    }
}
