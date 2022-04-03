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
    $id_provinsi = $request->id_provinsi;
    $kabupatens = Regency::where('province_id',$id_provinsi)->get();

    foreach($kabupatens as $kabupaten){
        echo "<option value ='$kabupaten->id'>$kabupaten->name</option>";
    }
  }

  public function getkecamatan(request $request)
  {
    $id_kabupaten = $request->id_kabupaten;
    $kecamatans = District::where('regency_id',$id_kabupaten)->get();

    foreach($kecamatans as $kecamatan){
        echo "<option value ='$kecamatan->id'>$kecamatan->name</option>";
    }
  }

  public function getdesa(request $request)
  {
    $id_kecamatan = $request->id_kecamatan;
    $desas = Village::where('district_id',$id_kecamatan)->get();

    foreach($desas as $desa){
        echo "<option value ='$desa->id'>$desa->name</option>";
    }
  }
}