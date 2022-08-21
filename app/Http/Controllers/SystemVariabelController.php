<?php

namespace App\Http\Controllers;

use App\Models\systemVariabel;
use Illuminate\Http\Request;

class SystemVariabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $system_data = systemVariabel::select('current_version'  ,'base_url' ,'notification_email' ,'notification_email_password')->get()->all();
        $response = ['status'=>200 , 'msg'=>'success' , 'data'=>$system_data[0]];
        return $response;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\systemVariabel  $systemVariabel
     * @return \Illuminate\Http\Response
     */
    public function show(systemVariabel $systemVariabel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\systemVariabel  $systemVariabel
     * @return \Illuminate\Http\Response
     */
    public function edit(systemVariabel $systemVariabel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\systemVariabel  $systemVariabel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, systemVariabel $systemVariabel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\systemVariabel  $systemVariabel
     * @return \Illuminate\Http\Response
     */
    public function destroy(systemVariabel $systemVariabel)
    {
        //
    }
}
