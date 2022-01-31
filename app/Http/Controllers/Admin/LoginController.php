<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Society;
use App\State;
use App\City;
use App\Helpers\CustomHelper;



class LoginController extends Controller{
    protected $redirectTo = '/';
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function index(Request $request){

        if (auth()->user()){
         return redirect('admin');
     }

     $method = $request->method();

     if($method == 'POST' || $method == 'post')
     {
           // prd($request->toArray());
        $rules = [];
        $rules['email'] = 'required';
        $rules['password'] = 'required';

        $dd = $this->validate($request, $rules);        

        $credentials = $request->only('email', 'password');

        $users = Admin::where('email',$request->email)->first();

        if(!empty($users)){
            if($users->status == 0){
                return back()->with('alert-danger', 'Your Account id Inactive, contact the administrator.');
            }if($users->status == 1){
                if($users->is_approve == 0){
                        return back()->with('alert-danger', 'Your Account is Not Approved');
                }else{
                    if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])){
                        $request->session()->regenerate();
                        
                        return redirect('admin');
                    }else{

                        
                        // return view('admin/login/index');
                        return back()->with('alert-danger', 'Invalid Username and Password');
                    }
                }
            }
        }
        



    }

    
    return view('admin/login/index');
}



public function register(Request $request){
     $data = [];



    // $data['societies'] = Society::where('status',1)->get();
    // $data['states'] = State::where('status',1)->get();
    // $data['cities'] = City::where('status',1)->get();



    $method = $request->method();

    if($method == 'POST' || $method == 'post'){

        // prd($request->toArray());

      
        $rules = [];
        $rules['email'] = 'required|unique:admins';
        $rules['password'] = 'required';      
        $rules['username'] = 'required|unique:admins';
        $rules['phone'] = 'required|unique:admins';
        
        $this->validate($request, $rules);     

        


        $dbArray = [];
       
        $dbArray['phone'] = $request->phone;
       
        $dbArray['password'] = bcrypt($request->password);
        $dbArray['email'] = $request->email;
       
        $dbArray['username'] = $request->username;
        $dbArray['status'] = 0;
        $dbArray['is_approve'] = 0;
        $success = Admin::create($dbArray);
        if($success){
            return view('snippets.pendingforvarification',$dbArray);
        }
    }

    return view('admin/register/index',$data);
}














public function logout(Request $request){


    // auth()->user('admin')->logout();
    Auth::logout();

    $request->session()->invalidate();

    return redirect('/admin/login');
}




public function forgot(Request $request){

        $data = [];

        $method = $request->method();

        if($method == 'POST'){

            $rules = [];

            $rules['email'] = 'required|email';

            $this->validate($request, $rules);

            $msg_type = 'danger';

            $message = 'Please check your email';

            $email = $request->email;

            $user = Admin::where('email', $email)->first();

            $forgot_token = generateToken(40);

            if($email){
                $email = $request->email;
                $to_email = $email;
                $subject = 'Reset password - NAYAEDUCATION';
                $ADMIN_EMAIL = config('custom.admin_email');
                $from_email = $ADMIN_EMAIL;
                $reset_link = '<a href="'.url('admin/reset?t='.$forgot_token).'">Click here to reset password</a>';

                $email_data = [];
                $email_data['reset_link'] = $reset_link;

                $is_mail = CustomHelper::sendEmail('emails.reset_password', $email_data, $to=$to_email, $from_email, $replyTo = $from_email, $subject);

                if($is_mail && !empty($user)){
                    $user->forgot_token = $forgot_token;
                    $user->save();
                    $msg_type = 'success';
                    $message = 'Reset password link has been sent to your email, please check.';
                }

                return redirect(url('admin/forgot-password'))->with('alert-'.$msg_type, $message);
            }
        }

        return view('admin.login.forgot', $data);
    }



public function reset(Request $request){

        $data = [];

        $isVerified = false;
        $isValidToken = false;

        $token = (isset($request->t))?$request->t:'';

        if(!empty($token)){

            $user = Admin::where('forgot_token', $token)->first();

            if(!empty($user)){

                $isValidToken = true;

                $method = $request->method();

                if($method == 'POST'){

                    $rules = [];

                    $rules['email'] = 'required|email';
                    $rules['password'] = 'required|min:6';
                    $rules['confirm_password'] = 'required|same:password';

                    $this->validate($request, $rules);

                    $msg_type = 'danger';

                    $message = 'Please check your email';

                    $email = $request->email;

                    $user = Admin::where('email', $email)->first();

                    $referer = (isset($user->referer))?$user->referer:'';

                    $forgot_token = generateToken(40);

                    if($user->email == $email){
                        $password = bcrypt($request->password);
                        $user->password = $password;
                        $user->forgot_token = '';
                        $isSaved = $user->save();
                        if($isSaved){
                            $msg_type = 'success';
                            $message = 'Your password has been updated successfully, please login.';
                        }

                        if(!empty($referer)){
                            return redirect(url('admin/login'))->with('alert-'.$msg_type, $message);
                        }

                        return redirect(url('admin/login'))->with('alert-'.$msg_type, $message);
                    }
                }
            }
        }

        $data['isVerified'] = $isVerified;
        $data['isValidToken'] = $isValidToken;


        return view('admin.login.reset', $data);
    }

















/*End of controller */
}