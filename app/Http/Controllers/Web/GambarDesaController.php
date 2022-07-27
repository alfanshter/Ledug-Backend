<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\GambarDesa;
use Illuminate\Http\Request;

class GambarDesaController extends Controller
{
    public function index_admin()
    {
        $gambardesa = GambarDesa::where('village_id', auth()->user()->village_id)->get();
        return view('profildesa.gambardesa', [
            'gambardesa' => $gambardesa
        ]);
    }

    public function tambah_gambardesa(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'foto' => 'image|file|max:1024',
            'village_id' => 'required'

        ]);

        if ($request->file('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('foto', 'public');
        }

        $post =  GambarDesa::insert($validatedData);

        return redirect('/gambardesa')->with('success', 'Gambar Desa berhasil di input');
    }
}
