<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BayarBeli;
use Illuminate\Http\Request;

class BayarBeliController extends Controller
{
    public function bayarbeli()
    {
        $bayarbeli = BayarBeli::all();

        $response = [
            'message' => ' berhasil',
            'status' => 1,
            'data' => $bayarbeli
        ];

        return response()->json($response, 200);
    }
}
