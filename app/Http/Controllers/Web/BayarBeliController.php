<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BayarBeli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BayarBeliController extends Controller
{
    public function index()
    {
        $bayarbeli = BayarBeli::all();
        return view('bayarbeli.bayarbeli',[
            'bayarbeli'=> $bayarbeli
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
            $validatedData['foto'] = $request->file('foto')->store('foto-bayarbeli');
        }

        $post =  BayarBeli::insert($validatedData);

        return redirect('/bayarbeli')->with('success', 'bayarbeli berhasil di input');

        
    }

    public function delete(Request $request)
    {
        $delete = BayarBeli::where('id',$request->id)->delete();
        Storage::delete($request->foto);
        return redirect('/bayarbeli')->with('success','Berhasil di hapus');
    }
    
    public function edit($id)
    {
        $data = BayarBeli::where('id',$id)->first();
        return view('bayarbeli.editbayarbeli',['bayarbeli' => $data]);

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
            $validatedData['foto'] = $request->file('foto')->store('foto-bayarbeli');
        }

        BayarBeli::where('id',$request->id)
            ->update($validatedData);
        
            return redirect('/bayarbeli')->with('success', 'Berita berhasil di update');


    }
}