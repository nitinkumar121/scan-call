<?php

namespace App\Http\Controllers;

use App\Models\vechile_detail;
use App\Http\Requests\Storevechile_detailRequest;
use App\Http\Requests\Updatevechile_detailRequest;
use App\Models\barcode;
// use GuzzleHttp\Psr7\Request;
use Symfony\Component\HttpFoundation\Request;
use File;

class VechileDetailController extends Controller
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
    public function create(Request $request)
    {

        $fornt_image = null;
        $target_path = public_path('/vechile_rc/' . date('Y-m-d'));

        if (!file_exists($target_path))
            File::makeDirectory($target_path, 0777, true);
        if (file_exists($target_path)) {
            if ($request->hasFile('rc_front_image') && isset($request->rc_front_image)) {
                $this->validate($request, [
                    'rc_front_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
                $image = $request->file('rc_front_image');
                $vechile_rc_front_image = date('Y-m-d') . '/' . time() . '.' . $image->getClientOriginalExtension();
                $image->move($target_path, $vechile_rc_front_image);
            }

            if ($request->hasFile('rc_back_image') && isset($request->rc_back_image)) {
                $this->validate($request, [
                    'rc_back_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
                $image = $request->file('rc_back_image');
                $vechile_rc_back_image = date('Y-m-d') . '/' . time() . '.' . $image->getClientOriginalExtension();
                $image->move($target_path, $vechile_rc_back_image);
            }
        }

        $barcode_id = barcode::where('status', '1')->get()->all();
        if (isset($barcode_id[0])) {
            // adding vechile data
            $vechile = new vechile_detail;
            $vechile->vechile_name = $request->vechile_name;
            $vechile->user_id = $request->user_id;
            $vechile->vechile_number = $request->vechile_number;
            $vechile->vechile_model = $request->vechile_model;
            $vechile->vechile_rc_number = $request->vechile_rc_number;
            $vechile->vechile_rc_back_image = $vechile_rc_back_image;
            $vechile->vechile_rc_front_image = $vechile_rc_front_image;
            $vechile->barcode_id = $barcode_id[0]->id;
            $vechile->save();
            $barcode = barcode::where('id', $barcode_id[0]->id);
            $barcode->update(['status' => '2']);

            $response['status'] = "200";
            $response['msg'] = "success";
            $response['data'] = $barcode_id->get()->all()[0];
        } else {
            $response['status'] = "404";
            $response['msg'] = "no barcode avilable";
            $response['data'] = null;
        }
        return  $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Storevechile_detailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storevechile_detailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\vechile_detail  $vechile_detail
     * @return \Illuminate\Http\Response
     */
    public function show(vechile_detail $vechile_detail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\vechile_detail  $vechile_detail
     * @return \Illuminate\Http\Response
     */
    public function edit(vechile_detail $vechile_detail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updatevechile_detailRequest  $request
     * @param  \App\Models\vechile_detail  $vechile_detail
     * @return \Illuminate\Http\Response
     */
    public function update(Updatevechile_detailRequest $request, vechile_detail $vechile_detail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\vechile_detail  $vechile_detail
     * @return \Illuminate\Http\Response
     */
    public function destroy(vechile_detail $vechile_detail)
    {
        //
    }
}
