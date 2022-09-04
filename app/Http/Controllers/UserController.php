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
        if(isset($request->number)){
        $number = $request->number;
        $data = User_data::where('phone', $number)->get();
    }
    else if(isset($request->userId)){
        $userId = $request->userId;
        $data = User_data::where('id', $userId)->get();
    }
        $response = [];
        if (isset($data[0])) {
           $vechile_data =  DB::table('vechile_details')->join('barcodes' , 'barcodes.id' ,'=' , 'vechile_details.barcode_id')->where('vechile_details.user_id' , $data[0]->id)->get()->all();
          
           $data[0]['total_qr'] = count( $vechile_data);
           $data[0]['call_history_available'] = 0;
            if ($data[0]->picture != '' || $data[0]->picture != null)
                $data[0]->picture = env('BASE_URL'). $data[0]->picture;
            else $data[0]->picture = '';
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
        if ($request->hasFile('picture') && isset($request->picture)) {
            $this->validate($request, [
                'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $image = $request->file('picture');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $image->move($public_path, $name);
        }

        $check = User_data::where('phone', $request->phone)->get();
        if (isset($check[0])) {
            $response['error'] = "404";
            $response['msg'] = "Number already registered";
            $response['data'] = null;
            return $response;
        }
        $new_user = new User_data;
        $new_user->first_name = $request->first_name;
        $new_user->last_name = $request->last_name;
        $new_user->email = $request->email;
        $new_user->phone = $request->phone;
        $new_user->picture = $name;
        // $new_user->device_id = $request->device_id;
        $new_user->save();

        // return back user data
        $user_data = User_data::where('phone', $request->phone)->get()[0];
        if ($user_data->picture != '')
            $user_data->picture = 'http://kivasa.com/apis/user_images/' . $user_data->picture;
        else $user_data->picture = '';
        $response['status'] = "200";
        $response['msg'] = "new_user_created";
        $response['data'] = $user_data;
        return  $response;
    }

    public function update(Request $request)
    {
        $user_data = User_data::where('phone', $request->phone)->get()[0];
        if (!isset($request->fname)) $fname = $user_data->first_name;
        else $fname = $request->first_name;
        if (!isset($request->lname)) $lname = $user_data->last_name;
        else $lname = $request->last_name;
        if (!isset($request->new_phone)) $phone = $user_data->phone;
        else  $phone = $request->new_phone;
     
        if (!isset($request->pic)) $pic = $user_data->picture;
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
            "first_name" => $fname,
            "last_name" => $lname,
            "phone" => $phone,
            "picture" => $pic
        ];
        $find_user->update($new_user);

        $response = [];
        $response['status'] = "200";
        $response['message'] = "data updated";
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
        $mail->Port = 587;                          // port - 587/465
        $mail->setFrom('notifications@kivasa.com', 'kivasa.com');
        // $mail->addReplyTo('', 'sender-reply-name');
        $mail->isHTML(true);                // Set email content format to HTML
        $mail->Subject = $request->emailSubject;
        $mail->Body    = "your otp for email verification is ".$otp;
        $mail->AddAddress($request->email, "");
        // $mail->AltBody = plain text version of email body;
        if( !$mail->send() ) {
            $response = ["msg" => "otp not sent" , "status"=>"404"];
            return $response;
        }
        else {
            $response = ["msg" => "otp  sent" , "status"=>"200" ,"otp"=>$otp];
            return $response;     
           }
    }


        public function logout(Request $request){
            $user_id = $request->user_id;
            $user_data = User_data::where('id', $user_id);
            $arr=['device_id' => '' , 'isLoggedIn'=>'0'];
            $user_data->update($arr);
            $response = ['status'=>200, 'msg' => 'success'];
            return $response;
        }

        public function updateEmail(Request $request){
            $user_id = $request->user_id;
            $email =  $request->email;
            $user_data = User_data::where('id', $user_id);
            $arr=['device_id' => '' , 'email'=>$email];
            $user_data->update($arr);
            $response = ['status'=>200, 'msg' => 'success'];
            return $response; 
        }

}
