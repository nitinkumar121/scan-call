<?php

namespace App\Http\Controllers;

use App\Models\GenrateToken;
use App\Models\User_data;
use Illuminate\Http\Request;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

use function PHPUnit\Framework\returnSelf;

class GenrateTokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generateNew(Request $request)
    {
        $channel_name = $request->channel_name;
     $response = Http::get("https://fque355k2a.execute-api.us-east-2.amazonaws.com/access-token?channelName={$channel_name}"); 
        // dd(json_encode($response->json()));        
        $return = ["staus"=>200, "data"=> json_decode($response)];
        // recevier data
        $recevier_data = User_data::select('id , first_name , last_name , picture')->where('id', $request->revicer_id)->get();
        // sender data 
        $sender_data =  User_data::select('id , first_name , last_name , picture')->where('id', $request->sender_id)->get();

        if(!isset($sender_data[0])) return   $return = ["staus"=>404, "msg"=>'sender not found'];
        if(!isset($recevier_data[0])) return   $return = ["staus"=>404, "msg"=>'receiver not found'];
        $to = $recevier_data[0]->device_id;
        $title= "Scan-Call";
          $message =$sender_data[0]->first_name." calling you";
        $datapayload = ['type'=>"isFormNotification", 'token'=>$response['token'], 'receiver_data'=>$recevier_data[0], 'sender_data'=>$sender_data[0],'channel'=> $request->channel_name];

        $msg = urlencode($message);
        $data = array(
            'title'=>$title,
            'sound' => "default",
            'msg'=>$msg,
            'data'=>$datapayload,
            'body'=>$message,
            'color' => "#79bc64"
        );
      
        $fields = array(
            'to'=>$to,
            'notification'=>$data,
            'data'=>$datapayload,
            "priority" => "high",
        );
        $headers = array(
            'Authorization: key= AAAAk5GjamM:APA91bEwa07eD8fB_nudHx16ebACpMrvIZAwzM08-AQtgDuUIhbIHcbreKo04KOUu9j1cujlRnknaoHHcx_xPG6qfcFcA9dnShA9LUk7J8NusbB2H6eT4RL_JAztI0hG_93ohEZyI59G',
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close( $ch );
        // return $result;
        return $return;
}     

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addDeviceToken(Request $request)
    {
        $find_user = User_data::where('id', $request->user_id);
        $new_user = [
            "device_id" => $request->device_token,
            'isLoggedIn'=>'1'
        ];
        
        $find_user->update($new_user);
        $response =['status' => 200 , 'message'=>'success'];
        return $response;
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
