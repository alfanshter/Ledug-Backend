<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    public function index()
    {

        return view('admin.index',[
            'dataadmin' => User::where('role',1)->get()
        ]);
    }

    public function edit($id)
    {
        return view('admin.editadmin',[
            'dataadmin' => User::where('id',$id)->first()
        ]);
    }

    public function update(Request $request)
    {
        $rule = [
            'name' => 'required|max:255',
            'email' => ['required'],
        ];
        //Apakah username sama ? 
        $getuser = User::where('id',$request->id)->first();
        if ($request->nim !=$getuser->nim) {
            $rule['email'] = 'required|unique:users';
        }

        $validation = $request->validate($rule);

        if ($request->password !=null) {
            $validation['password'] = Hash::make($request->password);
        }
        


        User::where('id',$request->id)
            ->update($validation);

        return redirect('/admin')->with('success','Update Admin Berhasil');

    }

    public function destroy($id)
    {

        User::destroy($id);
            return redirect('/admin')->with('success', 'Admin berhasil di hapus ');
    }


    public function insert(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 1,
            'password' => Hash::make($request->password)
         ]);

         return redirect('/admin')->with('success', 'Admin berhasil di input     ');


    }
}
