<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Storage;

use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;

class BeritaAdminController extends Controller
{
    public function index()
    {
        // Get semua data
        $provinces = Province::where('is_status',1)->get();
        $data = DB::table('beritas')
                    ->select(['beritas.*','provinces.name as provinsi','regencies.name as kabupaten','districts.name as kecamatan','villages.name as desa'])
                    ->join('provinces','provinces.id','=','beritas.province_id')
                    ->join('regencies','regencies.id','=','beritas.regencie_id')
                    ->join('districts','districts.id','=','beritas.district_id')
                    ->join('villages','villages.id','=','beritas.village_id')
                    ->get();
        return view('berita.berita',[
            'berita' => $data,
            'provinces' => $provinces,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
            'foto' => 'image|file|max:1024',
            'narasi' => 'required',
            'province_id' => 'required',
            'regencie_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required'

        ]);

        if ($request->file('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('foto-berita');
        }

        $post =  DB::table('beritas')->insert($validatedData);

        return redirect('/beritadesa')->with('success', 'Berita berhasil di input');

        
    }

    public function delete(Request $request)
    {
        $delete = Berita::where('id',$request->id)->delete();
        Storage::delete($request->foto);
        return redirect('/beritadesa')->with('success','Berhasil di hapus');
    }
    
    public function edit($id)
    {
        $data = Berita::where('id',$id)->first();
        return view('berita.editberita',['berita' => $data]);

    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
            'foto' => 'image|file|max:1024',
            'narasi' => 'required'

        ]);


        if ($request->file('foto')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['foto'] = $request->file('foto')->store('foto-berita');
        }

        Berita::where('id',$request->id)
            ->update($validatedData);
        
            return redirect('/beritadesa')->with('success', 'Berita berhasil di update');


    }
    
}