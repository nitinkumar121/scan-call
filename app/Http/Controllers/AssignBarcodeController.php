<?php

namespace App\Http\Controllers;

use App\Models\assign_barcode;
use App\Http\Requests\Storeassign_barcodeRequest;
use App\Http\Requests\Updateassign_barcodeRequest;

class AssignBarcodeController extends Controller
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
     * @param  \App\Http\Requests\Storeassign_barcodeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storeassign_barcodeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\assign_barcode  $assign_barcode
     * @return \Illuminate\Http\Response
     */
    public function show(assign_barcode $assign_barcode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\assign_barcode  $assign_barcode
     * @return \Illuminate\Http\Response
     */
    public function edit(assign_barcode $assign_barcode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updateassign_barcodeRequest  $request
     * @param  \App\Models\assign_barcode  $assign_barcode
     * @return \Illuminate\Http\Response
     */
    public function update(Updateassign_barcodeRequest $request, assign_barcode $assign_barcode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\assign_barcode  $assign_barcode
     * @return \Illuminate\Http\Response
     */
    public function destroy(assign_barcode $assign_barcode)
    {
        //
    }
}
