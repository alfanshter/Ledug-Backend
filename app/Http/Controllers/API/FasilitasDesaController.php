<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FasilitasDesa;
use App\Models\GambarDesa;
use App\Models\ProfilDesa;
use App\Models\User;
use Illuminate\Http\Request;

class FasilitasDesaController extends Controller
{
    public function fasilitasdesa(Request $request)
    {
        // Get user
        $get_user = User::where('id', $request->input('id'))->first();

        $profil = ProfilDesa::select('deskripsi')->where('village_id', $get_user->village_id)->first();
        $fasilitasdesa = FasilitasDesa::where('village_id', $get_user->village_id)->get();
        $gambardesa = GambarDesa::where('village_id', $get_user->village_id)->get();
        $response = [
            'message' => ' berhasil',
            'status' => 1,
            'fasilitas' => $fasilitasdesa,
            'gambardesa' => $gambardesa,
            'profil' => $profil
        ];

        return response()->json($response, 200);
    }
}
