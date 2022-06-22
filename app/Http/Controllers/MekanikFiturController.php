<?php

namespace App\Http\Controllers;

use App\Models\MekanikFitur;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MekanikFiturController extends Controller
{
    public function tambah_fitur_mekanik(Request $request)
    {
        $tambah = MekanikFitur::create([
            'jenis_pekerjaan' => $request->jenis_pekerjaan,
            'mekanik_uid' => $request->mekanik_uid,
            'fitur_id' => $request->fitur_id
        ]);

        $response = [
            'message' => 'pendaftaran berhasil berhasil',
            'status' => 1
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }
}
