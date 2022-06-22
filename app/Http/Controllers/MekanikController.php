<?php

namespace App\Http\Controllers;

use App\Models\Dompet;
use App\Models\Mekanik;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Request\CreateUser;

class MekanikController extends Controller
{

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_depan' => ['required'],
            'nama_belakang' => ['required'],
            'no_ktp' => 'required|unique:mekaniks',
            'tgl_lahir' => ['required'],
            'tempat_lahir' => ['required'],
            'no_telp' => ['required'],
            'email' => ['required'],
            'username' => ['required'],
            'password' => ['required'],
            'foto' => ['required'],
            'provinsi' => ['required'],
            'kabupaten' => ['required'],
            'kecamatan' => ['required'],
            'desa' => ['required'],
            'jenis_kelamin' => ['required'],
            'kendaraan' => ['required'],
            'plat_nomor' => ['required'],
            'jenis_kelamin' => ['required'],
            'kendaraan' => ['required'],
            'jenis_pekerjaan' => ['required'],
            'plat_nomor' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        try {

            $cekojek = Mekanik::where('username', $request->username)->first();
            if ($cekojek != null) {
                $response = [
                    'message' => 'Ojek sudah terdaftar',
                    'status' => 0
                ];

                return response()->json($response, Response::HTTP_CREATED);
            }

            $firebase = CreateUser::new()
                ->withUnverifiedEmail($request->username)
                ->withClearTextPassword($request->password)
                ->withDisplayName($request->nama_depan)
                ->withPhotoUrl($request->foto);

            $createdUser = $this->auth->createUser($firebase);

            $insertdata = $request->all();
            $insertdata['uid'] = $createdUser->uid;
            $insertdata['password'] = Hash::make($request->password);
            $aktekelahiran = Mekanik::create($insertdata);

            //insert dompet 
            $dompet = Dompet::create([
                'uid' => $createdUser->uid,
                'saldo' => 30000
            ]);

            $response = [
                'message' => 'pendaftaran berhasil berhasil',
                'status' => 1
            ];

            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            $response = [
                'message' => 'pendaftaran berhasil berhasil',
                'data' => $e->errorInfo
            ];

            return response()->json($response, Response::HTTP_BAD_REQUEST);
        }
    }

    public function loginmekanik(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required'],
            'password' => ['required'],
            'token' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $ceklogin = Mekanik::where('username', $request->username)->first();
            if ($ceklogin != null) {
                $password = Hash::check($request->password, $ceklogin['password']);
                if ($password == true) {
                    $updatetoken = Mekanik::where('username', $request->username)->update([
                        'token_id' => $request->token
                    ]);

                    $response = [
                        'message' => 'login berhasil',
                        'status' => 1,
                        'data' => $ceklogin
                    ];
                    return response()->json($response, Response::HTTP_OK);
                } else {
                    $response = [
                        'message' => 'Password Salah',
                        'status' => 0,
                        'data' => null
                    ];

                    return response()->json($response, Response::HTTP_OK);
                }
            } else {

                $response = [
                    'message' => 'login gagal',
                    'status' => 0,
                    'data' => null
                ];

                return response()->json($response, Response::HTTP_OK);
            }
        } catch (QueryException $th) {
            $response = [
                'message' => 'Akte kelahiran berhasil',
                'data' => $th->errorInfo
            ];

            return response()->json($response, Response::HTTP_BAD_REQUEST);
        }
    }
}
