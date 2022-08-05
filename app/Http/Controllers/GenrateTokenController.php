<?php

namespace App\Http\Controllers;

use App\Models\GenrateToken;
use Illuminate\Http\Request;
use token\Generate;



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
        $request->channel_name;

    
        // Import Composer to manage dependencies 
        require base_path("vendor/autoload.php");
        $netlessToken = new Generate;
        $sdkToken = $netlessToken->sdkToken(
           "rowJmkP9D54bBYQH", // Fill in the AK you get from Agora Console 
           "ssMLCp9RXsLRZ6o5hMbD0qqGeHbZDUu3", // Fill in the SK you get from Agora Console  
           1000 * 60 * 10, // Token validity period in milliseconds. If you set it to 0, the token will never expire 
              array(
               "role" => Generate::AdminRole, // Define the permissions granted by the token. You can set it to AdminRole, WriterRole, or ReaderRole 
              )
        );
        echo $sdkToken;        
        
        
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
