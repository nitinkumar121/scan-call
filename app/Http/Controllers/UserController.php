<?php

namespace App\Http\Controllers;

use App\Models\barcode;
use App\Models\User;
use App\Models\User_data;
use App\Models\vechile_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use DB;

use File;


use function PHPUnit\Framework\returnSelf;

class UserController extends Controller
{

    function get_data(Request  $request)
    {
        $number = $request->number;
        $data = User_data::where('phone', $number)->get();
        $response = [];
        if (isset($data[0])) {
            $data[0]['vechile_data'] = DB::table('vechile_details')->join('barcodes' , 'barcodes.id' ,'=' , 'vechile_details.barcode_id')->where('vechile_details.user_id' , $data[0]->id)->get()->all();
            if ($data[0]->pic != '')
                $data[0]->pic = env('BASE_URL'). $data[0]->pic;
            else $data[0]->pic = '';
            $response['status'] = "200";
            $response['msg'] = "new user";
            $response['data'] = $data[0];
        } else {
            $response['error'] = "404";
            $response['msg'] = "user not found";
            $response['data'] = null;
        }
        return $response;
    }
    // add data
    function create(Request  $request)
    {
        $name = null;
        $public_path = public_path('/user_images');
        // upload image file
        if ($request->hasFile('pic') && isset($request->pic)) {
            $this->validate($request, [
                'pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $image = $request->file('pic');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $image->move($public_path, $name);
        }

        $check = User_data::where('phone', $request->phone)->get();
        if (isset($check[0])) {
            $response['error'] = "404";
            $response['msg'] = "No. already registered";
            $response['data'] = null;
            return $response;
        }
        $new_user = new User_data;
        $new_user->f_name = $request->fname;
        $new_user->l_name = $request->lname;
        $new_user->email = $request->email;
        $new_user->phone = $request->phone;
        $new_user->gender = $request->gender;
        $new_user->pic = $name;
        $new_user->save();

        // return back user data
        $user_data = User_data::where('phone', $request->phone)->get()[0];
        if ($user_data->pic != '')
            $user_data->pic = 'http://kivasa.com/apis/user_images/' . $user_data->pic;
        else $user_data->pic = '';
        $response['status'] = "200";
        $response['msg'] = "new user";
        $response['data'] = $user_data;
        return  $response;
    }

    public function update(Request $request)
    {
        $user_data = User_data::where('phone', $request->phone)->get()[0];
        if (!isset($request->fname)) $fname = $user_data->f_name;
        else $fname = $request->fname;
        if (!isset($request->lname)) $lname = $user_data->l_name;
        else $lname = $request->lname;
        if (!isset($request->gender)) $gender = $user_data->gender;
        else $gender = $request->gender;
        if (!isset($request->new_phone)) $phone = $user_data->phone;
        else  $phone = $request->new_phone;
        if (!isset($request->email)) $email = $user_data->email;
        else $email = $request->email;
        if (!isset($request->pic)) $pic = $user_data->pic;
        else {
            $public_path = public_path('/user_images');
            if ($request->hasFile('pic') && isset($request->pic)) {
                $this->validate($request, [
                    'pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
                $image = $request->file('pic');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $image->move($public_path, $name);

                $pic = $name;
                // unlink old image 
                $image_path = $public_path . '/' . $user_data->pic;

                if (File::exists($image_path)) {
                    //File::delete($image_path);
                    // unlink($image_path);
                }
            }
        }
        $find_user = User_data::where('phone', $request->phone);
        $new_user = [
            "f_name" => $fname,
            "l_name" => $lname,
            "email" => $email,
            "phone" => $phone,
            "gender" => $gender,
            "pic" => $pic
        ];
        $find_user->update($new_user);

        $response = [];
        $response['status'] = "200";
        $response['msg'] = "data updated";
        $response['data'] = null;
        return  $response;
    }


    public function send_otp(Request $request){
        $otp = rand('1111' , '9999');
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';             //  smtp host
        $mail->SMTPAuth = true;
        $mail->Username = 'notifications@kivasa.com';   //  sender username
        $mail->Password = 'Notifications@123';       // sender password
        $mail->SMTPSecure = 'tls';                  // encryption - ssl/tls
        $mail->Port = 465;                          // port - 587/465
        $mail->setFrom('notifications@kivasa.com', 'kivasa.com');
        $mail->addReplyTo('nitinrohilla515@gmail.com', 'sender-reply-name');
        $mail->isHTML(true);                // Set email content format to HTML
        $mail->Subject = $request->emailSubject;
        $mail->Body    = "your otp for email verification is ".$otp;
        $mail->AddAddress($request->email, "");
        // $mail->AltBody = plain text version of email body;
        if( !$mail->send() ) {
            return back()->with("failed", "otp not sent.")->withErrors($mail->ErrorInfo);
        }
        else {
            return back()->with("success", "otp has been sent.");
        }
    }
}
