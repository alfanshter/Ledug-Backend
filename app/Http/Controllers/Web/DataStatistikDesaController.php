<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\DataStatistikDesa;
use Illuminate\Http\Request;

class DataStatistikDesaController extends Controller
{
    public function index_admin()
    {
        $datastatistik = DataStatistikDesa::where('village_id', auth()->user()->village_id)->get();
        return view('profildesa.datastatistikdesa', [
            'datastatistik' => $datastatistik
        ]);
    }

    public function tambah_data(Request $request)
    {
        $validatedData = $request->validate([
            'jenis' => 'required|max:255',
            'jumlah' => 'required|max:255',
            'province_id' => 'required',
            'regencie_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required'

        ]);

        $post =  DataStatistikDesa::insert($validatedData);

        return redirect('/datastatistik_desa')->with('success', 'Data berhasil di input');
    }
}
