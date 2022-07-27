<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Tvcc;
use Illuminate\Http\Request;

class TvccController extends Controller
{
    public function tvcc()
    {
        $tvcc = Tvcc::all();

        $response = [
            'message' => ' berhasil',
            'status' => 1,
            'data' => $tvcc
        ];

        return response()->json($response, 200);
    }
}
