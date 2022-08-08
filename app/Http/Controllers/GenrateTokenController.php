<?php

namespace App\Http\Controllers;

use App\Models\GenrateToken;
use Illuminate\Http\Request;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;




class GenrateTokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generateNew(Request $request)
    {
        $request->user_id;
        $cahnnel_name = $request->channel_name;
        $response = Http::get('https://fque355k2a.execute-api.us-east-2.amazonaws.com/access-token?channelName={$cahnnel_name}'); 
        // dd(json_encode($response->json()));        
        $return = ["staus"=>200, "token"=> $response->json()];
        return $return;
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
     * @param  \App\Models\GenrateToken  $genrateToken
     * @return \Illuminate\Http\Response
     */
    public function show(GenrateToken $genrateToken)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GenrateToken  $genrateToken
     * @return \Illuminate\Http\Response
     */
    public function edit(GenrateToken $genrateToken)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GenrateToken  $genrateToken
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GenrateToken $genrateToken)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GenrateToken  $genrateToken
     * @return \Illuminate\Http\Response
     */
    public function destroy(GenrateToken $genrateToken)
    {
        //
    }
}
