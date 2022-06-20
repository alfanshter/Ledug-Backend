<?php

namespace App\Http\Controllers;

use App\Models\KegiatanDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KegiatanDesaController extends Controller
{
    public function index()
    {
        $kegiatandesa = KegiatanDesa::all();
        return view('kegiatandesa.kegiatandesa', ['kegiatandesa' => $kegiatandesa]);
    }

    public function tambah_kegiatandesa(Request $request)
    {

        $validatedData = $request->validate([
            'kegiatan_desa' => 'required|max:255',
            'nama_kegiatan' => 'required',
            'tanggal' => 'required',
            'jam' => 'required',
            'alamat' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'village_id' => 'required'

        ]);

        KegiatanDesa::insert($validatedData);
        notify()->success('Tambah Kegiatan Berhasil', 'Kegiatan Desa');
        return redirect('/kegiatandesa');
    }

    public function update_kegiatandesa(Request $request)
    {
        $validatedData = $request->validate([
            'kegiatan_desa' => 'required|max:255',
            'nama_kegiatan' => 'required',
            'tanggal' => 'required',
            'jam' => 'required',
            'alamat' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'id' => 'required'

        ]);

        KegiatanDesa::where('id', $request->id)->update($validatedData);
        notify()->success('Update Kegiatan Berhasil', 'Kegiatan Desa');
        return redirect('/kegiatandesa');
    }

    public function cek_lokasi(Request $request)
    {
        return view('ceklokasi.ceklokasi', ['latitude' => $request->latitude, 'longitude' => $request->longitude]);
    }

    public function delete_kegiatandesa(Request $request)
    {

        $delete = KegiatanDesa::where('id', $request->id)->delete();
        notify()->success('Hapus Kegiatan Berhasil', 'Kegiatan Desa');
        return redirect('/kegiatandesa');
    }
}
