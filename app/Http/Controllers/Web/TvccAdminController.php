<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Tvcc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TvccAdminController extends Controller
{
    public function index()
    {
        $tvcc = Tvcc::all();
        return view('tvcc.tvcc',[
            'tvcc'=> $tvcc
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
            $validatedData['foto'] = $request->file('foto')->store('foto-tvcc');
        }

        $post =  DB::table('tvccs')->insert($validatedData);

        return redirect('/tvcc')->with('success', 'TVCC berhasil di input');

        
    }

    public function delete(Request $request)
    {
        $delete = Tvcc::where('id',$request->id)->delete();
        Storage::delete($request->foto);
        return redirect('/tvcc')->with('success','Berhasil di hapus');
    }
    
    public function edit($id)
    {
        $data = Tvcc::where('id',$id)->first();
        return view('tvcc.edittvcc',['tvcc' => $data]);

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
            $validatedData['foto'] = $request->file('foto')->store('foto-tvcc');
        }

        Tvcc::where('id',$request->id)
            ->update($validatedData);
        
            return redirect('/tvcc')->with('success', 'Berita berhasil di update');


    }
}
