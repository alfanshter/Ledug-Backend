<?php

namespace App\Http\Controllers;

use App\Models\MultiDesa;
use App\Models\Village;
use Illuminate\Http\Request;

class LeafletMapController extends Controller
{
    public function index(Request $request)
    {
        $desa = MultiDesa::where('desa_id', auth()->user()->village_id)
            ->with('desa')
            ->first();

        return view('leaflet.leaflet', compact('desa'));
    }
}
