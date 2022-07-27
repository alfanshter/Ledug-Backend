<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BudayaLokal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BudayaLokalController extends Controller
{
    public function budayalokal(Request $request)
    {
        // Get user
        $get_user = User::where('id', $request->id)->first();

        $sekarang = Carbon::today();
        //padardesa
        $pasar_desa = BudayaLokal::where('village_id', $get_user->village_id)
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
}
