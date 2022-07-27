<?php

namespace App\Http\Controllers;

use App\Models\BudayaLokal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BudayaLokalController extends Controller
{
    public function budaya_lokal()
    {
        $budaya_lokal = BudayaLokal::where('village_id', auth()->user()->village_id)->get();
        return view('budayalokal.budaya_lokal', [
            'budaya_lokal' => $budaya_lokal
        ]);
    }

    public function tambah_budaya_lokal(Request $request)
    {

        $validatedData = $request->validate([
            'foto' => 'image|file|max:1024'
        ]);


        $cekvideo = 0;
        if ($request->video) {
            $cekvideo = 1;
        }

        if ($request->link) {
            $cekvideo = 0;
        }

        $postdata = $request->except('_token', 'link');


        if ($request->file('foto')) {
            $postdata['foto'] = $request->file('foto')->store('foto', 'public');
        }


        if ($cekvideo == 1) {
            $postdata['video'] = $request->file('video')->store('video-berita', 'public');
        } else {
            $postdata['video'] = $request->link;
        }


        $post =  BudayaLokal::insert($postdata);
        notify()->success('Tambah Budaya Berhasil', 'Budaya');

        return redirect('/budaya_lokal');
    }

    public function update_budaya_lokal_admin(Request $request)
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
            $update['video'] = $request->file('video_edit')->store('video', 'public');
            Storage::disk('public')->delete($request->oldVideo);
        } else if ($cekvideo == 2) {
            $update['video'] = $request->link_edit;
            Storage::disk('public')->delete($request->oldVideo);
        }

        if ($request->file('foto')) {
            $validatedData = $request->validate([
                'foto' => 'image|file|max:1024'
            ]);
            $update['foto'] = $request->file('foto')->store('foto', 'public');
            Storage::disk('public')->delete($request->oldImage);
        }

        BudayaLokal::where('id', $request->id)->update($update);
        notify()->success('Edit Budaya Berhasil', 'Budaya');
        return redirect('/budaya_lokal');
    }
    public function delete_budaya_lokal(Request $request)
    {
        $delete = BudayaLokal::where('id', $request->id)->delete();
        Storage::disk('public')->delete($request->foto);
        Storage::disk('public')->delete($request->video);
        notify()->success('Hapus Budaya Berhasil', 'Budaya');
        return redirect('/budaya_lokal');
    }
}
