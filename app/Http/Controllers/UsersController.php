<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public function tambah_user(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => ['required'],
            'provinsi' => ['required'],
            'kota' => ['required'],
            'kecamatan' => ['required'],
            'kelurahan' => ['required'],
            'alamat_lengkap' => ['required'],
            'no_telp' => ['required'],
            'uid' => ['required'],
            'nama' => ['required'],
            'no_telp' => ['required'],
            'token_id' => ['required'],

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $insert = User::create($request->all());

        $response = [
            'message' => 'berhasil insert',
            'status' => 1,
            'data' => $insert,
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    public function cek_user(Request $request)
    {
        $read = User::where('email', $request->input('email'))->first();
        if ($read != null) {
            $response = [
                'message' => 'ada',
                'status' => 1,
                'data' => $read
            ];
        } else {
            $response = [
                'message' => 'tidak ada',
                'status' => 0
            ];
        }

        return response()->json($response, Response::HTTP_CREATED);
    }
}
