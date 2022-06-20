<?php

namespace App\Http\Controllers;

use App\Models\Pelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PelatihanController extends Controller
{
    public function pelatihan()
    {
        $pelatihan = Pelatihan::where('village_id', auth()->user()->village_id)->get();
        return view('pelatihan.pelatihan', ['pelatihan' => $pelatihan]);
    }

    public function tambah_pelatihan(Request $request)
    {

        $post = $request->except('_token', 'link');

        $cekvideo = 0;
        if ($request->video) {
            $cekvideo = 1;
        }

        if ($request->link) {
            $cekvideo = 0;
        }


        if ($request->file('foto')) {
            $post['foto'] = $request->file('foto')->store('foto-pelatihan', 'public');
        }


        if ($cekvideo == 1) {
            $post['video'] = $request->file('video')->store('video-pelatihan', 'public');
        } else {
            $post['video'] = $request->link;
        }


        $post =  Pelatihan::insert($post);

        notify()->success('Tambah Pelatihan Berhasil', 'Pelatihan');

        return redirect('/pelatihan');
    }

    public function hapus_pelatihan(Request $request)
    {
        $delete = Pelatihan::where('id', $request->id)->delete();
        Storage::disk('public')->delete($request->foto);
        Storage::disk('public')->delete($request->video);
        notify()->success('Hapus Pelatihan Berhasil', 'Pelatihan');
        return redirect('/pelatihan');
    }

    public function update_pelatihan_admin(Request $request)
    {
        $update = $request->except('_token', 'link_edit', 'video_edit', 'id', 'oldImage', 'oldVideo', 'link');
        $cekvideo = 0;
        if ($request->video_edit) {
            $cekvideo = 1;
        }

        if ($request->link_edit) {
            $cekvideo = 2;
        }

        if ($cekvideo == 1) {
            $update['video'] = $request->file('video_edit')->store('video-pelatihan', 'public');
            Storage::disk('public')->delete($request->oldVideo);
        } else if ($cekvideo == 2) {
            $update['video'] = $request->link_edit;
            Storage::disk('public')->delete($request->oldVideo);
        }

        if ($request->file('foto')) {
            $validatedData = $request->validate([
                'foto' => 'image|file|max:1024'
            ]);
            $update['foto'] = $request->file('foto')->store('foto-pelatihan', 'public');
            Storage::disk('public')->delete($request->oldImage);
        }

        Pelatihan::where('id', $request->id)->update($update);
        notify()->success('Edit Pelatihan Berhasil', 'Pelatihan');
        return redirect('/pelatihan');
    }
}
