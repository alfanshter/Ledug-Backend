<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = [
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'status' => 1
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = [
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'status' => 1
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    public function profil(Request $request)
    {
        $profil = User::where('id', $request->id)
            ->with('desa')
            ->with('kecamatan')
            ->with('kabupaten')
            ->with('provinsi')
            ->first();

        return response()->json($profil, Response::HTTP_CREATED);
    }


    public function logout(User $user)
    {

        $user->tokens()->delete();

        $response = [
            'status' => 1
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    public function search_user(Request $request)
    {
        $email = $request->input('email');
        $data = User::where('email', 'like', "$email")->where('role', 2)->get();
        $response = [
            'message' => 'data sebagai berikut',
            'status' => 1,
            'data' => $data
        ];
        return response()->json($response, 200);
    }

    public function update_profil(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'id' => 'required',
        ]);

        //cek profil
        $cekprofil = User::where('id', $request->id)->first();

        //cek username orang lain 
        if ($request->email != $cekprofil->email) {
            //cek email 
            $cekemail = User::where('email', $request->email)->first();
            if ($cekemail != null) {
                $response = [
                    'message' => 'Email Sudah Terdaftar',
                    'status' => 0,
                    'data' => $cekemail
                ];
                return response()->json($response, 200);
            }
        }

        //cek nik orang lain 
        if ($request->nik != $cekprofil->nik) {
            //cek email 
            $ceknik = User::where('nik', $request->nik)->first();
            if ($ceknik != null) {
                $response = [
                    'message' => 'NIK Sudah Terdaftar',
                    'status' => 0,
                    'data' => $ceknik
                ];
                return response()->json($response, 200);
            }
        }

        $postdata = [
            'name' => $request->name,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'nik' => $request->nik,
            'alamat_lengkap' => $request->alamat_lengkap
        ];

        if ($request->file('foto')) {
            $postdata['foto'] = $request->file('foto')->store('foto', 'public');
            if ($request->foto_lama) {
                Storage::disk('public')->delete($request->foto_lama);
            }
        }

        if ($request->file('foto_kk')) {
            $postdata['foto_kk'] = $request->file('foto_kk')->store('foto', 'public');
            if ($request->foto_lama_kk) {
                Storage::disk('public')->delete($request->foto_lama_kk);
            }
        }

        if ($request->file('foto_akta')) {
            $postdata['foto_akta'] = $request->file('foto_akta')->store('foto', 'public');
            if ($request->foto_lama_akta) {
                Storage::disk('public')->delete($request->foto_lama_akta);
            }
        }

        if ($request->file('foto_ktp')) {
            $postdata['foto_ktp'] = $request->file('foto_ktp')->store('foto', 'public');
            if ($request->foto_lama_ktp) {
                Storage::disk('public')->delete($request->foto_lama_ktp);
            }
        }

        $update = User::where('id', $request->id)->update($postdata);
        $response = [
            'message' => 'data sebagai berikut',
            'status' => 1,
            'data' => $postdata
        ];
        return response()->json($response, 200);
    }
}
