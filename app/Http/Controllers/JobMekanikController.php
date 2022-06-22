<?php

namespace App\Http\Controllers;

use App\Models\Dompet;
use App\Models\JobMekanik;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class JobMekanikController extends Controller
{

    public function cek_pekerjaan(Request $request)
    {
        try {
            $cekdata = JobMekanik::where('mekanik_uid', $request->input('mekanik_uid'))->first();
            if ($cekdata != null) {
                if ($cekdata->is_aktif == 2) {
                    $response = [
                        'message' => 'waktu kerja',
                        'status' => 2,
                        'is_aktif' => $cekdata->is_aktif,
                        'data' => $cekdata->kode_pesanan
                    ];
                    return response()->json($response, Response::HTTP_OK);
                } else if ($cekdata->is_aktif == 0) {
                    $response = [
                        'message' => 'sukses',
                        'status' => 0,
                        'data' => null
                    ];

                    return response()->json($response, Response::HTTP_OK);
                } else {
                    $response = [
                        'message' => 'sukses',
                        'status' => 1,
                        'data' => null
                    ];

                    return response()->json($response, Response::HTTP_OK);
                }
            } else {
                $response = [
                    'message' => 'sukses',
                    'status' => 0,
                    'data' => null
                ];

                return response()->json($response, Response::HTTP_OK);
            }
        } catch (QueryException $th) {
            $response = [
                'message' => 'sukses',
                'status' => 0,
                'data' => $th->errorInfo
            ];

            return response()->json($response, Response::HTTP_OK);
        }
    }

    public function aktifkan_pekerjaan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uid' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            //cek saldo mekanik
            $ceksaldomekanik = Dompet::where('uid', $request->uid)->first();
            if ($ceksaldomekanik->saldo > 10000) {
                //saldo diatas 10k
                //cek hati 
                $cekhati = DB::table('mekaniks')->select('hati')->where('uid', $request->uid)->first();
                if ($cekhati->hati <= 0) {
                    $response = [
                        'message' => 'hati sudah habis',
                        'status' => 3,
                        'data' => null
                    ];

                    return response()->json($response, Response::HTTP_OK);
                } else {
                    $cekmekanik = JobMekanik::where('mekanik_uid', $request->uid)->first();
                    if ($cekmekanik != null) {
                        $updatedata = DB::table('job_mekaniks')->where('mekanik_uid', $request->uid)->update([
                            'latitude' => $request->latitude,
                            'longitude' => $request->longitude,
                            'bearing' => $request->bearing,
                            'is_aktif' => 1
                        ]);

                        $response = [
                            'message' => 'sukses',
                            'status' => 1,
                            'data' => null
                        ];

                        return response()->json($response, Response::HTTP_OK);
                    }
                    $insertdata = JobMekanik::create(
                        [
                            'mekanik_uid' => $request->uid,
                            'latitude' => $request->latitude,
                            'longitude' => $request->longitude,
                            'bearing' => $request->bearing,
                            'is_aktif' => 1

                        ]
                    );
                    $response = [
                        'message' => 'sukses',
                        'status' => 1,
                        'data' => null
                    ];

                    return response()->json($response, Response::HTTP_OK);
                }
            } else {
                //saldo dibawah 10k
                $response = [
                    'message' => 'saldo habis',
                    'status' => 2,
                    'data' => null
                ];

                return response()->json($response, Response::HTTP_OK);
            }
        } catch (QueryException $th) {
            $response = [
                'message' => 'sukses',
                'status' => 0,
                'data' => $th->errorInfo
            ];

            return response()->json($response, Response::HTTP_OK);
        }
    }

    public function matikan_pekerjaan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uid' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $updatedata = JobMekanik::where('mekanik_uid', $request->uid)->update([
                'is_aktif' => 0
            ]);

            $response = [
                'message' => 'sukses',
                'status' => 1,
                'data' => null
            ];

            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $th) {
            $response = [
                'message' => 'sukses',
                'status' => 0,
                'data' => $th->errorInfo
            ];

            return response()->json($response, Response::HTTP_OK);
        }
    }
}
