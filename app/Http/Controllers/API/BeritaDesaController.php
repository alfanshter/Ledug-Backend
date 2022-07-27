<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Pasardesa;
use App\Models\Province;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BeritaDesaController extends Controller
{
    public function beritadesa(Request $request)
    {
        // Get user
        $get_user = User::where('id', $request->id)->first();

        $sekarang = Carbon::today();
        //padardesa
        $pasar_desa = Berita::where('village_id', $get_user->village_id)
            ->where('tanggal_terbit', '<=', $sekarang)
            ->orderBy('tanggal_terbit', 'desc')
            ->get();
        $response = [
            'message' => ' berhasil',
            'status' => 1,
            'data' => $pasar_desa
        ];

        return response()->json($response, 200);
    }


    public function beritadesa_popular(Request $request)
    {
        // Get user
        $get_user = User::where('id', $request->id)->first();

        $sekarang = Carbon::today();
        $popular = Berita::where('village_id', $get_user->village_id)
            ->where('tanggal_terbit', '<=', $sekarang)
            ->orderBy('dikunjungi', 'desc')
            ->get();
        $response = [
            'message' => ' berhasil',
            'status' => 1,
            'data' => $popular
        ];

        return response()->json($response, 200);
    }

    public function tambah_kunjungan_beritadesa(Request $request)
    {
        $cek_berita = Berita::where('id', $request->id)->first();
        $update = Berita::where('id', $request->ud)->update([
            'dikunjungi' => (int)$cek_berita->dikunjungi + 1
        ]);

        $response = [
            'message' => ' berhasil',
            'status' => 1,
            'data' => null
        ];

        return response()->json($response, 200);
    }
}
