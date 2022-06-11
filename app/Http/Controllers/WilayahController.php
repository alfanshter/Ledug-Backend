<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class WilayahController extends Controller
{
    public function provinsi()
    {
        $provinces = Province::all();
        $response = [
            'message' => 'berhasil insert',
            'data' => $provinces
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    public function kabupaten(Request $request)
    {
        $kabupaten = Regency::where('province_id', $request->province_id)->get();
        $response = [
            'message' => 'berhasil insert',
            'data' => $kabupaten
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    public function kecamatan(Request $request)
    {
        $kecamatan = District::where('regency_id', $request->regency_id)->get();
        $response = [
            'message' => 'berhasil insert',
            'data' => $kecamatan
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    public function desa(Request $request)
    {
        $desa = Village::where('district_id', $request->district_id)->get();
        $response = [
            'message' => 'berhasil insert',
            'data' => $desa
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }
}
