<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\KegiatanDesa;
use App\Models\User;
use Illuminate\Http\Request;

class KegiatanDesaController extends Controller
{
    public function kegiatandesa(Request $request)
    {
        // Get user
        $get_user = User::where('id', $request->input('id'))->first();

        $kegiatandesa = KegiatanDesa::where('village_id', $get_user->village_id)->get();
        $response = [
            'message' => ' berhasil',
            'status' => 1,
            'kegiatandesa' => $kegiatandesa
        ];

        return response()->json($response, 200);
    }
}
