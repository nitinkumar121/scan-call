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


        $url = 'https://fcm.googleapis.com/fcm/send';

        $id =['38F8477F513CF70E'];
        $message ="hello buddy";
        $fields = array (
                'registration_ids' => array (
                        $id
                ),
                'data' => array (
                        "message" => $message
                )
        );
        $fields = json_encode ( $fields );
    
        $headers = array (
                'Authorization: key=' . " MIIEvwIBADANBgkqhkiG9w0BAQEFAASCBKkwggSlAgEAAoIBAQCqKI40zgjNQO5r\n6aT9QohovlUkVOHAU8xVQFDjtEVaK84J0Euixz+rTIjkZYmIQMpqjMbAxbieRujk\nOeuYsndql5/W6wTdz9eBbQCCS7MBrAYbeTnRirven2HupvMr5kSj4/Sb0PDgYdWI\nWO/jWxCFx3kF/1oQ6GLEoIPA0DtU8h/vX2R8lsRrbGLifuxl02lNNDnQQv1jP6J8\ncDxkSnxMsQiAOAlP7qlJUMszEXnLHCNanHQeGg+dYculCR1Ocf5uZAo+W27umbNj\n0Tzn78gDlMsH4taxK5uG2fqBxghXWG7T73btQlW+68XOxt97F06vM/X0T1vxCXGo\naXKkJny5AgMBAAECggEADAcW2juwGpYa5EzdKTvBOaouiYVoebhSqroDnbzZ5CBR\njZcIKabs5LZhvMdCm/t8c2ClEe5H+QQpJSzE7wO6djHmjgIJ04YEBTWHwi4Iprca\nrWl5wUqNshRRD1YEvVcnBfCwky0HQc0Yk20587e1qMcrUlW075oFlUGFXqU5dG0V\neA96v3QhPxltd6eumMdVZdWJ8Q5fP20QG8t6ptgV6ClDGFhNElPfrU70oa+IH7BZ\n5ZwEYKzEjWt0ro6D7ubtflQCxYWYhOmlez1vSAr3WeEHCFcVSpbZFBH+1vFxnJXy\nswkRqP8Fa1TZzlr0S39TjDa0+0thKrAEQwMnvHr+AQKBgQDXxE3tE5h+XIUJ6n1B\nKPlfedGEzZYr3aSG43TFavzD1IvPr0sDl3OPkeYG/wYW8Ts1heBLyHtGrr7BEVAA\n9MxSQeFz57ljtUeTWWRw5FV5IdLsrzDyYTPtXr1fimkEKwmLs7WoHn3P3FzSgs1x\nEDCmplN4PEnVS4r5CXXUqc0MgQKBgQDJ4x7LjMEdkPrvI1LOjVgiy3WCKhZEyAp8\nZXk3PTwbGQ7o38T2UrgqF21P0HQsRJcmXa2m7bFI9pgYCFeTB4IeDd4DJZ+G9FhS\nAOyy9EEC0pg71DniOwP+kSkEPkawAgCCo8oHuULF6fLUEAA/cqGFfm6kICuFQt6L\n59iw3rS0OQKBgQDBSywgYfiv4wSQEJCrSiC1BrXLSj3pCEN3T9dxcFoGuaeSo9AI\n5KnzCVpQFDEJZoyLc2avnWfKt4tN/Mt2P9e3LSvjIMl1aJY5i9CuTe/Ad6u0u3GX\nAbt6P/BY4e8Ye9GuZI0tkjtVdm11bRbM3hsngEOwqBngyi8y0OXNYVy/gQKBgQCx\n6vKMuDLId6htb1feqDnwEBYy7BxL6W80SckVoWWDDAZTvEC8RBIBJjwzhqWbDaeX\nLB+JaRhAEPHg3BkxfgBxtA7f/xwjttrPCfmPjCpu7mEy+Mk6UoAmrI7VKnzpSBpj\nBy1YuS/bc12I/cD6KW+nUdD321H/UvsFmQEifmIKIQKBgQCL30ijvrNW9tEceAd1\nh4U0TwpR2FBhntDjG6ond6JMFohsA7S1hNhpf6eAyO0DOI2Icrar3IG5Lo73AyqM\nskq7HozH5r2EM7MgWN+lEVTwxpNzc8umkfvWDwtZpbp7DLZKki4e6asOmRbP+RzY\nV5aSIsXNT8DV6wKdPcXERtCjCA==",
                'Content-Type: application/json'
        );
    
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
    
        $result = curl_exec ( $ch );
        echo $result;
        curl_close ( $ch );




        
        return $request;


        $otp = rand('1111' , '9999');
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';             //  smtp host
        $mail->SMTPAuth = true;
        $mail->Username = 'nitinrohilla515@gmail.com';   //  sender username
        $mail->Password = '9password';       // sender password
        $mail->SMTPSecure = 'tls';                  // encryption - ssl/tls
        $mail->Port = 587;                          // port - 587/465
        $mail->setFrom('nitinrohilla515@gmail.com', 'kivasa.com');
        $mail->addReplyTo('rohillaking148@gmail.com', 'sender-reply-name');
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
