<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users',
            'name' => ['required'],
            'password' => ['required'],
            'province_id' => ['required'],
            'regencie_id' => ['required'],
            'district_id' => ['required'],
            'village_id' => ['required'],
            'alamat_lengkap' => ['required']
        ]);

        if ($validator->fails()) {
            $response = [
                'message' => 'Username sudah terdaftar',
                'status' => 2,
                'validator' => $validator->errors()
            ];
            return response()->json($response, 200);
        }

        $postdata = $request->all();
        $postdata['role'] = 2;
        $postdata['password'] = Hash::make($request->password);
        $aktekelahiran = User::create($postdata);


        $response = [
            'message' => 'Akte kelahiran berhasil',
            'status' => 1,
        ];

        return response()->json($response, 200);
    }


    public function login(Request $request)
    {

        $post['email'] = $request->email;
        $post['password'] = $request->password;

        if (Auth::attempt($post)) {
            $users = User::where('email', $request->email)->first();
            $response = [
                'message' => 'login berhasil',
                'status' => 1,
                'data' => $users
            ];

            return response()->json($response, 200);
        } else {
            $response = [
                'message' => 'login gagal',
                'status' => 0,
            ];

            return response()->json($response, 200);
        }
    }
}
