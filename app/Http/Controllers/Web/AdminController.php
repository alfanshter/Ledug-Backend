<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Request\CreateUser;

class AdminController extends Controller
{
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function index()
    {
        // Get semua data
        $provinces = Province::where('is_status', 1)->get();

        $data = User::where('role', 1)->get();


        return view('admin.index', [
            'dataadmin' => $data,
            'provinces' => $provinces
        ]);
    }

    public function edit($id)
    {
        $provinces = Province::where('is_status', 1)->get();
        $data = User::where('id', $id)
            ->with('provinsi')
            ->with('kabupaten')
            ->with('kecamatan')
            ->with('desa')
            ->first();
        return view('admin.editadmin', [
            'dataadmin' => $data,
            'provinces' => $provinces
        ]);
    }

    public function update(Request $request)
    {
        $rule = [
            'name' => 'required|max:255',
            'email' => ['required'],
            'province_id' => ['required'],
            'regencie_id' => ['required'],
            'district_id' => ['required'],
            'village_id' => ['required']
        ];
        //Apakah username sama ? 
        $getuser = User::where('id', $request->id)->first();
        if ($request->nim != $getuser->nim) {
            $rule['email'] = 'required|unique:users';
        }

        $validation = $request->validate($rule);

        if ($request->password != null) {
            $validation['password'] = Hash::make($request->password);
        }



        User::where('id', $request->id)
            ->update($validation);

        return redirect('/admin')->with('success', 'Update Admin Berhasil');
    }

    public function destroy($id)
    {

        User::destroy($id);
        return redirect('/admin')->with('success', 'Admin berhasil di hapus ');
    }


    public function insert(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required',
            'password' => 'required',
            'province_id' => 'required',
            'regencie_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required'

        ]);
        $validatedData['role'] = 1;
        $user = User::create($validatedData);

        return redirect('/admin')->with('success', 'Admin berhasil di input     ');
    }

    public function profil_admin()
    {
        $data = User::where('id', auth()->user()->id)->first();
        return view('admin.profiladmin', [
            'profil' => $data
        ]);
    }

    public function edit_profil_admin(Request $request)
    {
        $rule = [
            'name' => 'required|max:255',
            'email' => ['required']
        ];
        //Apakah username sama ? 
        $getuser = User::where('id', $request->id)->first();
        if ($request->email != $getuser->email) {
            $rule['email'] = 'required|unique:users';
        }

        $validation = $request->validate($rule);

        if ($request->password != null) {
            $validation['password'] = Hash::make($request->password);
        }



        User::where('id', $request->id)
            ->update($validation);

        return redirect('/profil_admin')->with('success', 'Update Admin Berhasil');
    }
}
