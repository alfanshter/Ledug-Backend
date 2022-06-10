<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\FasilitasDesa;
use Illuminate\Http\Request;

class FasilitasDesaController extends Controller
{
    public function index_admin()
    {
        $fasilitasdesa = FasilitasDesa::where('village_id', auth()->user()->village_id)->get();
        return view('fasilitasdesa.fasilitasdesa', [
            'fasilitasdesa' => $fasilitasdesa
        ]);
    }

    public function tambah_fasilitas_admin(Request $request)
    {
        $validatedData = $request->validate([
            'fasilitas' => 'required|max:255',
            'deskripsi' => 'required|max:255',
            'foto' => 'image|file|max:1024',
            'village_id' => 'required'

        ]);

        if ($request->file('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('foto-fasilitas', 'public');
        }

        $post =  FasilitasDesa::insert($validatedData);

        return redirect('/fasilitasdesa')->with('success', 'Fasilitas berhasil di input');
    }
}
