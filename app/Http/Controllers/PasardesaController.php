<?php

namespace App\Http\Controllers;

use App\Models\Pasardesa;
use App\Http\Requests\StorePasardesaRequest;
use App\Http\Requests\UpdatePasardesaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PasardesaController extends Controller
{
    public function index()
    {
        $pasardesa = Pasardesa::all();
        return view('pasardesa.pasardesa',[
            'pasardesa'=> $pasardesa
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
            $validatedData['foto'] = $request->file('foto')->store('foto-pasardesa');
        }

        $post =  Pasardesa::insert($validatedData);

        return redirect('/pasardesa')->with('success', 'pasardesa berhasil di input');

        
    }

    public function delete(Request $request)
    {
        $delete = Pasardesa::where('id',$request->id)->delete();
        Storage::delete($request->foto);
        return redirect('/pasardesa')->with('success','Berhasil di hapus');
    }
    
    public function edit($id)
    {
        $data = Pasardesa::where('id',$id)->first();
        return view('pasardesa.editpasardesa',['pasardesa' => $data]);

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
            $validatedData['foto'] = $request->file('foto')->store('foto-pasardesa');
        }

        Pasardesa::where('id',$request->id)
            ->update($validatedData);
        
            return redirect('/pasardesa')->with('success', 'Berita berhasil di update');


    }
}