<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LokasiModel;
use App\Models\MultiDesa;
use App\Models\Province;
use App\Models\Provinsi;
use App\Models\Regency;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MultiDesaController extends Controller
{

    public function index()
    {
        $provinces = Province::pluck('name', 'id');
        $multidesa = MultiDesa::select([
            'provinces.name as provinsi',
            'regencies.name as kabupaten',
            'districts.name as kecamatan',
            'villages.name as desa',
            'multi_desas.*'
        ])
            ->join('provinces', 'provinces.id', '=', 'multi_desas.province_id')
            ->join('regencies', 'regencies.id', '=', 'multi_desas.kabupaten_id')
            ->join('districts', 'districts.id', '=', 'multi_desas.kecamatan_id')
            ->join('villages', 'villages.id', '=', 'multi_desas.desa_id')
            ->get();
        return view('multidesa.multidesa', [
            'multidesa' => $multidesa,
            'provinces' => $provinces
        ]);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'province_id' => 'required|max:255',
            'kabupaten_id' => 'required',
            'kecamatan_id' => 'required',
            'desa_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $update_provinsi = DB::table('provinces')
            ->where('id', $request->province_id)
            ->update([
                'is_status' => 1
            ]);

        $post =  MultiDesa::insert($validatedData);
        $update_regencies = DB::table('regencies')
            ->where('id', $request->kabupaten_id)
            ->update([
                'is_status' => 1
            ]);

        $update_districts = DB::table('districts')
            ->where('id', $request->kecamatan_id)
            ->update([
                'is_status' => 1
            ]);

        $update_village = DB::table('villages')
            ->where('id', $request->desa_id)
            ->update([
                'is_status' => 1
            ]);




        return redirect('/multidesa')->with('success', 'Berhasil di input');
    }

    public function destroy(Request $request)
    {

        $post =  DB::table('multi_desas')->delete($request->id);

        $update_provinsi = DB::table('provinces')
            ->where('id', $request->province_id)
            ->update([
                'is_status' => 0
            ]);
        $update_regencies = DB::table('regencies')
            ->where('id', $request->kabupaten_id)
            ->update([
                'is_status' => 0
            ]);

        $update_districts = DB::table('districts')
            ->where('id', $request->kecamatan_id)
            ->update([
                'is_status' => 0
            ]);

        $update_village = DB::table('villages')
            ->where('id', $request->desa_id)
            ->update([
                'is_status' => 0
            ]);


        return redirect('/multidesa')->with('success', 'Berhasil di Hapus');
    }
}
