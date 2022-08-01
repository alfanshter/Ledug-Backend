<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FCMController extends Controller
{
    public function index(Request $request)
    {
        $input = $request->all();
        return response()->json($input);
    }
}
