<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::where('is_active', true)
            ->orderBy('urutan')
            ->get()
            ->map(function ($item) {
                $item->foto_url = asset('storage/' . $item->foto);
                return $item;
            });

        return response()->json($portfolios);
    }
}