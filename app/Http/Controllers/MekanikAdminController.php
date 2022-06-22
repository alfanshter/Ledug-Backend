<?php

namespace App\Http\Controllers;

use App\Models\MekanikAdmin;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class MekanikAdminController extends Controller
{
    public function tambah_ppn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ppn' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $cekppn = MekanikAdmin::first();
            if ($cekppn == null) {
                $insert = MekanikAdmin::create($request->all());
                $response = [
                    'message' => 'berhasil insert',
                    'status' => 1
                ];

                return response()->json($response, Response::HTTP_CREATED);
            } else {
                $update = DB::table('mekanikadmins')->update($request->all());
                $response = [
                    'message' => 'berhasil update',
                    'status' => 1
                ];

                return response()->json($response, Response::HTTP_CREATED);
            }
        } catch (QueryException $th) {
            $response = [
                'message' => 'berhasil insert',
                'status' => $th->errorInfo
            ];

            return response()->json($response, Response::HTTP_CREATED);
        }
    }
}
