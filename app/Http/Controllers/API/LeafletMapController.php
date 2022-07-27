<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MultiDesa;
use App\Models\User;
use Illuminate\Http\Request;

class LeafletMapController extends Controller
{
    public function geospasial(Request $request)
    {
        // Get user
        $get_user = User::where('id', $request->input('id'))->first();

        $desa = MultiDesa::where('desa_id', $get_user->village_id)
            ->with('desa')
            ->first();

        $response = [
            'message' => ' berhasil',
            'status' => 1,
            'desa' => $desa
        ];

        return response()->json($response, 200);
    }
}
