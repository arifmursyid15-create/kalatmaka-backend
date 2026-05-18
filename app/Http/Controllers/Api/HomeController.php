<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HomepageBanner;
use App\Models\Portfolio;
use App\Models\Katalog;
use App\Models\Testimonial;
use App\Models\Blog;

class HomeController extends Controller
{
    public function index()
    {
        return response()->json([
            'banners' => HomepageBanner::where('is_active', true)
                ->orderBy('order')
                ->get(),
            'portfolio_preview' => Portfolio::where('is_active', true)
                ->latest()
                ->take(6)
                ->get(),
            'katalog_preview' => Katalog::with('category')
                ->where('is_active', true)
                ->latest()
                ->take(8)
                ->get(),
            'testimonials' => Testimonial::where('is_active', true)
                ->latest()
                ->take(6)
                ->get(),
            'blog_preview' => Blog::with('category')
                ->where('is_active', true)
                ->latest()
                ->take(3)
                ->get(),
        ]);
    }
}
