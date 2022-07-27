<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DataStatistikDesa;
use App\Models\GambarDesa;
use App\Models\ProfilDesa;
use App\Models\User;
use Illuminate\Http\Request;

class ProfilDesaController extends Controller
{
    public function profildesa(Request $request)
    {
        // Get user
        $get_user = User::where('id', $request->input('id'))->first();

        $profil = ProfilDesa::where('village_id', $get_user->village_id)
            ->with('provinsi')
            ->with('kota')
            ->with('kecamatan')
            ->with('desa')
            ->first();
        $gambardesa = GambarDesa::where('village_id', $get_user->village_id)->get();
        $datastatistik = DataStatistikDesa::where('village_id', $get_user->village_id)->get();

        $response = [
            'message' => ' berhasil',
            'status' => 1,
            'profil' => $profil,
            'gambar_desa' => $gambardesa,
            'data_statistik' => $datastatistik
        ];

        return response()->json($response, 200);
    }
}
