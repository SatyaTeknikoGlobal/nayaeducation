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




Class CourseController extends Controller
{

    private $ADMIN_ROUTE_NAME;

    public function __construct()
    {
        $this->ADMIN_ROUTE_NAME = CustomHelper::getAdminRouteName();
    }

	public function index(Request $request)
    {
        $courses = Course::where('is_delete','0')->orderBy('id','desc')->paginate(10);
        $data['courses'] = $courses;
        return view('admin.courses.index',$data);
    }

    

    public function add(Request $request)
    {
         $details = [];
    
        $id = isset($request->id) ? $request->id : 0;

        $courses = '';

        if(is_numeric($id) && $id > 0)
        {
            $courses = Course::find($id);

            // prd($courses);
            if(empty($courses))
            {
                return redirect($this->ADMIN_ROUTE_NAME.'/courses');
            }
        }
       

        if($request->method() == "POST" || $request->method() == "post")
        {
            
           // prd($request->toArray());

            if(empty($back_url))
            {
                 $back_url = $this->ADMIN_ROUTE_NAME.'/courses';
            }


            if(is_numeric($request->id) && $request->id > 0)
            {
                 $details['category_id'] = 'required';
                 $details['course_name'] = 'required';
                $details['course_description'] = 'required';
                $details['image'] = '';               
                $details['type'] = 'required';
                 $details['start_date'] = 'required';
                $details['duration'] = 'required';                
                $details['monthly_amount'] = 'required';
                $details['full_amount'] = '';            
                $details['syllabus'] = 'required';
              

            }else{

                $details['category_id'] = 'required';
                 $details['course_name'] = 'required';
                $details['course_description'] = 'required';
                $details['image'] = '';               
                $details['type'] = 'required';
                 $details['start_date'] = 'required';
                $details['duration'] = 'required';                
                $details['monthly_amount'] = 'required';
                $details['full_amount'] = '';            
                $details['syllabus'] = 'required';
            }

          $this->validate($request , $details); 

          // prd($dd);

           $createdDetails = $this->save($request , $id);

           if($createdDetails)
           {
                $alert_msg = "Course Created Successfully";

                if(is_numeric($id) & $id > 0)
                {
                    $alert_msg = "Course Updated Successfully";
                } 
                return redirect(url($back_url))->with('alert-success',$alert_msg);
           }else{

            return back()->with('alert-danger', 'something went wrong, please try again or contact the administrator.');
           }

        }

        $page_Heading = "Add Course";
        if(isset($courses->id))
        {

            $course_name = $courses->course_name;
            $page_Heading = 'Update -'.$course_name;

        }

        $category = Category::select('id','category_name')->where('status','1')->get();

        $details['page_Heading'] = $page_Heading;
        $details['id'] = $id;
        $details['category'] = $category;
        $details['courses'] = $courses;

       return view('admin.courses.form',$details);

    }


    public function save(Request $request, $id = 0)
    {
        $details = $request->except(['_token', 'back_url']);


        $old_img = '';

        $courses = new Course;

        if(is_numeric($id) && $id > 0)
        {
            $exist = Course::find($id);

            if(isset($exist->id) && $exist->id == $id)
            {   
                $courses = $exist;

                $old_img = $exist->image;

            }

        }

        foreach($details as $key => $val)
        {
            $courses->$key = $val;
        }

        $isSaved = $courses->save();

        if($isSaved)
        {
            $this->saveImage($request , $courses , $old_img);
        }

        return $isSaved;
    }

    private function saveImage($request, $courses, $oldImg=''){

    $file = $request->file('image');

    //prd($file);
    if ($file) {
        $path = 'courses/';
        $thumb_path = 'courses/thumb/';
        $storage = Storage::disk('public');
            //prd($storage);
        $IMG_WIDTH = 768;
        $IMG_HEIGHT = 768;
        $THUMB_WIDTH = 336;
        $THUMB_HEIGHT = 336;

        $uploaded_data = CustomHelper::UploadImage($file, $path, $ext='', $IMG_WIDTH, $IMG_HEIGHT, $is_thumb=true, $thumb_path, $THUMB_WIDTH, $THUMB_HEIGHT);

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
            $courses->image = $image;
            $courses->save();         
        }

        if(!empty($uploaded_data)){   
            return  $uploaded_data;
        }  

    }

}

public function change_course_status(Request $request){
  $id = isset($request->id) ? $request->id :'';
  $status = isset($request->status) ? $request->status :'';

  $faculties = Course::where('id',$id)->first();
  if(!empty($faculties)){

   Course::where('id',$id)->update(['status'=>$status]);
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
        $back_url = $this->ADMIN_ROUTE_NAME.'/courses';
    }

     if(is_numeric($id) && $id > 0)
     {
        //echo $id;
        $is_delete = Course::where('id', $id)->update(['is_delete'=> '1']);
     }

     //die;

     if(!empty($is_delete))
     {
        return back()->with('alert-success', 'Course Deleted Successfully');
     }else{

        return back()->with('alert-danger', 'something went wrong, please try again...');
     }
    
}

   
}




