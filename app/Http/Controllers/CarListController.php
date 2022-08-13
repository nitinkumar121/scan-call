<?php

namespace App\Http\Controllers;

use App\Models\carList;
use Illuminate\Http\Request;
use DB;

class CarListController extends Controller
{
    public function getList(Request $request){
if(!isset($request->brand_id)){

    return "please input valid brand id";
}
$data = carList::select("id" ,"brand_id" , "car_name" , "car_model" )->where('brand_id' , $request->brand_id)->get()->all();
$response = [
    
    "status" => "200",
    "msg"=> "success",
    "response"=>$data
];
return $response;
}

public function get_brand_names(){
    $data = DB::table("car_brands")->select("id" ,"brand_name")->get()->all();
$response = [
    "status" => "200",
    "msg"=> "success",
    "response"=>$data
];
return $response;
}
}
