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
        $provinces = Province::where('is_status', 1)->get();
        $data = DB::table('beritas')
            ->select(['beritas.*', 'provinces.name as provinsi', 'regencies.name as kabupaten', 'districts.name as kecamatan', 'villages.name as desa'])
            ->join('provinces', 'provinces.id', '=', 'beritas.province_id')
            ->join('regencies', 'regencies.id', '=', 'beritas.regencie_id')
            ->join('districts', 'districts.id', '=', 'beritas.district_id')
            ->join('villages', 'villages.id', '=', 'beritas.village_id')
            ->get();
        return view('berita.berita', [
            'berita' => $data,
            'provinces' => $provinces,
        ]);
    }

    public function index_admin()
    {
        // Get semua data
        $provinces = Province::where('is_status', 1)->get();
        $data = DB::table('beritas')
            ->select(['beritas.*', 'provinces.name as provinsi', 'regencies.name as kabupaten', 'districts.name as kecamatan', 'villages.name as desa'])
            ->join('provinces', 'provinces.id', '=', 'beritas.province_id')
            ->join('regencies', 'regencies.id', '=', 'beritas.regencie_id')
            ->join('districts', 'districts.id', '=', 'beritas.district_id')
            ->join('villages', 'villages.id', '=', 'beritas.village_id')
            ->get();
        return view('berita.berita_admin', [
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
            'tanggal_terbit' => 'required',
            'province_id' => 'required',
            'regencie_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required'

        ]);

        $cekvideo = 0;
        if ($request->video) {
            $cekvideo = 1;
        }

        if ($request->link) {
            $cekvideo = 0;
        }


        if ($request->file('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('foto-berita', 'public');
        }


        if ($cekvideo == 1) {
            $validatedData['video'] = $request->file('video')->store('video-berita', 'public');
        } else {
            $validatedData['video'] = $request->link;
        }


        $post =  DB::table('beritas')->insert($validatedData);

        if (auth()->user()->role == 1) {
            return redirect('/beritadesa_admin')->with('success', 'Berita berhasil di input');
        }
        return redirect('/beritadesa')->with('success', 'Berita berhasil di input');
    }

    public function delete(Request $request)
    {

        $delete = Berita::where('id', $request->id)->delete();
        Storage::disk('public')->delete($request->foto);
        Storage::disk('public')->delete($request->video);
        notify()->success('Edit Berita Berhasil', 'Budaya');
        return redirect('/beritadesa')->with('success', 'Berhasil di hapus');
    }

    public function edit($id)
    {
        $data = Berita::where('id', $id)->first();
        return view('berita.editberita', ['berita' => $data]);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
            'foto' => 'image|file|max:1024',
            'narasi' => 'required'

        ]);

        $update = $request->except('_token', 'link_edit', 'video_edit', 'id', 'oldImage', 'oldVideo', 'link');
        $cekvideo = 0;
        if ($request->video_edit) {
            $cekvideo = 1;
        }

        if ($request->link_edit) {
            $cekvideo = 2;
        }

        if ($cekvideo == 1) {
            $update['video'] = $request->file('video_edit')->store('video-berita', 'public');
            Storage::disk('public')->delete($request->oldVideo);
        } else if ($cekvideo == 2) {
            $update['video'] = $request->link_edit;
            Storage::disk('public')->delete($request->oldVideo);
        }


        if ($request->file('foto')) {
            $validatedData = $request->validate([
                'foto' => 'image|file|max:1024'
            ]);
            $update['foto'] = $request->file('foto')->store('foto-berita', 'public');
            Storage::disk('public')->delete($request->oldImage);
        }

        Berita::where('id', $request->id)->update($update);
        notify()->success('Edit Budaya Berhasil', 'Budaya');
        return redirect('/beritadesa');
    }
}
