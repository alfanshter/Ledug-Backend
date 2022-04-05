<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
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
        $multidesa = MultiDesa::all();
        return view('multidesa.multidesa',[
            'multidesa'=>$multidesa,
            'provinces' => $provinces
        ]);
    }

  
    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'provinsi_id' => 'required|max:255',
    //         'kabupaten_id' => 'required',
    //         'kecamatan_id' => 'required',
    //         'desa_id' => 'required'
    //     ]);

    //     $post =  DB::table('multi_desas')->insert($validatedData);
    //     $update_provinsi = DB::table('provinces')
    //                     ->where('id',$request->provinsi_id)
    //                     ->update([
    //                         'is_status'=>1
    //                     ]);
    //     $update_regencies = DB::table('regencies')
    //                     ->where('id',$request->kabupaten_id)
    //                     ->update([
    //                         'is_status'=>1
    //                     ]);

    //     $update_districts = DB::table('districts')
    //                     ->where('id',$request->kecamatan_id)
    //                     ->update([
    //                         'is_status'=>1
    //                     ]);

    //     $update_village = DB::table('villages')
    //                     ->where('id',$request->desa_id)
    //                     ->update([
    //                         'is_status'=>1
    //                     ]);

        
    //     return redirect('/multidesa')->with('success','Berhasil di input');

    // }
}