<?php

namespace App\Http\Controllers;

use App\Models\call_log;
use App\Models\User_data;
use App\Http\Requests\Updatecall_logRequest;
use Illuminate\Http\Request;

class CallLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_call_details(Request  $request)
    {

        $call_detals = call_log::where('reciever_id' , $request->user_id)->orwhere('sender_id' , $request->user_id)->get();
        if(!isset($call_detals[0])) return  ['message'=> 'no data found' , 'status'=>200 , 'data'=>null];
        else {
            $data['total_incoming']= call_log::where('reciever_id' , $request->user_id)->Where('call_status','>' , '0')->count();
            $data['total_outgoing']=call_log::where('sender_id' , $request->user_id)->count();;
            $data['total_missed']= call_log::where('reciever_id' , $request->user_id)->Where('call_status' , '0')->count();
            $data['call_data'] = $call_detals[0];

            return  ['message'=> 'success' , 'status'=>200 , 'data'=>$data];
        }
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_call_details(Request $request)
    {
        $call_detail = call_log::where('id' , $request->call_id);
        
        if(!isset($request->duration)) $request->duration = '0';
        if(!isset($request->start_time)) $request->start_time = null;
        if(!isset($request->end_time)) $request->end_time = null;

        $data=['call_status' =>  $request->call_status, 
                'duration' =>  $request->duration, 
                'start_time'=> $request->start_time,
                'end_time'=> $request->end_time];
                
                $call_detail->update($data);
                return ['message'=>'success' , 'status'=>200 , 'data'=> $request->input()];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Storecall_logRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function add_call_details(Request $request)
    {
        $return = ["staus"=>200, "message" => 'success' , 'data'=>$request->input()];
          // recevier data
        //   $recevier_data = User_data::where('id', $request->reciever_id)->get();
        //   if(!isset($recevier_data[0])) { $return['message']='reciever not found'; return $return; }
        //   $sender_data =  User_data::where('id', $request->sender_id)->get();
        //   if(!isset($sender_data[0])) { $return['message']='sender not found'; return $return; }

        // dd($recevier_data);
        if(!isset($request->sender_qr_id)) $request->sender_qr_id ='';
        if(!isset($request->reciever_qr_id)) $request->reciever_qr_id ='';

        $data= ['sender_id'=> $request->sender_id , 'reciever_id' => $request->reciever_id , 'call_status' =>'0' , 'reciever_qr_id'=>$request->reciever_qr_id , 'sender_qr_id'=>$request->sender_qr_id];
        $call = new call_log();
        $call->insert($data);
        return $return;


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
