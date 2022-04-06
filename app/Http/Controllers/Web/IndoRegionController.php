<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Http\Request;

class IndoRegionController extends Controller
{

 
  public function getkabupaten(request $request)
  {
    $kabupatens = Regency::where('province_id', $request->get('id_provinsi'))
    ->pluck('name', 'id');
    return response()->json($kabupatens);
  }

  public function getkabupaten_on(request $request)
  {
    $id_provinsi = $request->id_provinsi;
    $kabupatens = Regency::where('province_id',$id_provinsi)
                          ->where('is_status',1)->get()
                          ->pluck('name', 'id');
                          return response()->json($kabupatens);
  }


  public function getkecamatan(request $request)
  {
    $id_kabupaten = $request->id_kabupaten;
    $kecamatans = District::where('regency_id',$id_kabupaten)->get()
                                      ->pluck('name', 'id');

    return response()->json($kecamatans);
    // foreach($kecamatans as $kecamatan){
    //     echo "<option value ='$kecamatan->id'>$kecamatan->name</option>";
    // }
  }

  public function getkecamatan_on(request $request)
  {
    $id_kabupaten = $request->id_kabupaten;
    $kecamatans = District::where('regency_id',$id_kabupaten)
                    ->where('is_status',1)->get() ->pluck('name', 'id');
          return response()->json($kecamatans);

  }

 

  public function getdesa(request $request)
  {
    $id_kecamatan = $request->id_kecamatan;
    $desas = Village::where('district_id',$id_kecamatan)
                ->get()
                ->pluck('name', 'id');
                
                return response()->json($desas);

  }

  public function getdesa_on(request $request)
  {
    $id_kecamatan = $request->id_kecamatan;
    $desas = Village::where('district_id',$id_kecamatan)
                ->where('is_status',1)->get()
                ->pluck('name', 'id');
              
                return response()->json($desas);
  }
}