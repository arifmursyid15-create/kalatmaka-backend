<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    // PUBLIC
    public function index()
    {
        return response()->json(
            Testimonial::where('is_active', true)->latest()->get()
        );
    }

    // ADMIN
    public function adminIndex()
    {
        return response()->json(Testimonial::latest()->paginate(15));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $testimonial = Testimonial::create([
            'name' => $request->name,
            'message' => $request->message,
            'rating' => $request->rating,
            'is_active' => $request->is_active ?? true,
        ]);

        return response()->json($testimonial, 201);
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $testimonial->update($request->only('name', 'message', 'rating', 'is_active'));

        return response()->json($testimonial);
    }

    public function destroy($id)
    {
        Testimonial::findOrFail($id)->delete();
        return response()->json(['message' => 'Testimoni berhasil dihapus.']);
    }
}
