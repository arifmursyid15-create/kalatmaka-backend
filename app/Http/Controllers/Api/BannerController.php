<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HomepageBanner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        return response()->json(HomepageBanner::orderBy('order')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|string',
        ]);

        $banner = HomepageBanner::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image' => $request->image,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'is_active' => $request->is_active ?? true,
            'order' => $request->order ?? 0,
        ]);

        return response()->json($banner, 201);
    }

    public function update(Request $request, $id)
    {
        $banner = HomepageBanner::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|string',
        ]);

        $banner->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image' => $request->image,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'is_active' => $request->is_active ?? true,
            'order' => $request->order ?? 0,
        ]);

        return response()->json($banner);
    }

    public function destroy($id)
    {
        HomepageBanner::findOrFail($id)->delete();
        return response()->json(['message' => 'Banner berhasil dihapus.']);
    }
}
