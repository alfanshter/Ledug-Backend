<?php

namespace App\Http\Controllers;

use App\Models\Fitur;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class FiturController extends Controller
{
    public function tambah_fitur(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => ['required'],
            'fitur' => ['required'],
            'foto' => 'required|image',
            'harga' => ['required']
        ]);

        $postdata = $request->all();
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            if ($request->file('foto')) {
                $postdata['foto'] = $request->file('foto')->store('foto-fitur', 'public');
            }

            $insertversi = Fitur::create($postdata);
            $response = [
                'message' => 'berhasil insert',
                'data' => 1
            ];

            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json(['message' => "Failed", 'data' => $e->errorInfo], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function get_fitur(Request $request)
    {
        $fitur = Fitur::where('nama', $request->input('nama'))->get();
        $response = [
            'message' => 'ada',
            'status' => 1,
            'data' => $fitur
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }
}
