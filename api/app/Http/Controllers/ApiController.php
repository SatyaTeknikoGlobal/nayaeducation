<?php

namespace App\Http\Controllers;

use JWTAuth;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;
use Illuminate\support\str;

use App\User;
use App\AppVersion;
use App\UserLogin;
use App\UserOtp;
use App\Visitor;
use App\Admin;
use App\State;
use App\City;
use App\Society;
use App\Blocks;
use App\Flats;
use App\Services;
use App\ServiceUsers;
use App\UserDailyHelp;
use App\UserDocument;
use App\UserVehicle;
use App\Complaints;
use App\Chats;
use App\FAQs;
use App\Banner;
use App\Category;
use App\Course;
use App\LiveClass;
use App\Contents;
use App\Subject;
use App\Order;
use App\Form;
use App\SubscriptionHistory;


use Razorpay\Api\Api;

use Mail;
use Storage;



class ApiController extends Controller
{


    public function __construct()
    {
        $this->user = new User;
        date_default_timezone_set("Asia/Kolkata");
        $this->url = env('BASE_URL');
    }







    //============================= Fans Studio API ==================================//

    public function app_version(){
        $app_version = AppVersion::first();
        return response()->json([
            'result' => true,
            'message' => '',
            'version' => $app_version,
        ],200);
    }


    public static function sendEmail($viewPath, $viewData, $to, $from, $replyTo, $subject, $params=array()){

        try{

            Mail::send(
                $viewPath,
                $viewData,
                function($message) use ($to, $from, $replyTo, $subject, $params) {
                    $attachment = (isset($params['attachment']))?$params['attachment']:'';

                    if(!empty($replyTo)){
                        $message->replyTo($replyTo);
                    }

                    if(!empty($from)){
                        $message->from($from);
                    }

                    if(!empty($attachment)){
                        $message->attach($attachment);
                    }

                    $message->to($to);
                    $message->subject($subject);

                }
            );
        }
        catch(\Exception $e){
            // Never reached
        }

        if( count(Mail::failures()) > 0 ) {
            return false;
        }
        else {
            return true;
        }

    }

    public function verify_otp_forget_password(Request $request){
      $validator =  Validator::make($request->all(), [
        'email' => 'required|email',
        'otp' => 'required',
        'password'=>'required',
        'confirm_password'=>'required|same:password',
    ]);

      $user = null;

      if ($validator->fails()) {

        return response()->json([
            'result' => false,
            'message' => json_encode($validator->errors()),

        ],400);

    }
    $exist = UserOtp::where('email',$request->email)->first();
    if(!empty($exist)){
        if($request->otp == $exist->otp){
            UserOtp::where('email',$request->email)->update(['otp'=>null]);
            $updates = User::where('email',$request->email)->update(['password'=>bcrypt($request->password)]);
            return response()->json([
                'result' => true,
                'message' => 'Verified Successfully',
            ],200);
        }else{
         return response()->json([

            'result' => false,
            'message' => 'Invalid OTP',
        ],200);
     }

 }else{
     return response()->json([
        'result' => false,
        'message' => 'Invalid OTP',
    ],200);
 }

}

public function send_otp(Request $request)
{
    $validator =  Validator::make($request->all(), [
        // 'mobile' => 'required',
        // 'name' => 'required|max:255',
        'phone' => 'required|unique:users,phone',
        'email'=>'required|unique:users',
        // 'password'=>'required',
    ]);

    $status = 'new';

    if ($validator->fails()) {

        return response()->json([
            'result' => false,
            'otp'=> '',
            'message' => json_encode($validator->errors()),

        ],200);
    }

    $otp = 1234;

    $message = $otp." is your authentication Code to register.";
    $mobile = $request['phone'];
    $time = date("Y-m-d H:i:s",strtotime('15 minutes'));

    if(!empty($request->phone)){
            // $this->send_message($mobile,$message);
        UserOtp::updateOrcreate([
            'mobile'=>$mobile],[
                'otp'=>$otp,
                'timestamp'=>$time,
            ]);

    }
    return response()->json([
        'result' => true,
        'message' => 'SMS Sent SuccessFully',
        'otp'=>$otp,
    ],200);
}

public function verify_otp(Request $request){
    $validator =  Validator::make($request->all(), [
        'phone' => 'required',
        'otp'=>'required',

    ]);

    if ($validator->fails()) {
        return response()->json([
            'result' => false,

            'message' => json_encode($validator->errors()),

        ],400);
    }

    $mobile = isset($request->phone) ? $request->phone :'';
    $otp = isset($request->otp) ? $request->otp :'';

    if(!empty($mobile)){
        $verify_otp  = UserOtp::where(['mobile'=>$mobile,'otp'=>$otp])->first();
    }

    if(!empty($verify_otp)){
        return response()->json([
            'result' => true,
            'message' => 'OTP Varified SuccessFully',
        ],200);

    }else{
        return response()->json([
            'result' => false,
            'message' => 'OTP Not Varified',
        ],200);

    }



}


public function forget_password(Request $request){
 $validator =  Validator::make($request->all(), [
    'email' => 'required|email',
]);

 $user = null;

 if ($validator->fails()) {

    return response()->json([
        'result' => false,
        'message' => json_encode($validator->errors()),

    ],400);

}

$exist = User::where('email',$request->email)->first();
if(!empty($exist)){
    // $otp = rand(1111,9999);
    $otp = 1234;
    UserOtp::updateOrcreate([
        'email'=>$request->email],
        ['otp'=>$otp,
    ]);

    $to_email = $request->email;
    $from_email = 'satyasahoo.abc@gmail.com';
    $subject = 'Forgot Password Email - NAYAEDUCATION';
    $email_data = [];
    $email_data['otp'] = $otp;
    $success = $this->sendEmail('mail', $email_data, $to=$to_email, $from_email, $replyTo = $from_email, $subject);
    if($success){
        return response()->json([

            'result' => true,
            'message' => ' Successfully',
        ],200); 
    }else{
     return response()->json([

        'result' => false,
        'message' => ' Something Went Wrong',
    ],200);
 }




}else{
    return response()->json([

        'result' => false,
        'message' => 'User Not Exist',
    ],200);
}





}





public function send_test_notification(Request $request){


    $deviceToken = 'dzHn8qdTQROVj2H4KpX5aZ:APA91bE6NHu2jstkNRx49H7gcBBKrWgb1Gbr_r-oc-PxKW6IU_GzD9ZP0o26lpKFmPqbnq6Ewl3jGYVq6dq_uSmCCF_L96Xl_apzOs4nrD7cPaEOsdBjdnTGJhTE7Ig7R4X6z4Xj9S5y';
    $sendData = array(
        'body' => 'Test',
        'title' => 'My Door Notification',
        'sound' => 'Default',
    );
    $result = $this->fcmNotification($deviceToken,$sendData);

    print_r($result);

}



public function send_message()
{
    // $sender = "CITRUS";
    // $message = urlencode($message);
    // $msg = "sender=".$sender."&route=4&country=91&message=".$message."&mobiles=".$mobile."&authkey=284738AIuEZXRVCDfj5d26feae";

    // $ch = curl_init('http://api.msg91.com/api/sendhttp.php?');
    // curl_setopt($ch, CURLOPT_POST, true);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $msg);
    //     //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // $res = curl_exec($ch);
    // $result = curl_close($ch);
    // return $res;

//$mobile,$message
    $curl = curl_init();

    curl_setopt_array($curl, [
      CURLOPT_URL => "https://api.msg91.com/api/v5/flow/",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "{\n  \"flow_id\": \"61e559bdd8caa36a6b0d0c53\",\n  \"sender\": \"TEKGLO\",\n  \"mobiles\": \"916370371406\",\n  \"otp\": \"1234\",\n  \"tekniko\": \"Tekniko\"\n}",
      CURLOPT_HTTPHEADER => [
        "authkey: 285140ArLurg2KnR61e3d660P1",
        "content-type: application/JSON"
    ],
]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
  } else {
      echo $response;
  }

}




public function logout(Request $request)
{
    $validator =  Validator::make($request->all(), [
        'token' => 'required',
    ]);

    if ($validator->fails()) {

        return response()->json([
            'result' => false,
            'message' => json_encode($validator->errors())
        ],400);
    }

    try {
        $user_login = UserLogin::where(['user_id' => $request->token])->delete();
        JWTAuth::invalidate($request->token);
        return response()->json([
            'result' => true,
            'message' => 'User logged out successfully'
        ],200);
    } catch (JWTException $exception) {
        return response()->json([
            'result' => false,
            'message' => 'Sorry, the user cannot be logged out'
        ], 500);
    }
}





public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
        'phone' => 'required|unique:users,phone',
        'email'=>'required|unique:users',
        'password'=>'required',
        'deviceID' => 'required',
        'deviceToken' => 'required',
        'deviceType' => 'required',
    ]);
    if ($validator->fails()) {
        return response()->json([
            'result' => false,
            'message' => json_encode($validator->errors()),
            'token'=>null,
            'user'=>null
        ],200);
    }

    $exist = [];
    if(!empty($request->referral_code)){
        $exist = User::where('referral_code',$request->referral_code)->first();
    }
    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;
    $user->password = bcrypt($request->password);
    $user->status = 1;
    $user->referral_code = $this->generateReferalCode(8);


    if(!empty($exist)){
        $user->referral_userID = $exist->id;
    }
    $user->image= 'user.png';
    $user->save();
    $credentials = $request->only('phone');
    $user = User::where('phone',$credentials)->first();
    $user->image= $this->url.'/api/public/images/users/'.$user->image;
    try {
        if (!empty($user)) {
            if (!$token = JWTAuth::fromUser($user)) {
                return response()->json([
                    'result' => false,
                    'token' => null,
                    'message' => 'invalid_credentials',
                    'user' => null], 200);
            }
        } else {
            return response()->json([
                'result' => false,
                'token' => null,
                'message' => 'invalid_credentials',
                'user' => null], 200);
        }

    } catch (JWTException $e) {
        return response()->json([
            'result' => false,
            'token' => null,
            'message' => 'could_not_create_token',
            'user' => null], 200);
    }
    $deviceID = $request->input("deviceID");
    $deviceToken = $request->input("deviceToken");
    $deviceType = $request->input("deviceType");
    $device_info = UserLogin::where(['user_id'=>$user->id])->first();
    UserLogin::create([
        "user_id"=>$user->id,
        "ip_address"=>$request->ip(),
        "deviceID"=>$deviceID,
        "deviceToken"=>$deviceToken,
        "deviceType"=>$deviceType,
    ]);
    unset($user->id);
    if($user->photo!=='' && $user->photo!=null){
        $user->photo =  asset('public/images/'.$user->photo);
    }

    return response()->json([
        'result' => true,
        'token' => $token,
        'message' => 'Successful Login',
        'user' => $user
    ],200);
}


public  function generateReferalCode($length = 8) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    $exist = User::where('referral_code',$randomString)->first();
    if(!empty($exist)){
        self::generateReferalCode($length);
    }
    return $randomString;
}

public function login(Request $request){
  $validator =  Validator::make($request->all(), [
    'email' => 'required',
    'password' => 'required',
    'deviceID' => '',
    'deviceToken' => '',
    'deviceType' => '',

]);

  $user = null;

  if ($validator->fails()) {

    return response()->json([

        'result' => false,

        'token' => null,

        'message' => json_encode($validator->errors()),

        'user'=>$user

    ],400);

}

$email = $request->input('email');
$password  = $request->input('password');
$hash_chack = '';
$checkuser = User::where(['email'=>$email])->first();

if(!empty($checkuser)){
    if(!empty($checkuser)){
        $existing_password = $checkuser->password;
        $hash_chack = Hash::check($request->password, $existing_password);

    }else{
       return response()->json([
        'result' => false,
        'token' => null,
        'message' => 'Account Doesnt Exist',
        'user' => null], 200);
   }
   if (empty($hash_chack)){
    return response()->json([
        'result' => false,
        'token' => null,
        'message' => 'Incorrect Password',
        'user' => null], 200);
}
}else{
   return response()->json([

    'result' => false,

    'token' => null,

    'message' => 'Account Does not Exist',

    'user' => null], 200);
}

$credentials = $request->only('email');

$user = User::where($credentials)->first();
if(!empty($user->image)){
    $user->image = $this->url.'/api/public/images/users/'.$user->image;
}
try {

    if (!empty($user)) {

        if (!$token = JWTAuth::fromUser($user)) {

            return response()->json([

                'result' => false,

                'token' => null,

                'message' => 'invalid_credentials',

                'user' => null], 400);

        }

    } else {

        return response()->json([

            'result' => false,

            'token' => null,

            'message' => 'invalid_credentials',

            'user' => null], 400);

    }



} catch (JWTException $e) {

    return response()->json([

        'result' => false,

        'token' => null,

        'message' => 'could_not_create_token',

        'user' => null], 500);

}



$deviceID = $request->input("deviceID");

$deviceToken = $request->input("deviceToken");

$deviceType = $request->input("deviceType");

$device_info = UserLogin::where(['user_id'=>$user->id])->first();

if (!empty($device_info)){

    $device_info->deviceToken = $deviceToken;

    $device_info->deviceType = $deviceType;

    $device_info->save();

            //$checkOtp->delete();

    return response()->json([

        'result' => true,

        'token' => $token,

        'message' => 'Successful Login',

        'user' => $user

    ],200);

}

UserLogin::create([

    "user_id"=>$user->id,

    "ip_address"=>$request->ip(),

    "deviceID"=>$deviceID,

    "deviceToken"=>$deviceToken,

    "deviceType"=>$deviceType,

]);



        // $checkOtp->delete();

return response()->json([

    'result' => true,

    'token' => $token,

    'message' => 'Successful Login',

    'user' => $user

],200);




}





public function update_profile(Request $request){
    $validator =  Validator::make($request->all(), [
        'token' => 'required',
    ]);
    $user = null;
    if ($validator->fails()) {
        return response()->json([
            'result' => false,
            'message' => json_encode($validator->errors()),
            'user' =>$user,
        ],400);
    }
    $user = JWTAuth::parseToken()->authenticate();
    if (empty($user)){
        return response()->json([
            'result' => false,
            'message' => '',
            'user' =>$user,
        ],401);
    }

    $dbArray= [];
    if(!empty($request->name)){
        $dbArray['name'] = $request->name;
    }

    if(!empty($request->dob)){
        $dbArray['dob'] = $request->dob;
    }
    if(!empty($request->gender)){
        $dbArray['gender'] = $request->gender;
    }
    
    if($request->hasFile('image')){
        $file = $request->file('image');
        $destinationPath = public_path("/images/users/");
        $side = $request->file('image');
        $side_name = $user->id.'_user_profile'.time().'.'.$side->getClientOriginalExtension();
        $side->move($destinationPath, $side_name);
        $dbArray['image'] = $side_name;
    }


    User::where('id',$user->id)->update($dbArray);
    $user = User::where('id',$user->id)->first();

    if(!empty($user) && !empty($user->image)){
        $image= $this->url.'/api/public/images/users/'.$user->image;
    }else{
        $image= $this->url.'/api/public/images/users/user.png';
    }

    $user->image = $image;

    return response()->json([
        'result' => true,
        'message' => 'Profile Updated successfully',
        'user'=>$user,
        'token'=>$request->token,
    ],200);

}



public function profile(Request $request){
    $validator =  Validator::make($request->all(), [
        'token' => 'required',
    ]);
    $user = array();
    $user = null;
    if ($validator->fails()) {
        return response()->json([
            'result' => false,
            'message' => json_encode($validator->errors()),
            'user' =>$user,
        ],400);
    }
    $user = JWTAuth::parseToken()->authenticate();
    if (empty($user)){
        return response()->json([
            'result' => false,
            'message' => '',
            'user' =>$user,
        ],401);
    }


    if(!empty($user) && !empty($user->image)){
        $user->image= $this->url.'/api/public/images/users/'.$user->image;
    }else{
        $user->image= $this->url.'/api/public/images/users/user.png';
    }

    return response()->json([
        'result' => true,
        'message' => 'User Profile',
        'user'=>$user,
        'token'=>$request->token,
    ],200);

}


public function change_password(Request $request){
    $validator =  Validator::make($request->all(), [
        'token' => 'required',
        'password' => 'required',
        'confirm_password' => 'required_with:password|same:password',

    ]);
    $user = null;
    if ($validator->fails()) {
        return response()->json([
            'result' => false,
            'message' => json_encode($validator->errors()),
        ],400);
    }
    $user = JWTAuth::parseToken()->authenticate();
    if (empty($user)){
        return response()->json([
            'result' => false,
            'message' => '',
        ],401);
    }
    $user = User::where('id',$user->id)->first();
    if(!empty($user)){
        User::where('id',$user->id)->update(['password'=>bcrypt($request->password)]);
    }

    $user_login = UserLogin::where(['user_id' => $user->id])->delete();
    JWTAuth::invalidate($request->token);

    return response()->json([
        'result' => true,
        'message' => 'Password Changed Successfully',
    ],200);
}




public function state_city_list(Request $request){
    $validator =  Validator::make($request->all(), [
        'token' => 'required',

    ]);
    $list = null;
    $user = null;
    if ($validator->fails()) {
        return response()->json([
            'result' => false,
            'message' => json_encode($validator->errors()),
            'list' =>$list,
        ],400);
    }
    $user = JWTAuth::parseToken()->authenticate();
    if (empty($user)){
        return response()->json([
            'result' => false,
            'message' => '',
            'list' =>$list,
        ],401);
    }

    $states = State::select('id','name')->where('status',1)->get();
    if(!empty($states)){
        foreach($states as $state){
            $cities = City::select('id','name')->where('state_id',$state->id)->where('status',1)->get();
            if(!empty($cities)){
                $state->cities = $cities;
            }
        }
    }


    return response()->json([
        'result' => true,
        'message' => 'State City List',
        'list'=>$states,
    ],200);
}


public function cmspages(Request $request){
    $validator =  Validator::make($request->all(), [
        'token' => 'required',
        'type' => 'required',
    ]);
    $pages = null;
    $user = null;
    if ($validator->fails()) {
        return response()->json([
            'result' => false,
            'message' => json_encode($validator->errors()),
            'pages' =>$pages,
        ],400);
    }
    $user = JWTAuth::parseToken()->authenticate();
    if (empty($user)){
        return response()->json([
            'result' => false,
            'message' => '',
            'pages' =>$pages,
        ],401);
    }
    $cms = DB::table('settings')->where('id',1)->first();
    if($request->type == 'contactus'){
        $pages = $cms->contactus ?? '';
    }
    if($request->type == 'about'){
      $pages = $cms->about ?? '';
  }

  if($request->type == 'privacy'){
   $pages = $cms->privacy ?? '';
}

if($request->type == 'terms'){
   $pages = $cms->privacy ?? '';
}



return response()->json([
    'result' => true,
    'message' => 'CMS Pages List',
    'pages'=>$pages,
],200);




}
















public function notification_list(Request $request){
    $validator =  Validator::make($request->all(), [
        'token' => 'required',

    ]);
    $notifications = null;
    $user = null;
    if ($validator->fails()) {
        return response()->json([
            'result' => false,
            'message' => json_encode($validator->errors()),
            'notifications' =>$notifications,
        ],400);
    }
    $user = JWTAuth::parseToken()->authenticate();
    if (empty($user)){
        return response()->json([
            'result' => false,
            'message' => '',
            'notifications' =>$notifications,
        ],401);
    }
    $notifications = DB::table('notifications')->select('id','user_id','text','image')->where('user_id',$user->id)->get();

    return response()->json([
        'result' => true,
        'message' => 'Notification List',
        'notifications'=>$notifications,
    ],200);

}


public function contact_us(Request $request){
   $validator =  Validator::make($request->all(), [
    'token' => 'required',
    'name' => 'required',
    'email' => 'required',
    'message' => 'required',

]);

   $user = null;
   if ($validator->fails()) {
    return response()->json([
        'result' => false,
        'message' => json_encode($validator->errors()),

    ],400);
}
$user = JWTAuth::parseToken()->authenticate();
if (empty($user)){
    return response()->json([
        'result' => false,
        'message' => '',
    ],401);
}


$dbArray = [];
$dbArray['name'] = $request->name;
$dbArray['email'] = $request->email;
$dbArray['message'] = $request->message;
$dbArray['user_id'] = $user->id;

DB::table('contact_us')->insert($dbArray);

return response()->json([
    'result' => true,
    'message' => 'Submitted Successfully',
],200); 
}




public function get_course_package($user_id,$course_id){
    $packages = [];
    $exist = DB::table('user_sub_type')->where('user_id',$user_id)->where('course_id',$course_id)->first();
    $course = Course::where('id',$course_id)->first();
    if(!empty($exist)){
        if($exist->sub_type == 'monthly'){
            $packages[] = array('plan_name'=>'monthly','amount'=>$course->monthly_amount,'title'=>'Monthly Subscription Plan');
        }
    }else{
        $packages[] = array('plan_name'=>'monthly','amount'=>$course->monthly_amount,'title'=>'Monthly Subscription Plan');
        $packages[] = array('plan_name'=>'full','amount'=>$course->full_amount,'title'=>'Full Course Subscription Plan');
    }

    return $packages;


}


public function home(Request $request){
    $validator =  Validator::make($request->all(), [
        'token' => 'required',
    ]);

    $user = null;
    if ($validator->fails()) {
        return response()->json([
            'result' => false,
            'message' => json_encode($validator->errors()),

        ],400);
    }
    $user = JWTAuth::parseToken()->authenticate();
    if (empty($user)){
        return response()->json([
            'result' => false,
            'message' => '',
        ],401);
    }

    $home_data = [];
    $banners = Banner::where('status',1)->get();

    if(!empty($banners)){
        foreach($banners as $banner){

        }
    }

    $categories = Category::select('id','category_name','category_description')->where('is_delete',0)->where('status',1)->get();

    $categoriesArr = [];
    if(!empty($categories)){
        foreach($categories as $category){
            $course = Course::select('id','course_name','course_description','fees','full_amount')->where('is_delete',0)->where('status',1)->where('category_id',$category->id)->limit(5)->get();
            if(!empty($course)){
                foreach($course as $cr){

                    $cr->is_subscription = 'N';
                    $is_sub = $this->check_subscription($user->id,$cr->id);
                    if($is_sub){
                        $cr->is_subscription = 'Y';
                    }
                    $cr->fees = $cr->full_amount;

                    $packages = $this->get_course_package($user->id,$cr->id);
                    
                    $cr->packages = $packages;

                }
            }


            $category->course = $course;

            if(!empty($course)){
             $categoriesArr[] = $category;
         }
     }
 }




 $home_data['banners'] = $banners;
 $home_data['categories'] = $categoriesArr;


 return response()->json([
    'result' => true,
    'message' => 'Home Data',
    'home_data'=>$home_data,


],200); 
}

public function course_details(Request $request){
    $validator =  Validator::make($request->all(), [
        'token' => 'required',
        'course_id' => 'required',
    ]);

    $user = null;
    if ($validator->fails()) {
        return response()->json([
            'result' => false,
            'message' => json_encode($validator->errors()),

        ],400);
    }
    $user = JWTAuth::parseToken()->authenticate();
    if (empty($user)){
        return response()->json([
            'result' => false,
            'message' => '',
        ],401);
    }

    $course_details = [];
    $course_details = Course::where('id',$request->course_id)->first();
    $is_subscription = 'N';

    $exist = $this->check_subscription($user->id,$course_details->id);
    if($exist){
        $is_subscription = 'Y';

    }


    if(!empty($course_details)){
        $course_details->is_subscription = $is_subscription;
        $packages = $this->get_course_package($user->id,$course_details->id);
        $course_details->packages = $packages;
    }

    return response()->json([
        'result' => true,
        'message' => 'Course Details',
        'course_details'=>$course_details,



    ],200);  


}

public function course_list_by_category(Request $request){
    $validator =  Validator::make($request->all(), [
        'token' => 'required',
        'category_id' => 'required',
    ]);

    $user = null;
    if ($validator->fails()) {
        return response()->json([
            'result' => false,
            'message' => json_encode($validator->errors()),

        ],400);
    }
    $user = JWTAuth::parseToken()->authenticate();
    if (empty($user)){
        return response()->json([
            'result' => false,
            'message' => '',
        ],401);
    }

    $category = Category::where('id',$request->category_id)->first();


    $course_list = [];
    $course_list = Course::where('category_id',$request->category_id)->where('status',1)->where('is_delete',0)->get();
    if(!empty($course_list)){
        foreach($course_list as $course){
            $course->is_subscription = 'N';
            $is_sub = $this->check_subscription($user->id,$course->id);
            if($is_sub){
                $course->is_subscription = 'Y';
            }
            $course->fees = $course->full_amount; 
            
            $packages = $this->get_course_package($user->id,$course->id);


            $course->packages = $packages;




        }
    }
    return response()->json([
        'result' => true,
        'message' => 'Get Course List By Category',
        'category'=>$category,
        'course_list'=>$course_list,


    ],200);  


}




public function live_classes_list(Request $request){
    $validator =  Validator::make($request->all(), [
        'token' => 'required',
        'course_id' => 'required',
    ]);

    $user = null;
    if ($validator->fails()) {
        return response()->json([
            'result' => false,
            'message' => json_encode($validator->errors()),

        ],400);
    }
    $user = JWTAuth::parseToken()->authenticate();
    if (empty($user)){
        return response()->json([
            'result' => false,
            'message' => '',
        ],401);
    }

    
    $live_classes = LiveClass::where('course_id',$request->course_id)->where('end_date','>=',date('Y-m-d'))->latest()->get();


    if(!empty($live_classes)){
        foreach($live_classes as $class){
            $class->is_subscription = 'Y';

            $class->amount = 50;


        }
    }
    return response()->json([
        'result' => true,
        'message' => 'Live Classes List',
        'live_classes'=>$live_classes,
    ],200);  


}


public function transaction_history(Request $request){
    $validator =  Validator::make($request->all(), [
        'token' => 'required',
    ]);

    $user = null;
    if ($validator->fails()) {
        return response()->json([
            'result' => false,
            'message' => json_encode($validator->errors()),

        ],400);
    }
    $user = JWTAuth::parseToken()->authenticate();
    if (empty($user)){
        return response()->json([
            'result' => false,
            'message' => '',
        ],401);
    }

    
    $transaction_history = DB::table('transactions')->where('user_id',$user->id)->latest()->get();


    if(!empty($transaction_history)){
        foreach($transaction_history as $his){
            $his->paid_at = date('d M Y h:i A',strtotime($his->created_at));
        }
    }
    return response()->json([
        'result' => true,
        'message' => 'Transaction History',
        'transaction_history'=>$transaction_history,
    ],200);  


}




public function create_payment(Request $request){
    $validator =  Validator::make($request->all(), [
        'token' => 'required',
        'course_id' => 'required',
        'type' => 'required',
    ]);
    $user = null;
    if ($validator->fails()) {
        return response()->json([
            'result' => false,
            'message' => json_encode($validator->errors()),

        ],400);
    }
    $user = JWTAuth::parseToken()->authenticate();
    if (empty($user)){
        return response()->json([
            'result' => false,
            'message' => '',
        ],401);
    }
    $api_key = 'rzp_test_PrWbblwHjSxp2p';
    $api_secret = 'ecOIpaWurUy28fjgj3VxPWOw';
    $api = new Api($api_key, $api_secret);
    $amount = 0;

    $course = Course::where('id',$request->course_id)->first();
    if(!empty($course)){
        if($request->type == 'monthly'){
            $amount = $course->monthly_amount;
        }
        if($request->type == 'full'){
            $amount = $course->full_amount;
        }
    }

    if($amount == 0){
     return response()->json([
        'result' => false,
        'message' => 'No Found',
    ],400);
 }

 $paymentArr = [];
 $paymentArr['currency'] = "INR"; 
 $paymentArr['amount'] = $amount * 100; 
 $order = $api->order->create($paymentArr);
 $orderId = $order['id'];
 $user_payment = new SubscriptionHistory;

 $user_payment->user_id =  $user->id;
 $user_payment->amount = $amount;
 $user_payment->payment_type = 'online';
 $user_payment->payment_cause = 'subscription';

 $user_payment->course_id = $request->course_id;
 $user_payment->type = $request->type;
 $user_payment->order_id = $orderId;
 $user_payment->save();

 return response()->json([
    'result' => true,
    'message' => 'Succesfully',
    'payment_details' => $user_payment,
    'callback_url' => url('api/check_payment'),
],200);


}




public function check_payment(Request $request){
 $validator =  Validator::make($request->all(), [
    'razorpay_order_id' => 'required',
    'razorpay_signature' => 'required',
    'razorpay_payment_id' => 'required',
]);

 if ($validator->fails()) {
    return response()->json([
        'result' => false,
        'message' => json_encode($validator->errors()),

    ],400);
}

$data = [];

$data['razorpay_order_id'] = $request->razorpay_order_id;
$data['razorpay_signature'] = $request->razorpay_signature;
$data['razorpay_payment_id'] = $request->razorpay_payment_id;

$data = $request->all();
$user = SubscriptionHistory::where('order_id', $data['razorpay_order_id'])->first();
$user->paid_status = true;
$user->txn_no = $data['razorpay_payment_id'];
$api = new Api('rzp_test_PrWbblwHjSxp2p', 'ecOIpaWurUy28fjgj3VxPWOw');
try{
    $attributes = array(
     'razorpay_signature' => $data['razorpay_signature'],
     'razorpay_payment_id' => $data['razorpay_payment_id'],
     'razorpay_order_id' => $data['razorpay_order_id']
 );
    $order = $api->utility->verifyPaymentSignature($attributes);
    $success = true;
}catch(SignatureVerificationError $e){

    $succes = false;
}


if($success){
    $user->save();


    $course = Course::where('id',$user->course_id)->first();


    $transactionArr = [];
    $transactionArr['user_id'] = $user->user_id;
    $transactionArr['txn_no'] = $user->txn_no;
    $transactionArr['reason'] = $course->course_name ?? '';
    $transactionArr['amount'] = $user->amount;
    $transactionArr['type'] = 'debit';
    $transactionArr['status'] = 1;


    DB::table('transactions')->insert($transactionArr);

    $sub_type_exist = DB::table('user_sub_type')->where('user_id',$user->user_id)->where('course_id',$user->course_id)->first();

    if(empty($sub_type_exist)){
        $arrArr = [];
        $arrArr['user_id'] = $user->user_id;
        $arrArr['course_id'] = $user->course_id;
        $arrArr['sub_type'] = $user->type;
        DB::table('user_sub_type')->insert($arrArr);
    }
    

        ///////Update paid Status

    if(!empty($course)){
        if($course->type == 'pre_recorded'){
            if($user->type == 'monthly'){
                $dbArray = [];
                $dbArray['start_date'] = date('Y-m-d');
                $date = date('Y-m-d');
                $dbArray['end_date'] = date('Y-m-d', strtotime($date. ' + 1 months'));
                SubscriptionHistory::where('id',$user->id)->update($dbArray);
            }
            if($user->type == 'full'){
                $dbArray = [];
                $dbArray['start_date'] = date('Y-m-d');
                $dbArray['end_date'] = date('Y-m-d', strtotime(' + '.$course->duration.' months'));
                SubscriptionHistory::where('id',$user->id)->update($dbArray);
            }
        }
        if($course->type == 'live'){
            if($user->type == 'monthly'){
                $dbArray = [];
                $dbArray['start_date'] = $course->start_date;
                $date = $course->start_date;
                $dbArray['end_date'] = date("Y-m-d", strtotime($date. ' + 1 months'));
                SubscriptionHistory::where('id',$user->id)->update($dbArray);
            }
            if($user->type == 'full'){
                $dbArray = [];
                $dbArray['start_date'] = $course->start_date;
                $dbArray['end_date'] = date('Y-m-d', strtotime(' + '.$course->duration.' months'));;
                SubscriptionHistory::where('id',$user->id)->update($dbArray); 
            }

        }
    }

    return response()->json([
        'result' => true,
        'message' => 'Succesfully',
    ],200);
        // return true;

}else{

    return response()->json([
        'result' => false,
        'message' => 'Not Succesfully',
    ],200);
        // return false;

}





    // return true;

}


public function add_wallet(Request $request)
{
    $validator = Validator::make($request->all(), [
        'token' => 'required',
        'amount' => 'required',

    ]);

    $user = null;

    if($validator->fails())
    {
        return response()->json([
            'result' => false,
            'message' => json_encode($validator->errors()),
        ],400);
    }

    $user  = JWTAuth::parseToken()->authenticate();
    if(empty($user))
    {
        return resposne()->json([
            'result' => false,
            'message' => '',
        ], 401);

    }

    $api_key = 'rzp_test_PrWbblwHjSxp2p';
    $api_secret = 'ecOIpaWurUy28fjgj3VxPWOw';
    $api = new Api($api_key, $api_secret);
    $amount = $request->amount;

    if($amount == 0)
    {
        return response()->json([
            'result' => false,
            'message' => 'Amount Not Available',
        ], 400);
    }



    $paymentDetails = [];
    $paymentDetails['currency'] = 'INR';
    $paymentDetails['amount'] = $amount * 100;
    $order = $api->order->create($paymentDetails);
    $orderId = $order['id'];

    $user_order = new Order;

    $user_order->user_id = $user->id;
    $user_order->order_id = $orderId;
    $user_order->amount = $amount;
    $user_order->save();

    return response()->json([
        'result' => true,
        'message' => 'Successfully',
        'paymentDetails' => $user_order,

    ], 200);

}

public function check_wallet(Request $request)
{

    $validator = Validator::make($request->all(), [
       'razorpay_order_id' => 'required',
       'razorpay_signature' => '',
       'razorpay_payment_id' => '',
   ]);

    if($validator->fails())
    {
        return response()->json([
            'result' => false,
            'message' => json_encode($validator->errors()),
        ],400);
    }

    $details = [];
    $details['razorpay_order_id'] = $request->razorpay_order_id;
    $details['razorpay_signature'] = $request->razorpay_signature;
    $details['razorpay_payment_id'] = $request->razorpay_payment_id;

    $details = $request->all();    
    $order_data = Order::where('order_id', $details['razorpay_order_id'])->first();
    $order_data->paid_status = 1;
    $order_data->txn_no = $details['razorpay_payment_id'];  

    $user_id = $order_data->user_id;
    $order_amt = $order_data->amount; 

    $api_key = 'rzp_test_PrWbblwHjSxp2p';
    $api_secret = 'ecOIpaWurUy28fjgj3VxPWOw';

    $api = new Api($api_key , $api_secret);
    try{

        $attibutes = array(
            'razorpay_order_id' => $details['razorpay_order_id'],
            'razorpay_payment_id' => $details['razorpay_payment_id'],
            'razorpay_signature' => $details['razorpay_signature']
        );

        $order = $api->utility->verifyPaymentSignature($attibutes); 
        $success = true;    

    }catch(SignatureVerificationError $e)
    {
        $success = false;
    }

    if($success)
    {
        $order_data->update(['paid_status' => $order_data->paid_status ,'txn_no' => $order_data->txn_no]);

        $user_Details = User::select('id','wallet')->where('id',$user_id)->first();
        $wallet_amt = $user_Details->wallet;
        
        $total_amt = $wallet_amt + $order_amt;
        
        $user_Details = User::where('id',$user_id)->update(['wallet'=> $total_amt ]);

        $transactionArry = [];

        $transactionArry['user_id'] = $user->user_id;
        $transactionArry['txn_no'] = $user->txn_no;
        $transactionArry['amount'] = $total_amt;
        $transactionArry['reason'] = 'add wallet';
        $transactionArry['type'] = 'credit';
        $transactionArry['status'] = 1;

        DB::table('transactions')->insert($transactionArry);
        
        return response()->json([
            'result' => true,
            'message' => 'Succesfully',
        ],200);           

    }else{

        return response()->json([
            'result' => false,
            'message' => 'Not Succesfully',
        ],200);          
    }
}


// public function check_payment_old(Request $request){
//     $data = $request->all();
//     $user = SubscriptionHistory::where('order_id', $data['razorpay_order_id'])->first();
//     $user->paid_status = true;
//     $user->txn_no = $data['razorpay_payment_id'];
//     $api = new Api('rzp_test_PrWbblwHjSxp2p', 'ecOIpaWurUy28fjgj3VxPWOw');
//     try{
//         $attributes = array(
//          'razorpay_signature' => $data['razorpay_signature'],
//          'razorpay_payment_id' => $data['razorpay_payment_id'],
//          'razorpay_order_id' => $data['razorpay_order_id']
//      );
//         $order = $api->utility->verifyPaymentSignature($attributes);
//         $success = true;
//     }catch(SignatureVerificationError $e){

//         $succes = false;
//     }


//     if($success){
//         $user->save();


//         $course = Course::where('id',$user->course_id)->first();


//         $transactionArr = [];
//         $transactionArr['user_id'] = $user->user_id;
//         $transactionArr['txn_no'] = $user->txn_no;
//         $transactionArr['reason'] = $course->course_name ?? '';
//         $transactionArr['amount'] = $user->amount;
//         $transactionArr['status'] = 1;


//         DB::table('transactions')->insert($transactionArr);

//         ///////Update paid Status

//         if(!empty($course)){
//             if($course->type == 'pre_recorded'){
//                 if($user->type == 'monthly'){
//                     $dbArray = [];
//                     $dbArray['start_date'] = date('Y-m-d');
//                     $dbArray['end_date'] = date('Y-m-d', strtotime(' + 1 months'));
//                     SubscriptionHistory::where('id',$user->id)->update($dbArray);
//                 }
//                 if($user->type == 'full'){
//                     $dbArray = [];
//                     $dbArray['start_date'] = date('Y-m-d');
//                     $dbArray['end_date'] = date('Y-m-d', strtotime(' + '.$course->duration.' months'));
//                     SubscriptionHistory::where('id',$user->id)->update($dbArray);
//                 }
//             }
//             if($course->type == 'live'){
//                 if($user->type == 'monthly'){
//                     $dbArray = [];
//                     $dbArray['start_date'] = $course->start_date;
//                     $dbArray['end_date'] = date("Y-m-d", strtotime("+1 month", $course->start_date));
//                     SubscriptionHistory::where('id',$user->id)->update($dbArray);
//                 }
//                 if($user->type == 'full'){
//                     $dbArray = [];
//                     $dbArray['start_date'] = $course->start_date;
//                     $dbArray['end_date'] = date('Y-m-d', strtotime(' + '.$course->duration.' months'));;
//                     SubscriptionHistory::where('id',$user->id)->update($dbArray); 
//                 }

//             }
//         }

//         // return response()->json([
//         //     'result' => true,
//         //     'message' => 'Succesfully',
//         // ],200);
//         return true;

//     }else{

//         // return response()->json([
//         //     'result' => false,
//         //     'message' => 'Not Succesfully',
//         // ],200);
//         return false;

//     }





//     // return true;

// }



public function check_subscription($user_id,$course_id){
    $exist = SubscriptionHistory::where('user_id',$user_id)->where('course_id',$course_id)->where('paid_status',1)->where('end_date','>=',date('Y-m-d'))->first();
    if(!empty($exist)){
        return true;
    }else{
        return false;
    }
}



public function subject_list(Request $request){
 $validator =  Validator::make($request->all(), [
    'token' => 'required',
    'course_id' => 'required',
]);

 $user = null;
 if ($validator->fails()) {
    return response()->json([
        'result' => false,
        'message' => json_encode($validator->errors()),

    ],400);
}
$user = JWTAuth::parseToken()->authenticate();
if (empty($user)){
    return response()->json([
        'result' => false,
        'message' => '',
    ],401);
}
$subjects = [];
$is_subscription = $this->check_subscription($user->id,$request->course_id);
if($is_subscription){
    $subjects = Subject::where('course_id',$request->course_id)->get();
    if(!empty($subjects)){
        foreach($subjects as $subject){
            $videos = Contents::where('subject_id',$subject->id)->where('hls_type','video')->count();
            $notes = Contents::where('subject_id',$subject->id)->where('hls_type','notes')->count();
            $subject->video_count = $videos;
            $subject->notes_count = $notes;
        }
    }
    return response()->json([
        'result' => true,
        'message' => 'Subject List',
        'subjects'=>$subjects,
    ],200);  
}else{
  return response()->json([
    'result' => false,
    'message' => 'You dont have any Subscription',
    'subjects'=>$subjects,
],200);  
}







}


public function chats(Request $request){
   $validator =  Validator::make($request->all(), [
    'token' => 'required',
]);
   $user = null;
   if ($validator->fails()) {
    return response()->json([
        'result' => false,
        'message' => json_encode($validator->errors()),

    ],400);
}
$user = JWTAuth::parseToken()->authenticate();
if (empty($user)){
    return response()->json([
        'result' => false,
        'message' => '',
    ],401);
}
$chats = [];

$chats = Chats::where('sender_id',$user->id)->orWhere('reciever_id',$user->id)->latest()->paginate(10);
if(!empty($chats)){
    foreach($chats as $chat)
    {
        $position = '';
        if($chat->sender_type == 'user' && $chat->reciever_type == 'admin'){
            $position = 'right';
            $user = User::where('id',$chat->sender_id)->first();
            $chat->user_name = $user->name ?? '';
            $chat->time = date('h:i A',strtotime($chat->created_at));
            $chat->day = date('D',strtotime($chat->created_at));

            if($chat->is_file == 1){
                $chat->text = $this->url.'api/public/images/chats/'.$chat->text;
            }

        }
        if($chat->sender_type == 'admin' && $chat->reciever_type == 'user'){
           $position = 'left';
            // $user = Admin::where('id',$chat->sender_id)->first();
           $chat->user_name = 'Admin';
           $chat->time = date('h:i A',strtotime($chat->created_at));
           $chat->day = date('D',strtotime($chat->created_at));
           if($chat->is_file == 1){
            $chat->text = $this->url.'api/public/images/chats/'.$chat->text;
        }

    }

    $chat->position = $position;

}
}
return response()->json([
    'result' => true,
    'message' => 'Chat List',
    'chats'=>$chats,
],200);

}

public function submit_chat(Request $request){
    $validator =  Validator::make($request->all(), [
        'token' => 'required',
        'text' => 'required',
    ]);
    $user = null;
    if ($validator->fails()) {
        return response()->json([
            'result' => false,
            'text' => json_encode($validator->errors()),

        ],400);
    }
    $user = JWTAuth::parseToken()->authenticate();
    if (empty($user)){
        return response()->json([
            'result' => false,
            'text' => '',
        ],401);
    }

    $dbArray = [];

    if($request->hasFile('text')){
        $file = $request->file('text');
        $destinationPath = public_path("/images/chats/");
        $side = $request->file('text');
        $side_name = $user->id.'_user_chats'.time().'.'.$side->getClientOriginalExtension();
        $side->move($destinationPath, $side_name);

        $dbArray['text'] = $side_name;
        $dbArray['is_file'] = 1;
        $dbArray['sender_id'] = $user->id;
        $dbArray['reciever_id'] = 0;
        $dbArray['sender_type'] = "user";
        $dbArray['reciever_type'] = "admin";
        $dbArray['file_type'] = $side->getClientOriginalExtension();

        Chats::create($dbArray);


    }else{

        $dbArray['sender_id'] = $user->id;
        $dbArray['reciever_id'] = 0;
        $dbArray['sender_type'] = "user";
        $dbArray['reciever_type'] = "admin";
        $dbArray['text'] = $request->text;

        Chats::create($dbArray);

    }






    return response()->json([
        'result' => true,
        'message' => 'Successfully',
    ],200);



}

public function contents(Request $request){
    $validator =  Validator::make($request->all(), [
        'token' => 'required',
        'subject_id' => 'required',
        'type' => 'required',
    ]);
    $user = null;
    if ($validator->fails()) {
        return response()->json([
            'result' => false,
            'text' => json_encode($validator->errors()),

        ],400);
    }
    $user = JWTAuth::parseToken()->authenticate();
    if (empty($user)){
        return response()->json([
            'result' => false,
            'text' => '',
        ],401);
    }
    $contents = [];

    $subject = Subject::where('id',$request->subject_id)->first();
    if(!empty($subject)){
        $is_sub = $this->check_subscription($user->id,$subject->course_id);
     //    if(!$is_sub){
     //     return response()->json([
     //        'result' => false,
     //        'message' => 'You dont Have Subscription',
     //        'contents' => $contents,
     //    ],200);  
     // }

        $hls_type = isset($request->type) ? $request->type :'video';

        $contents = Contents::where('subject_id',$subject->id)->where('hls_type',$hls_type)->paginate(10);
        if(!empty($contents)){
            foreach($contents as $content){

                if($content->hls_type == 'notes'){
                    $content->hls = $this->url.'/public/storage/contents/'.$content->hls;
                }



            }
        }


    }



    return response()->json([
        'result' => true,
        'message' => 'Successfully',
        'contents' => $contents,
    ],200);



}



public function live_classes(Request $request){

}

public function get_chats(Request  $request){
    $validator =  Validator::make($request->all(), [
        'token' => 'required',
    ]);
    $user = null;
    if ($validator->fails()) {
        return response()->json([
            'result' => false,
            'text' => json_encode($validator->errors()),

        ],400);
    }
    $user = JWTAuth::parseToken()->authenticate();
    if (empty($user)){
        return response()->json([
            'result' => false,
            'text' => '',
        ],401);
    }

    $chats = Chats::where(['is_give'=>0,'sender_id'=>0]);
//    $chats->orWhere('reciever_id',$user->id);
    $chats = $chats->latest()->get();

    $chatArr = [];

    if(!empty($chats)){
        foreach($chats as $chat) {
            if ($chat->is_give == 0) {


                $position = '';
                if ($chat->sender_type == 'user' && $chat->reciever_type == 'admin') {
                    $position = 'right';
                    $user = User::where('id', $chat->sender_id)->first();
                    $chat->user_name = $user->name ?? '';
                    $chat->time = date('h:i A', strtotime($chat->created_at));
                    $chat->day = date('D', strtotime($chat->created_at));

                    if ($chat->is_file == 1) {
                        $chat->text = $this->url . 'api/public/images/chats/' . $chat->text;
                    }

                }
                if ($chat->sender_type == 'admin' && $chat->reciever_type == 'user') {
                    $position = 'left';
                    // $user = Admin::where('id',$chat->sender_id)->first();
                    $chat->user_name = 'Admin';
                    $chat->time = date('h:i A', strtotime($chat->created_at));
                    $chat->day = date('D', strtotime($chat->created_at));
                    if ($chat->is_file == 1) {
                        $chat->text = $this->url . 'api/public/images/chats/' . $chat->text;
                    }

                }

                $chat->position = $position;

                $chatArr[] = $chat;
            }
        }
    }
    Chats::where('is_give',0)->where('sender_id',0)->update(['is_give'=>1]);






    return response()->json([
        'result' => true,
        'message' => 'Successfully',
        'chats' => $chatArr,
    ],200);

}


public function  send_message_to_user(Request $request){
    $validator =  Validator::make($request->all(), [
        'token' => 'required',
        'text' => 'required',
    ]);
    $user = null;
    if ($validator->fails()) {
        return response()->json([
            'result' => false,
            'message' => json_encode($validator->errors()),

        ],400);
    }
    $user = JWTAuth::parseToken()->authenticate();
    if (empty($user)){
        return response()->json([
            'result' => false,
            'message' => '',
        ],401);
    }
    $chats = [];

    $dbArray['sender_id'] = 0;
    $dbArray['reciever_id'] = 15;
    $dbArray['sender_type'] = "admin";
    $dbArray['reciever_type'] = "user";
    $dbArray['text'] = $request->text;

    Chats::create($dbArray);



    return response()->json([
        'result' => true,
        'message' => 'Chat List',
//        'chats'=>$chats,
    ],200);
}

public function faqs(Request $request)
{
  $validator =  Validator::make($request->all(), [
    'token' => 'required',
]);
  $user = null;
  if ($validator->fails()) {
    return response()->json([
        'result' => false,
        'text' => json_encode($validator->errors()),

    ],400);
}
$user = JWTAuth::parseToken()->authenticate();
if (empty($user)){
    return response()->json([
        'result' => false,
        'text' => '',
    ],401);
}

$faq_list = FAQs::select('id','questions','answer')->where('status',1)->get();

if(empty($faq_list))
{
    return repsonse()->json([
        'result' => false,
        'message' => 'No Question Found'

    ], 200);

}

return response()->json([
    'result' => true,
    'message' => 'Successfully',
    'faq_list' => $faq_list

],200);

}


public function dgl_form_submit(Request $request){
 $validator =  Validator::make($request->all(), [
    'token' => 'required',
    'name' => 'required',
    'email' => 'required',
    'gender' => 'required',
    'state' => 'required',
    'district' => 'required',
    'block' => 'required',
    'panchayat' => 'required',
    'pincode' => 'required',
]);
 $user = null;
 if ($validator->fails()) {
    return response()->json([
        'result' => false,
        'text' => json_encode($validator->errors()),

    ],400);
}
$user = JWTAuth::parseToken()->authenticate();
if (empty($user)){
    return response()->json([
        'result' => false,
        'text' => '',
    ],401);
}


return response()->json([
    'result' => true,
    'message' => 'Successfully',

],200);
}








}
