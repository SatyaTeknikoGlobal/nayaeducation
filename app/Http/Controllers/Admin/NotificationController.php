<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\Controller;
use App\Helpers\CustomHelper;
use Auth;
use Validator;

use App\Admin;
use App\Course;
use App\User;

use App\Category;
use App\City;
use App\SubCategory;
use App\UserLogin;
use App\Notification;
use App\SubscriptionHistory;
use Yajra\DataTables\DataTables;


use Storage;
use DB;
use Hash;

use PhpOffice\PhpWord\IOFactory;




Class NotificationController extends Controller
{

    private $ADMIN_ROUTE_NAME;

    public function __construct()
    {
        $this->ADMIN_ROUTE_NAME = CustomHelper::getAdminRouteName();
    }

    public function index(Request $request){
      $data = [];
      $method = $request->method();
      if($method == 'post' || $method == 'POST'){
        $rules = [];
        $rules['text'] = 'required';
        $rules['title'] = 'required';
        $this->validate($request,$rules);

        $image = '';



        $file = $request->file('image');
        if(!empty($file)){
            $image = $this->saveImage($request);
        }
        $title = $request->title;
        $text = $request->text;

        if(!empty($request->course_id)){
            $user = SubscriptionHistory::select('user_id')->where('course_id',$request->course_id)->where('end_date','>=',date('Y-m-d'))->where('paid_status',1)->pluck('user_id')->toArray();

            $user_logins = UserLogin::whereIn('user_id',$user)->get();
            if(!empty($user_logins)){
                foreach ($user_logins as $key) {
                    $deviceToken = $key->deviceToken;
                    if(!empty($deviceToken)){
                        $title = $title;
                        $body = $text;
                        $imageUrl ='';
                        if(!empty($image)){
                            $imageUrl = url('public/storage/notification/'.$image);
                        }
                        $success = $this->send_notification($title, $body, $deviceToken,$imageUrl);
                        if($success){
                           $dbArray = [];
                           $dbArray['user_id'] = $key->user_id;
                           $dbArray['text'] = $request->text??'';
                           $dbArray['title'] = $request->title ?? '';
                           $dbArray['image'] = $imageUrl;
                           DB::table('notifications')->insert($dbArray);
                       }
                   }

               }
           }




       }else{
        $user = User::select('id')->where('status',1)->where('is_delete',0)->pluck('id')->toArray();

        $user_logins = UserLogin::whereIn('user_id',$user)->get();
        if(!empty($user_logins)){
            foreach ($user_logins as $key) {
                $deviceToken = $key->deviceToken;
                if(!empty($deviceToken)){
                    $title = $title;
                    $body = $text;
                    $imageUrl ='';
                    if(!empty($image)){
                        $imageUrl = url('public/storage/notification/'.$image);
                    }
                    $success = $this->send_notification($title, $body, $deviceToken,$imageUrl);
                    if($success){
                       $dbArray = [];
                       $dbArray['user_id'] = $key->user_id;
                       $dbArray['text'] = $request->text??'';
                       $dbArray['title'] = $request->title ?? '';
                       $dbArray['image'] = $imageUrl;
                       DB::table('notifications')->insert($dbArray);
                   }
               }

           }
       }

   }
}
    // $users = User::select('id','name')->where('status',1)->where('is_delete',0)->get();
$courses = Course::select('id','course_name')->where('status',1)->where('is_delete',0)->get();
    // $data['users'] = $users;
$data['courses'] = $courses;
return view('admin.notification.index',$data);
}




public function send_users(Request $request){
   $data = [];
   $method = $request->method();
   if($method == 'post' || $method == 'POST'){
    $rules = [];
    $rules['user_id'] = 'required';
    $rules['text1'] = 'required';
    $rules['title1'] = 'required';
    $this->validate($request,$rules);
    $image = '';
    $file = $request->file('image1');
    if(!empty($file)){
        $image = $this->saveImage1($request);
    }


    $user_logins = UserLogin::where('user_id',$request->user_id)->get();
    if(!empty($user_logins)){
        foreach ($user_logins as $key) {
            $deviceToken = $key->deviceToken;
            if(!empty($deviceToken)){
                $title = $request->title1;
                $body = $request->text1;
                $imageUrl ='';
                if(!empty($image)){
                    $imageUrl = url('public/storage/notification/'.$image);
                }
                $success = $this->send_notification($title, $body, $deviceToken,$imageUrl);
                if($success){
                   $dbArray = [];
                   $dbArray['user_id'] = $key->user_id;
                   $dbArray['text'] = $request->text1??'';
                   $dbArray['title'] = $request->title1 ?? '';
                   $dbArray['image'] = $imageUrl;
                   DB::table('notifications')->insert($dbArray);
                   return back()->with('alert-success', 'Notification Sent Successfully');  

               }
           }else{
              return back()->with('alert-danger', 'No Device Found');  

          }

      }
  }else{
    return back()->with('alert-danger', 'No Login Found');  


}
}


}

private function saveImage1($request){

    $file = $request->file('image1');

    //prd($file);
    if ($file) {
        $path = 'notification/';
        $thumb_path = 'notification/thumb/';
        $storage = Storage::disk('public');
            //prd($storage);
        $IMG_WIDTH = 768;
        $IMG_HEIGHT = 768;
        $THUMB_WIDTH = 336;
        $THUMB_HEIGHT = 336;
        $uploaded_data = CustomHelper::UploadImage($file, $path, $ext='', $IMG_WIDTH, $IMG_HEIGHT, $is_thumb=true, $thumb_path, $THUMB_WIDTH, $THUMB_HEIGHT);
        if($uploaded_data['success']){
            $image = $uploaded_data['file_name'];
            return $image;

        }

    }

}





private function saveImage($request){

    $file = $request->file('image');

    //prd($file);
    if ($file) {
        $path = 'notification/';
        $thumb_path = 'notification/thumb/';
        $storage = Storage::disk('public');
            //prd($storage);
        $IMG_WIDTH = 768;
        $IMG_HEIGHT = 768;
        $THUMB_WIDTH = 336;
        $THUMB_HEIGHT = 336;
        $uploaded_data = CustomHelper::UploadImage($file, $path, $ext='', $IMG_WIDTH, $IMG_HEIGHT, $is_thumb=true, $thumb_path, $THUMB_WIDTH, $THUMB_HEIGHT);
        if($uploaded_data['success']){
            $image = $uploaded_data['file_name'];
            return $image;

        }

    }

}





public function send_notification($title, $body, $deviceToken,$image){
    $sendData = array(
        'body' => !empty($body) ? $body : '',
        'title' => !empty($title) ? $title : '',
        'image' => !empty($image) ? $image : '',
        'sound' => 'Default'
    );

    return $this->fcmNotification($deviceToken,$sendData);
}

public function fcmNotification($device_id, $sendData)
{
        #API access key from Google API's Console
    if (!defined('API_ACCESS_KEY')){
        define('API_ACCESS_KEY', 'AAAA-ub9LE8:APA91bFxQB0OiVLwiAhK0YtrnVdAObaX5HG8nRxe-n88lrgK0Cqn-6cxmr9xsrfcSmW2beyq8mtyrbOqPzWEYGmhqFYC7ggl4e1ec-AeKE66MRFBvKvR0HGqY6ftSXRID89LOuBb64yd');
    }


    $fields = array
    (
        'to'    => $device_id,
        'data'  => $sendData,
        'notification'  => $sendData,
        // "click_action"=> "FLUTTER_NOTIFICATION_CLICK",
    );

    $headers = array
    (
        'Authorization: key=' . API_ACCESS_KEY,
        'Content-Type: application/json'
    );
        #Send Reponse To FireBase Server
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    $result = curl_exec($ch);
    if($result === false){
        die('Curl failed ' . curl_error($ch));
    }
    curl_close($ch);
    return $result;
}






}




