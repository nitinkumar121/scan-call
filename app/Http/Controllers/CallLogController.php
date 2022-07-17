<?php

namespace App\Http\Controllers;

use App\Models\call_log;
use App\Http\Requests\Storecall_logRequest;
use App\Http\Requests\Updatecall_logRequest;

class CallLogController extends Controller
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
     * @param  \App\Http\Requests\Storecall_logRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storecall_logRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\call_log  $call_log
     * @return \Illuminate\Http\Response
     */
    public function show(call_log $call_log)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\call_log  $call_log
     * @return \Illuminate\Http\Response
     */
    public function edit(call_log $call_log)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updatecall_logRequest  $request
     * @param  \App\Models\call_log  $call_log
     * @return \Illuminate\Http\Response
     */
    public function update(Updatecall_logRequest $request, call_log $call_log)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\call_log  $call_log
     * @return \Illuminate\Http\Response
     */
    public function destroy(call_log $call_log)
    {
        //
    }
}
