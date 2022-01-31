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
use App\Course;
use App\Banner;

use App\Category;
use App\City;
use App\SubCategory;
use App\Blocks;
use App\Flats;
use Yajra\DataTables\DataTables;


use Storage;
use DB;
use Hash;

use PhpOffice\PhpWord\IOFactory;




Class BannerController extends Controller
{

    private $ADMIN_ROUTE_NAME;

    public function __construct()
    {
        $this->ADMIN_ROUTE_NAME = CustomHelper::getAdminRouteName();
    }

	public function index(Request $request)
    {
        $banners = Banner::where('is_delete',0)->paginate(10);
        $data['banners'] = $banners;
        return view('admin.banners.index',$data);
    }

    

    public function add(Request $request)
    {
         $details = [];
    
        $id = isset($request->id) ? $request->id : 0;

        $banners = '';

        if(is_numeric($id) && $id > 0)
        {

            $banners = Banner::find($id);

            if(empty($banners))
            {
                return redirect($this->ADMIN_ROUTE_NAME.'/banners');
            }
        }
       

        if($request->method() == "POST" || $request->method() == "post")
        {
            
            // prd($request->toArray());

            if(empty($back_url))
            {
                 $back_url = $this->ADMIN_ROUTE_NAME.'/banners';
            }


            if(is_numeric($request->id) && $request->id > 0)
            {                 
                 // $details['course_id'] = 'required';                
                $details['image'] = '';               
                // $details['link'] = 'required';  
              
            }else{

                // $details['course_id'] = 'required';                
                $details['image'] = 'required';               
                // $details['link'] = 'required';
            }

          $this->validate($request , $details); 

           $createdDetails = $this->save($request , $id);

           if($createdDetails)
           {
                $alert_msg = "Banner Created Successfully";

                if(is_numeric($id) & $id > 0)
                {
                    $alert_msg = "Banner Updated Successfully";
                } 
                return redirect(url($back_url))->with('alert-success',$alert_msg);
           }else{

            return back()->with('alert-danger', 'something went wrong, please try again or contact the administrator.');
           }

        }

        $page_Heading = "Add Banner";

        $course = Course::where('status',1)->get();
       //$id =  $banners->id;
        if(is_numeric($id) && $id > 0){
            $page_Heading = 'Update Banner';
        }

        $details['page_Heading'] = $page_Heading;
        //$details['id'] =$id; 
        $details['banners'] = $banners;      
         $details['course'] = $course;

       return view('admin.banners.form',$details);

    }


    public function save(Request $request, $id = 0)
    {
        $details = $request->except(['_token', 'back_url']);


        $old_img = '';

        $banners = new Banner;

        if(is_numeric($id) && $id > 0)
        {
            $exist = Banner::find($id);

            if(isset($exist->id) && $exist->id == $id)
            {   
                $banners = $exist;
                $old_img = $exist->image;
            }
        }

        foreach($details as $key => $val)
        {
            $banners->$key = $val;
        }

        $isSaved = $banners->save();

        if($isSaved)
        {
            $this->saveImage($request , $banners , $old_img);
        }

        return $isSaved;
    }

    private function saveImage($request, $banners, $oldImg=''){

    $file = $request->file('image');

    //prd($file);
    if ($file) {
        $path = 'banners/';        
        $storage = Storage::disk('public');
            //prd($storage);
        $IMG_WIDTH = 768;
        $IMG_HEIGHT = 768;
        $THUMB_WIDTH = 336;
        $THUMB_HEIGHT = 336;

        $uploaded_data = CustomHelper::UploadImage($file, $path, $ext='', $IMG_WIDTH, $IMG_HEIGHT, $is_thumb=true, $THUMB_WIDTH, $THUMB_HEIGHT);

            // prd($uploaded_data);
        if($uploaded_data['success']){

            if(!empty($oldImg)){
                if($storage->exists($path.$oldImg)){
                    $storage->delete($path.$oldImg);
                }
                if($storage->exists($thumb_path.$oldImg)){
                    $storage->delete($thumb_path.$oldImg);
                }
            }
            $image = $uploaded_data['file_name'];

           // prd($image);
            $banners->image = $image;
            $banners->save();         
        }

        if(!empty($uploaded_data)){   
            return  $uploaded_data;
        }  

    }

}

public function change_banner_status(Request $request){
  $id = isset($request->id) ? $request->id :'';
  $status = isset($request->status) ? $request->status :'';

  $faculties = Banner::where('id',$id)->first();
  if(!empty($faculties)){

   Banner::where('id',$id)->update(['status'=>$status]);
   $response['success'] = true;
   $response['message'] = 'Status updated';


   return response()->json($response);
}else{
   $response['success'] = false;
   $response['message'] = 'Not  Found';
   return response()->json($response);  
}

}

public function delete(Request $request)
{
     $id = isset($request->id) ? $request->id : 0;



     $is_delete = 0;

     if(empty($back_url))
    {
        $back_url = $this->ADMIN_ROUTE_NAME.'/banners';
    }

     if(is_numeric($id) && $id > 0)
     {
        //echo $id;
        $is_delete = Banner::where('id', $id)->update(['is_delete'=> '1']);
     }

     //die;

     if(!empty($is_delete))
     {
        return back()->with('alert-success', 'Banner Deleted Successfully');
     }else{

        return back()->with('alert-danger', 'something went wrong, please try again...');
     }
    
}

   
}




