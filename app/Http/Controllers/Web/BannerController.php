<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index_admin()
    {
        $banner = Banner::where('village_id', auth()->user()->village_id)->get();
        return view('banner.banner_admin', [
            'banner' => $banner
        ]);
    }

    public function tambahbanner_admin(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
            'deskripsi' => 'required|max:255',
            'link' => 'required|max:255',
            'foto' => 'image|file|max:1024',
            'province_id' => 'required',
            'regencie_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required'

        ]);

        if ($request->file('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('foto-banner', 'public');
        }

        $post =  Banner::insert($validatedData);

        return redirect('/banner_admin')->with('success', 'Banner berhasil di input');
    }

    public function update_banner_admin(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
            'deskripsi' => 'required|max:255',
            'link' => 'required|max:255',
            'foto' => 'image|file|max:1024'
        ]);


        if ($request->file('foto')) {
            if ($request->oldImage) {
                Storage::disk('public')->delete($request->oldImage);
            }
            $validatedData['foto'] = $request->file('foto')->store('foto-banner', 'public');
        }

        Banner::where('id', $request->id)
            ->update($validatedData);

        return redirect('/banner_admin')->with('success', 'Berita berhasil di update');
    }

    public function hapusbanner_admin(Request $request)
    {
        $delete = Banner::where('id', $request->id)->delete();
        Storage::disk('public')->delete($request->foto);
        return redirect('/banner_admin')->with('success', 'Berhasil di hapus');
    }
}
