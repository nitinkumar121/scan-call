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
        $response = Http::get("https://fque355k2a.execute-api.us-east-2.amazonaws.com/access-token?channelName={$cahnnel_name}"); 
        // dd(json_encode($response->json()));        
        $return = ["staus"=>200, "data"=> json_decode($response)];



  // FCM API Url
  $url = 'https://fcm.googleapis.com/fcm/send';
  // Put your Server Key here
  $apiKey = "MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCUcK/LGe3V0OQI\nkc42Gs1Pf2PVP3hvnhIzDNQnDqo1aYtLBbLhSt8OGK+//mRo3cfB1im5PRzFJ1OA\nb/YfFLekSsB8R95J+nyNhATxJA98e3FqW86b+c4fqo0cSE81rrZT+YDldu2GhzXO\nt7+wRJn0PCKkq0BLPI6aCrDT9Py+MuAzIH8SxRO52VMkSHjbsvwFPBdP48H7TYUq\nw/DWfcGM7HWWdWw7PGsc1LkE9VfKDBM7r5lr4vtpXyLcGk2Fk5iDZhPIBrNebygF\n3iRzhaRxamPYLTRN0KyolgKdWHGJqsPqywsvUt7CbaRsUtlMcTUdE8F0ticI+rI1\nsRU042JXAgMBAAECggEAENAF69mXJAwMVTd6eotPl2z6IuQ/oQNvfpkPNbtF+6sQ\nIU0BxTMEj5ABO/GKxYvfvQHOPlJV014QaZraGWFwfqsOy89yCxapYSKY/Vz/D14w\nlYIqJRAb+18xq13knCkah+lZuDkKTx3lB3Gtbuqzi0OnuCyYqXeFk/HuXvC/vaT7\nsVJwlt0p3NDnN+Gh59o7jnSMc100ZFnhMtPylq1E2UQmp7gu/zq0a7fqA5wNarZk\nqwZNKl6b3Rj+eQec7KS+jQwyCzv6aRh9lgjlXlYjELzT9fEaPqVr68QqgTCzEO8m\nPLHwP9iu/1aijH/7Ionm8fX6dvqI8J9kWn6LlFiLeQKBgQDFWqq34los5bAXWZcc\nXKqxjVP5yTyxwg7V79FzQ/2Iu6QAc8tsc5/nJZQPcMx0ctEvbp9ugNvyvVuaKszu\n64HGkr7XZFYJfZRA3BoJDRbECk7NC819EjneOlh+GCHomOvv5mzNXfik7wEZ3yzj\nTuStHp/zLpuSMdMX8/6JLz9lmQKBgQDAjPvfBX/0Y5mIGTpAkqPQDr+ljl3pLlq+\nojGs/T2ujxa3gbIwOKyGOjqD9/RoWj4oqk5NlBuZGHYGysNWguHJ4IKSYeJrVlS7\nYSkRmmyBiqbJumLZBcmcYzZrxjjRzbcaSU3PTVWBop/YpSsT5wnTzEZS/F+1w/ZK\ngbMSv4QdbwKBgATpV7xRzsq1QKekHCWhjMH0cXWS84a8/J+IY18J/yJLAS7dst9V\nFVKsVb34oa34OYqDp0YZwN+OpNv2WrlLdSRa/JLhtV5xGKJwl9lH0Rw54XIq7AdD\nz9re+trQgO+H9r82rdiCkTCRniZlrnlNulUwoOxtaYO+57D96oTBf0NpAoGANbjg\nKThSm/ASDQvk2dFQDSOgSuOuxfld7iQ4segyBnr7vpVcDuIxGH40h09uDJNpFlV1\n5WU2Uf+mJnz6BTAdKQMPyyGuV35Nw733BGdOcNIreMsc+yoHNy/jJiy2+6pmtNnQ\n8M7F1ZZ2/K4Ql8v1TPeIg2zQk1kqZV1MhiWTCdcCgYAd67bZsWfvQH/wMPFusLXI\nrbW9DmKNaxFP+MbjCtrLGITZOye1lKJA6V7g0U/hbtxxZLUZOJkApWLrK3UyVRHR\nqqvKHLMSnmHbodYkNx29rSMpFq167przbhEhxzjRXgHsPGvF8Fpg+dvIdMCCA55z\n1DlmHmVQxt+bSc0CjskOTw==";
  // Compile headers in one variable
  $headers = array (
    'Authorization:key=' . $apiKey,
    'Content-Type:application/json'
  );
  // Add notification content to a variable for easy reference
  $notifData = [
    'title' => "fcm testing",
    'body' => "acknowledge nitin urgently",
    //  "image": "url-to-image",//Optional
    'click_action' => "activities.NotifHandlerActivity" //Action/Activity - Optional
  ];
  $dataPayload = ['to'=> 'My Name', 
  'points'=>80, 
  'other_data' => 'This is extra payload'
  ];
  // Create the api body
  $apiBody = [
    'notification' => $notifData,
    'data' => $dataPayload, //Optional
    'time_to_live' => 600, // optional - In Seconds
    //'to' => '/topics/mytargettopic'
    //'registration_ids' = ID ARRAY
    'to' => 'dRSk8QIaSJKQ_V4JEc1Q28:APA91bGkY4hL40Onm6WJewBCGZnuSWgc58SlxLs4d9RJkSxdyR_lnU3SfmywJoKS4KesLHFb7g5EPNqSzOdF4REQttcDWEv6WRt8UBb273DXOM1ovD2GhNnIXVBKVRDcDX4TwYxbM_Wy'];

  // Initialize curl with the prepared headers and body
  $ch = curl_init();
  curl_setopt ($ch, CURLOPT_URL, $url);
  curl_setopt ($ch, CURLOPT_POST, true);
  curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt ($ch, CURLOPT_POSTFIELDS, json_encode($apiBody));

  // Execute call and save result
  $result = curl_exec($ch);
  // Close curl after call
  curl_close($ch);

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
