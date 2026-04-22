<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimoni;

class TestimoniController extends Controller
{
    public function index()
    {
        $testimonis = Testimoni::where('is_active', true)
            ->latest()
            ->get();

        return response()->json($testimonis);
    }
}