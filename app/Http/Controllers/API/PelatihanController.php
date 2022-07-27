<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PelatihanController extends Controller
{
    public function pelatihan(Request $request)
    {
        // Get user
        $get_user = User::where('id', $request->input('id'))->first();
        $startDate = Carbon::today();
        $endDate = Carbon::today()->addDays(7);

        //pelatihan minggu ini 
        $pelatihan_minggu =  Pelatihan::where('village_id', $get_user->village_id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();

        //pelatihan akan datang
        $akan_datang = Carbon::today()->subDay(7);
        $pelatihan_akandatang = Pelatihan::where('village_id', $get_user->village_id)
            ->where('tanggal', '>', $endDate)
            ->get();
        $response = [
            'message' => ' berhasil',
            'status' => 1,
            'pelatihan_minggu_ini' => $pelatihan_minggu,
            'pelatihan_akan_datang' => $pelatihan_akandatang
        ];

        return response()->json($response, 200);
    }
}
