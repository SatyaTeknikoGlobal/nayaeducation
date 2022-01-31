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
use App\User;
use App\Admin;


use App\Category;
use App\City;
use App\SubCategory;
use App\SubscriptionHistory;

use App\Course;
use App\Permission;



use Storage;
use DB;
use Hash;

use PhpOffice\PhpWord\IOFactory;




Class HomeController extends Controller
{

	public function index(Request $request){
		$data = [];
        $data['users'] = User::select('id')->count();
        $data['courses'] = Course::select('id')->where('is_delete',0)->count();
        $data['faculty'] = Admin::select('id')->where('role_id',1)->where('is_delete',0)->count();
        $data['sub_user'] = SubscriptionHistory::select('id')->where('paid_status',1)->where('end_date','>=',date('Y-m-d'))->count();

        return view('admin.home.index',$data);
    }

    public function profile(Request $request)
    {
        // echo $request->method();

      $data = [];
      $method = $request->method();
      $user = Auth::guard('admin')->user();

      if($method == 'post' || $method == 'POST')
      {

       // prd($request->toArray());


       $request->validate([
        'email' => 'required',        
        'phone' => 'required',
        'username' => 'required',
        'education' => 'required',
        'total_exp' => 'required',
        'speciality' => 'required',
        'about' => 'required',
        'image' => '',
    ]);

       $name = isset($request->name) ? $request->name : '';
       $email = isset($request->email) ? $request->email : '';      
       $phone = isset($request->phone) ? $request->phone : '';
       $username = isset($request->username) ? $request->username : '';
       $education = isset($request->education) ? $request->education : '';
       $total_exp = isset($request->total_exp) ? $request->total_exp : '';
       $speciality = isset($request->speciality) ? $request->speciality : '';
       $about = isset($request->about) ? $request->about : '';
       $image = isset($request->image) ? $request->image : '';

       if(!empty($request->name)){
           $dbArray['name'] = $request->name; 
       }
       if(!empty($request->email)){
           $dbArray['email'] = $request->email; 
       }
       if(!empty($request->phone)){
           $dbArray['phone'] = $request->phone; 
       }
       if(!empty($request->username)){
           $dbArray['username'] = $request->username; 
       }
       if(!empty($request->education)){
           $dbArray['education'] = $request->education; 
       }
       if(!empty($request->total_exp)){
           $dbArray['total_exp'] = $request->total_exp; 
       }
       if(!empty($request->speciality)){
           $dbArray['speciality'] = $request->speciality; 
       }
       if(!empty($request->about)){
           $dbArray['about'] = $request->about; 
       }
       $result = Admin::where('id',$user->id)->update($dbArray);
       if($result){

           if($request->hasFile('image')) {
            $file = $request->file('image');
            $image_result = $this->saveImage($file,$user->id);
            if($image_result['success'] == false){     
                session()->flash('alert-danger', 'Image could not be added');
            }
        }


        return back()->with('alert-success','Profile Updated Successfully');
    }else{
        return back()->with('alert-danger','Something Went Wrong');

    }
}

$data['breadcum'] = 'Update Profile';
$data['title'] = 'Update Profile';
$data['user'] = $user;
return view('admin.profile.index',$data);
}


public function get_sub_cat(Request $request){
  $cat_id = isset($request->cat_id) ? $request->cat_id : '';
  $html = '<option value="" selected disabled>Select Sub Category</option>';
  if(!empty($cat_id)){
    $subcategories = SubCategory::where('cat_id',$cat_id)->get();
    if(!empty($subcategories)){
        foreach($subcategories as $sub_cat){
            $html.='<option value='.$sub_cat->id.' >'.$sub_cat->name.'</option>';
        }
    }
}


echo $html;

}



public function permission(Request $request){
    $data = [];
    $method = $request->method();
    $user = Auth::guard('admin')->user();
    if($user->role_id !=0){
     return redirect('admin');
 }
 if($method == 'post' || $method == 'POST'){

 }


 $sectionArr = config('modules.allowedwithval');

 $data['sectionArr'] = $sectionArr;

 return view('admin.profile.permission',$data);

}


public function update_permission(Request $request){
    $key = isset($request->key) ? $request->key :'';
    $section = isset($request->section) ? $request->section :'';
    $permission = isset($request->permission) ? $request->permission :'';
    $role_id = 1;
    $dbArray = [];
    $exist = Permission::where(['role_id'=>$role_id,'section'=>$key])->first();
    if(!empty($exist)){
        $dbArray[$section] = $permission;
        Permission::where('id',$exist->id)->update($dbArray);
    }else{
        $dbArray['role_id'] = $role_id;
        $dbArray['section'] = $key;
        $dbArray[$section] = $permission;
        Permission::insert($dbArray);
    }


}






private function saveImage($file, $id){
        // prd($file); 
        //echo $type; die;

    // $result['org_name'] = '';
    // $result['file_name'] = '';

    if ($file) 
    {
        $path = 'user/';
        $thumb_path = 'user/thumb/';
        $IMG_WIDTH = 768;
        $IMG_HEIGHT = 768;
        $THUMB_WIDTH = 336;
        $THUMB_HEIGHT = 336;

        $uploaded_data = CustomHelper::UploadImage($file, $path, $ext='', $IMG_WIDTH, $IMG_HEIGHT, $is_thumb=true, $thumb_path, $THUMB_WIDTH, $THUMB_HEIGHT);
        if($uploaded_data['success']){
            $new_image = $uploaded_data['file_name'];

           // prd($uploaded_data['file_name']);

            if(is_numeric($id) && $id > 0){
                $user = Admin::where('id',$id)->first();
                if(!empty($user)){
                    $storage = Storage::disk('public');
                    $old_image = $user->image;
                    $isUpdated = Admin::where('id',$id)->update(['image'=>$new_image]);
                    if($isUpdated){
                        if(!empty($old_image) && $storage->exists($path.$old_image)){
                            $storage->delete($path.$old_image);
                        }

                        if(!empty($old_image) && $storage->exists($thumb_path.$old_image)){
                            $storage->delete($thumb_path.$old_image);
                        }
                    }
                }


            }
        }

        if(!empty($uploaded_data))
        {   
            return $uploaded_data;
        }
    }
}


public function setting(Request $request){
    $data =[];  

    $method = $request->method();

    if($method == 'POST' || $method =="post"){

        $dbArray = [];

        $dbArray['refer_earn_amount'] = isset($request->refer_earn_amount) ? $request->refer_earn_amount:'';
        $dbArray['about_us'] = isset($request->about_us) ? $request->about_us:'';
        $dbArray['privacypolicy'] = isset($request->privacypolicy) ? $request->privacypolicy:'';
        $dbArray['contact_email'] = isset($request->contact_email) ? $request->contact_email:'';
        $dbArray['contact_phone'] = isset($request->contact_phone) ? $request->contact_phone:'';
        $dbArray['contactus'] = isset($request->contactus) ? $request->contactus:'';
        $dbArray['terms'] = isset($request->terms) ? $request->terms:'';

        DB::table('settings')->where('id',1)->update($dbArray);
        $data['settings'] = DB::table('settings')->where('id',1)->first();
        return back()->with('alert-success','Updated Successfully');
    }

    $data['settings'] = DB::table('settings')->where('id',1)->first();

    return view('admin.home.settings',$data);

}















public function change_password(Request $request){
    //prd($request->toArray());
    $data = [];
    $password = isset($request->password) ?  $request->password:'';
    $new_password = isset($request->new_password) ?  $request->new_password:'';
    $method = $request->method();

        //prd($method);
    $auth_user = Auth::guard('admin')->user();
    $admin_id = $auth_user->id;
    if($method == 'POST' || $method =="post"){
        $post_data = $request->all();
        $rules = [];

        $rules['old_password'] = 'required|min:6|max:20';
        $rules['new_password'] = 'required|min:6|max:20';
        $rules['confirm_password'] = 'required|min:6|max:20|same:new_password';

        $validator = Validator::make($post_data, $rules);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        else{
                //prd($request->all());

            $old_password = $post_data['old_password'];

            $user = Admin::where(['id'=>$admin_id])->first();

            $existing_password = (isset($user->password))?$user->password:'';

            $hash_chack = Hash::check($old_password, $user->password);

            if($hash_chack){
                $update_data['password']=bcrypt(trim($post_data['new_password']));

                $is_updated = Admin::where('id', $admin_id)->update($update_data);

                $message = [];

                if($is_updated){

                    $message['alert-success'] = "Password updated successfully.";
                }
                else{
                    $message['alert-danger'] = "something went wrong, please try again later...";
                }

                return back()->with($message);


            }
            else{
                $validator = Validator::make($post_data, []);
                $validator->after(function ($validator) {
                    $validator->errors()->add('old_password', 'Invalid Password!');
                });
                    //prd($validator->errors());
                return back()->withErrors($validator)->withInput();
            }
        }
    }



}

// public function profile(Request $request){
//     $data = [];


//     return view('admin.home.profile',$data);
// }

public function upload(Request $request){
   $data = [];
   $method = $request->method();
   $user = Auth::guard('admin')->user();

   if($method == 'post' || $method == 'POST'){
       $request->validate([
        'file' => 'required',
    ]);

       if($request->hasFile('file')) {
        $file = $request->file('file');
        $image_result = $this->saveImage($file,$user->id,'file');
        if($image_result['success'] == false){     
            session()->flash('alert-danger', 'Image could not be added');
        }
    }
    return back()->with('alert-success','Profile Updated Successfully');
}
}






public function get_city(Request $request){
    $state_id = isset($request->state_id) ? $request->state_id :0;
    $html = '<option value="" selected disabled>Select City</option>';
    if($state_id !=0){
        $cities = City::where('state_id',$state_id)->get();
        if(!empty($cities)){
            foreach($cities as $city){
                $html.='<option value='.$city->id.'>'.$city->name.'</option>';
            }
        }
    } 
    echo $html;
}



public function cmsPage(Request $request){
    $data = [];

    return view('admin.home.cmspage',$data);
}


public function get_blocks(Request $request){
   $society_id = isset($request->society_id) ? $request->society_id :0;
   $html = '<option value="0" selected="" disabled >Select Society</option>';
   if($society_id !=0){
    $blocks = Blocks::where('society_id',$society_id)->get();
    if(!empty($blocks)){
        foreach($blocks as $block){
            $html.='<option value='.$block->id.'>'.$block->name.'</option>';
        }
    }
} 
echo $html;


}


public function get_flats(Request $request){
   $block_id = isset($request->block_id) ? $request->block_id :0;
   $html = '<option value="0" selected="" disabled >Select Flats</option>';
   if($block_id !=0){
    $flats = Flats::where('block_id',$block_id)->get();
    if(!empty($flats)){
        foreach($flats as $flat){
            $html.='<option value='.$flat->id.'>'.$flat->flat_no.'</option>';
        }
    }
} 
echo $html;


}



public function upload_xls(Request $request){
    $method = $request->method();
    $data = [];
    $html= '';
    if($method =='post' || $method == 'POST'){
     $phpWord = IOFactory::createReader('Word2007')->load($request->file('file')->path());
     $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
     $objWriter->save('doc.html');
     $page = file_get_contents('https://mydoor.appmantra.live/doc.html');



     DB::table('new')->insert(['text'=>$page]);
     echo $page;
     die;

     foreach($phpWord->getSections() as $section) {
        foreach($section->getElements() as $element) {
            if(method_exists($element,'getText')) {
                $html.=$element->getText();
            }
        }
    }
}

$data['html'] = $html;

return view('admin.home.upload_file',$data);


}





}