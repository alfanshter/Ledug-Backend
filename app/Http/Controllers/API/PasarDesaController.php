<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pasardesa;
use Illuminate\Http\Request;

class PasarDesaController extends Controller
{
    public function pasardesa()
    {
        $pasardesa = Pasardesa::all();

        $response = [
            'message' => ' berhasil',
            'status' => 1,
            'data' => $pasardesa
        ];

        return response()->json($response, 200);
    }
}
