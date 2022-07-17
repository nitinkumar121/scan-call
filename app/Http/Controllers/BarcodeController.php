<?php

namespace App\Http\Controllers;

use App\Models\barcode;
use App\Http\Requests\StorebarcodeRequest;
use App\Http\Requests\UpdatebarcodeRequest;

class BarcodeController extends Controller
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
     * @param  \App\Http\Requests\StorebarcodeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorebarcodeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\barcode  $barcode
     * @return \Illuminate\Http\Response
     */
    public function show(barcode $barcode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\barcode  $barcode
     * @return \Illuminate\Http\Response
     */
    public function edit(barcode $barcode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatebarcodeRequest  $request
     * @param  \App\Models\barcode  $barcode
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatebarcodeRequest $request, barcode $barcode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\barcode  $barcode
     * @return \Illuminate\Http\Response
     */
    public function destroy(barcode $barcode)
    {
        //
    }
}
