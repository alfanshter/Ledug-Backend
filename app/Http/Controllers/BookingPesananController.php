<?php

namespace App\Http\Controllers;

use App\Jobs\JobMekanikJob;
use App\Models\JobMekanik;
use App\Models\Mekanik;
use App\Models\MekanikAdmin;
use App\Models\Pesanan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Messaging\CloudMessage;
use Symfony\Component\HttpFoundation\Response;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Contract\Database;
use Kreait\Firebase\Contract\Messaging;

class BookingPesananController extends Controller
{

    public function __construct(Messaging $messaging, Database $database)
    {
        $this->messaging = $messaging;
        $this->database = $database;
    }

    public function cari_mekanik(Request $request)
    {
        //Pelanggan
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $jenis_mekanik = $request->jenis_mekanik;
        $fitur = $request->fitur;
        $jarak  = 3;
        $getmekanik = JobMekanik::select(
            "job_mekaniks.*",
            DB::raw("6371 * acos(cos(radians(" . $latitude . "))
             * cos(radians(latitude)) * cos(radians(longitude) - radians(" . $longitude . "))
             + sin(radians(" . $latitude . ")) * sin(radians(latitude))) AS distance")
        )
            ->having('distance', '<', $jarak)
            ->where('is_aktif', 1)
            ->whereHas('mekanik', function ($query) use ($jenis_mekanik, $fitur) {
                $query->where('jenis_pekerjaan', $jenis_mekanik)

                    ->whereHas('mekanik_fitur', function ($qfitur) use ($fitur) {
                        $qfitur->where('fitur_id', $fitur);
                    });
            })
            ->orderBy('distance', 'desc')
            ->first();

        //cek ongkir
        $ongkir = 0;
        $jarak_mekanik = 0;

        if ($getmekanik != null) {
            $harga_perkm = 2000;
            $harga_ongkir = 5000;
            if ($getmekanik->distance > 2) {
                $a = $getmekanik->distance - 2;
                $b = $a * $harga_perkm;
                $ongkir = $harga_ongkir + $b;
                if ($getmekanik->distance > 5) {
                    $a_mobil = $getmekanik->distance - 5;
                    $b_mobil = $a_mobil * $harga_perkm;
                    $ongkir = $harga_ongkir + $b_mobil;
                }
            } else {
                $ongkir = $harga_ongkir;
            }

            $jarak_mekanik = round($getmekanik->distance, 1);


            //update status mekanik
            $update_status = JobMekanik::where('mekanik_uid', $getmekanik->mekanik_uid)->update([
                'is_aktif' => 2,
                'updated_at' => Carbon::now()
            ]);

            JobMekanikJob::dispatch($getmekanik->id)->delay(now()->addSeconds(600));
            $response = [
                'message' => 'Akte kelahiran berhasil',
                'data' => $getmekanik,
                'status' => 1,
                'ongkir' => $ongkir,
                'jarak' => $jarak_mekanik,
            ];

            return response()->json($response, Response::HTTP_CREATED);
        }


        $response = [
            'message' => 'Akte kelahiran berhasil',
            'data' => $getmekanik,
            'status' => 0,
            'ongkir' => $ongkir,
            'jarak' => $jarak_mekanik,
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    public function booking_mekanik(Request $request)
    {
        $kode = $this->getkode();
        //cek status mekanik
        $cekmekanik = JobMekanik::where('mekanik_uid', $request->mekanik_uid)->first();
        if ($cekmekanik->is_aktif != 2) {
            $response = [
                'message' => 'berhasil insert',
                'status' => 0,
                'kode_pesanan' => 'OJK-' . $kode
            ];

            return response()->json($response, Response::HTTP_CREATED);
        }
        //update is aktif mekanik ke 3 artinya dalam bekerja
        $update_isjob_mekanik = JobMekanik::where('mekanik_uid', $request->mekanik_uid)->update([
            'is_aktif' => 3,
            'kode_pesanan' => 'MKN-' . $kode
        ]);

        ////kirim notifikasi ke mekanik                
        //$cek_token_mekanik = Mekanik::where('uid', $request->mekanik_uid)->first();
        //$devicemekanik = $cek_token_mekanik->token_id;

        //$message = CloudMessage::withTarget("token", $devicemekanik)
        //    ->withNotification(Notification::create('Ada pesanan silahkan di antar', 'Body'))
        //    ->withData(['key' => 'value']);

        //$tes =  $this->messaging->send($message);

        //cek ppn admin
        $admin_mekanik = MekanikAdmin::first();
        $ppn_mekanik = $admin_mekanik->ppn;
        $harga_admin_mekanik = (($request->harga * $ppn_mekanik) / 100);
        $pendapatan_mekanik = ((int)$request->harga + (int)$request->ongkir) - (($request->harga * $ppn_mekanik) / 100);

        $data['pendapatan_mekanik'] = $pendapatan_mekanik;
        $data['pendapatan_aplikasi'] = $harga_admin_mekanik;
        $data['is_status'] = 0;
        $data['user_uid'] = $request->user_uid;
        $data['mekanik_uid'] = $request->mekanik_uid;
        $data['fitur_id'] = $request->fitur_id;
        $data['latitude_user'] = $request->latitude_user;
        $data['longitude_user'] = $request->longitude_user;
        $data['latitude_mekanik'] = $request->latitude_mekanik;
        $data['longitude_mekanik'] = $request->longitude_mekanik;
        $data['kode_pesanan'] = 'OJK-' . $kode;
        $data['alamat_user'] = $request->alamat_user;
        $data['alamat_mekanik'] = $request->alamat_mekanik;
        $data['ongkir'] = $request->ongkir;
        $data['jarak'] = $request->jarak;
        $data['harga'] = $request->harga;
        $data['harga_total'] = (int)$request->ongkir + (int) $request->harga;

        // //Tambahkan Pesanan
        $insert = Pesanan::create($data);
        $response = [
            'message' => 'berhasil insert',
            'status' => 1,
            'data' => $data,
            'kode_pesanan' => 'OJK-' . $kode
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    public function transaksi_user(Request $request)
    {
        //getdata
        $getdata = Pesanan::where('user_uid', $request->input('user_uid'))
            ->where('is_status', 0)
            ->orWhere('is_status', 1)
            ->orWhere('is_status', 2)
            ->with('user')
            ->with('mekanik')
            ->get();

        $response = [
            'message' => 'getdata',
            'data' => $getdata
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public function tracking_user(Request $request)
    {
        $tracking = Pesanan::where('kode_pesanan', $request->input('kode_pesanan'))
            ->with('user')
            ->with('mekanik')
            ->with('fitur')
            ->first();


        $response = [
            'message' => 'berhasil insert',
            'data' => $tracking
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    public function batalkan_pesanan_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mekanik_uid' => ['required'],
            'kode_pesanan' => ['required'],
            'alasan' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $matikan_driver = JobMekanik::where('mekanik_uid', $request->mekanik_uid)->update(
            [
                'is_aktif' => 1,
                'kode_pesanan' => null
            ]
        );

        $update_pesanan = Pesanan::where('kode_pesanan', $request->kode_pesanan)->update([
            'is_status' => 4,
            'alasan' => $request->alasan
        ]);

        //cek token mekanik
        $cek_token_mekanik = Mekanik::select('token_id')->where('uid', $request->mekanik_uid)->first();
        $device_mekanik = $cek_token_mekanik->token_id;

        //kirim notifikasi ke driver                
        $message = CloudMessage::withTarget("token", $device_mekanik)
            ->withNotification(Notification::create('Customer telah membatalkan pesanan', 'Silahkan cek di riwayat alasannya apa'))
            ->withData(['key' => 'value']);

        $send =  $this->messaging->send($message);


        $response = [
            'message' => 'pesanan dibatalkan',
            'status' => 1,
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public static function getkode($length = 10)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }
}
