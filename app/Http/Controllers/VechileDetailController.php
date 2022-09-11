<?php

namespace App\Http\Controllers;

use App\Models\vechile_detail;
use App\Http\Requests\Storevechile_detailRequest;
use App\Http\Requests\Updatevechile_detailRequest;
use App\Models\barcode;
use DB;
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
    public function get_vehicles( Request $request)
    {
        
        $vechile_data_all = vechile_detail::select( 'vechile_details.vechile_number','vechile_details.car_model_id', 'vechile_details.vechile_rc_front_image', 'vechile_details.color', 'barcodes.barcode_number' , 'barcodes.barcode_image' , 'barcodes.status')->where('vechile_details.user_id'  , $request->user_id)->leftJoin('barcodes' , "vechile_details.barcode_id" ,'=', 'barcodes.id')->get();
        $data_arr=[];
        if($vechile_data_all[0] == null) return   $response = ['status'=> 404 , 'message'=> "No Data found", 'data'=> []];

        foreach ($vechile_data_all as $vechile_data){
        $data=[];
        $car_model =  DB::table('car_lists')->join('car_brands' , 'car_brands.id', '=' , 'car_lists.brand_id')->where('car_lists.id' , $vechile_data->car_model_id)->get()->all();
        $vechile_data->car_model_id =  $car_model[0]->car_name;
        $data = $vechile_data;
        $data['car_name'] = $car_model[0]->car_name;
        $data['car_model'] = $car_model[0]->car_model;
        $data['brand_name'] = $car_model[0]->brand_name;

        array_push($data_arr , $data);
        }
        $response = ['status'=> 200 , 'message'=> "success", 'data'=> $data_arr];
        return $response;

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

           
        }

        $barcode_id = barcode::where('status', '1')->get()->all();
        if (isset($barcode_id[0])) {
            // adding vechile data
            $vechile = new vechile_detail;
            $vechile->user_id = $request->user_id;
            $vechile->brand_id = $request->brand_id;
            // $vechile->vechile_number = $request->vechile_number;
            $vechile->vechile_rc_front_image = $vechile_rc_front_image;
            $vechile->color = $request->color;
            $vechile->car_model_id = $request->car_model_id;
            $vechile->vechile_rc_back_image ='';
            $vechile->barcode_id = $barcode_id[0]->id;
            $vechile->address = $request->address;
            $vechile->save();

            $new_id = $vechile->id;
            $barcode = barcode::where('id', $barcode_id[0]->id);
            $barcode->update(['status' => '2']);

            $vechile_new = vechile_detail::where('id' , $new_id);

            $response['status'] = "200";
            $response['msg'] = "success";
            $response['data']['vehicle'] =$vechile_new->get()->all()[0];
            $response['data']['barcode'] = $barcode->get()->all()[0];
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
