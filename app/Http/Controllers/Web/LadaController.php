<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Lada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LadaController extends Controller
{
    public function index()
    {
        $lada = Lada::all();
        return view('lada.lada',[
            'lada'=> $lada
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
            'foto' => 'image|file|max:1024',
            'narasi' => 'required',
            'link' => 'required'

        ]);

        if ($request->file('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('foto-lada');
        }

        $post =  Lada::insert($validatedData);

        return redirect('/lada')->with('success', 'lada berhasil di input');

        
    }

    public function delete(Request $request)
    {
        $delete = Lada::where('id',$request->id)->delete();
        Storage::delete($request->foto);
        return redirect('/lada')->with('success','Berhasil di hapus');
    }
    
    public function edit($id)
    {
        $data = Lada::where('id',$id)->first();
        return view('lada.editlada',['lada' => $data]);

    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
            'foto' => 'image|file|max:1024',
            'narasi' => 'required',
            'link' => 'required'

        ]);


        if ($request->file('foto')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['foto'] = $request->file('foto')->store('foto-lada');
        }

        Lada::where('id',$request->id)
            ->update($validatedData);
        
            return redirect('/lada')->with('success', 'Berita berhasil di update');


    }
}