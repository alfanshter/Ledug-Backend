<?php

namespace App\Http\Controllers;

use App\Models\Lada;
use App\Http\Requests\StoreLadaRequest;
use App\Http\Requests\UpdateLadaRequest;

class LadaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLadaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLadaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lada  $lada
     * @return \Illuminate\Http\Response
     */
    public function show(Lada $lada)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lada  $lada
     * @return \Illuminate\Http\Response
     */
    public function edit(Lada $lada)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLadaRequest  $request
     * @param  \App\Models\Lada  $lada
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLadaRequest $request, Lada $lada)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lada  $lada
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lada $lada)
    {
        //
    }
}
