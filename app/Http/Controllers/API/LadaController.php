<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lada;
use Illuminate\Http\Request;

class LadaController extends Controller
{
    public function lada()
    {
        $lada = Lada::all();

        $response = [
            'message' => ' berhasil',
            'status' => 1,
            'data' => $lada
        ];

        return response()->json($response, 200);
    }
}
