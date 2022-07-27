<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MultiDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DesaTerdekatController extends Controller
{
    public function desa_terdekat(Request $request)
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

        $response = [
            'message' => ' berhasil',
            'status' => 1,
            'data' => $desa
        ];

        return response()->json($response, 200);
    }
}
