<?php

namespace App\Http\Controllers;

use App\Models\MultiDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeafletDesaController extends Controller
{

    public function index()
    {
        return view('leafletdesa.leafletdesa');
    }
    public function marker(Request $request)
    {
        $latitude = $request->latitude;
        $longitude = $request->longitude;


        $desa = MultiDesa::select("*", DB::raw("6371 * acos(cos(radians(" . $latitude . "))
             * cos(radians(latitude)) * cos(radians(longitude) - radians(" . $longitude . "))
             + sin(radians(" . $latitude . ")) * sin(radians(latitude))) AS distance"))
            ->having('distance', '<', 5)
            ->with('desa')
            ->orderBy('distance')
            ->get();

        return response()->json($desa);
    }
}
