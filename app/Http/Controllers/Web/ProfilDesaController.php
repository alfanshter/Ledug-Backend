<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ProfilDesa;
use Illuminate\Http\Request;

class ProfilDesaController extends Controller
{
    public function profil()
    {
        $profil = ProfilDesa::where('village_id', auth()->user()->village_id)->first();

        return view('profildesa.profil', [
            'profil' => $profil
        ]);
    }

    public function update_profildesa(Request $request)
    {
        $validatedData = $request->validate([
            'kepala_desa' => 'required|max:255',
            'sekretaris_desa' => 'required',
            'alamat' => 'required',
            'province_id' => 'required',
            'regencie_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required'


        ]);
        //cek profil
        $profil = ProfilDesa::where('village_id', auth()->user()->village_id)->first();
        if ($profil == null) {
            ProfilDesa::create($validatedData);
            return redirect('/profildesa')->with('success', 'Profil desa berhasil di update');
        } else {
            ProfilDesa::where('village_id', auth()->user()->village_id)
                ->update($validatedData);
            return redirect('/profildesa')->with('success', 'Profil desa berhasil di update');
        }
    }
}
