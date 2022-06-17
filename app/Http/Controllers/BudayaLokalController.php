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
            'foto' => 'image|file|max:1024',
            'video' => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm'
        ]);

        $postdata = $request->except('_token');


        if ($request->file('foto')) {
            $postdata['foto'] = $request->file('foto')->store('foto-budayalokal', 'public');
        }


        if ($request->file('video')) {
            $postdata['video'] = $request->file('video')->store('video-budayalokal', 'public');
        }

        $post =  BudayaLokal::insert($postdata);
        notify()->success('Tambah Budaya Berhasil', 'Budaya');

        return redirect('/budaya_lokal');
    }

    public function delete_budaya_lokal(Request $request)
    {
        $delete = BudayaLokal::where('id', $request->id)->delete();
        Storage::delete($request->foto);
        notify()->success('Hapus Budaya Berhasil', 'Budaya');
        return redirect('/budaya_lokal');
    }
}
