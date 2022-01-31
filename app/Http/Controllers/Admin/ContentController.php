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
use App\Subject;
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




Class ContentController extends Controller
{

    private $ADMIN_ROUTE_NAME;

    public function __construct()
    {
        $this->ADMIN_ROUTE_NAME = CustomHelper::getAdminRouteName();
    }

	public function index(Request $request)
    {
		  $subject = Subject::where('is_delete',0)->paginate(5);
        $data['subject'] = $subject;
        return view('admin.content.index',$data);
    }

    // public function get_couses(Request $request)
    // {
    //     $routeName = CustomHelper::getadminRouteName();
        
    //     $datas = Course::where('is_delete','0')->orderBy('id','desc');

    //     $datas = $datas->get();

    //     return Datatables::of($datas)


    //         ->editColumn('id', function(Course $data) {
    //                     return  $data->id;

    //         })   

    //         ->editColumn('category_id', function(Course $data) {           

    //         $category_name = Category::select('id','category_name')->where('id',$data->category_id)->first();
    //         return $category_name->category_name;
    //     })


    //       ->editColumn('image', function(Course $data) {

    //         $html= '';

    //         $image = isset($data->image) ? $data->image : '';
    //         $storage = Storage::disk('public');
    //         $path = 'courses';

    //         if(!empty($image))
    //         {
    //             $html.= "<a href='/storage/app/public/$path/$image' target='_blank'><img src='/storage/app/public/$path/$image' ></a>";
    //         }else{

    //             $html.= "<a href='/storage/app/public/$path/default.png' target='_blank'><img src='/storage/app/public/$path/default.png' ></a>";
    //         }
    //         return $html;
    //     }) 


    //        ->editColumn('course_name', function(Course $data) {
    //         return  $data->course_name;
    //     })


    //     ->editColumn('course_description', function(Course $data) {
    //         return  $data->course_description;
    //     })            

       

    //      ->editColumn('type', function(Course $data) {
    //         return  $data->type;
    //     })

    //      ->editColumn('start_date', function(Course $data) {
    //         return  $data->start_date;
    //     })


    //        ->editColumn('duration', function(Course $data) {
    //         return  $data->duration;
    //     })


    //        ->editColumn('monthly_amount', function(Course $data) {
    //         return  $data->monthly_amount;
    //     })

           
    //        ->editColumn('full_amount', function(Course $data) {
    //         return  $data->full_amount;
    //     })


    //     ->editColumn('student_capacity', function(Course $data) {
    //         return  $data->student_capacity;
    //     })        

    //       ->editColumn('syllabus', function(Course $data) {
    //         return  $data->syllabus ;
    //     })      

       
    //     ->editColumn('status', function(Course $data) {
    //         $sta = '';
    //         $sta1 ='';
    //         if($data->status == 1){
    //             $sta1 = 'selected';
    //         }else{
    //             $sta = 'selected';
    //         }

    //         $html = "<select id='change_course_status$data->id' onchange='change_course_status($data->id)'>
    //         <option value='1' ".$sta1.">Active</option>
    //         <option value='0' ".$sta.">InActive</option>
    //         </select>";
            
    //         return  $html;
    //     })

     

    //     ->addColumn('action', function(Course $data) {
    //         $routeName = CustomHelper::getAdminRouteName();

    //         $BackUrl = $routeName.'/courses';
    //         $html = '';            

    //              if(CustomHelper::isAllowedSection('courses' , Auth::guard('admin')->user()->role_id , $type='edit')){
    //                 $html.='<a title="Edit" class="btn btn-primary btn-sm" href="' . route($routeName.'.courses.edit',$data->id.'?back_url='.$BackUrl) . '"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;';
    //             }


    //             if(CustomHelper::isAllowedSection('courses' , Auth::guard('admin')->user()->role_id , $type='delete')){
    //                  $html.='<a title="Delete" class="btn btn-danger btn-sm" href="' . route($routeName.'.courses.delete',$data->id.'?back_url='.$BackUrl) . '"><i class="fa fa-trash"></i></a>&nbsp;&nbsp;&nbsp;';

    //                 }


    //             return $html;
          
    //     })

    //     ->rawColumns(['category_name','course_name','course_description','image','type','start_date','duration','monthly_amount','full_amount','syllabus','status','action'])
    //     ->toJson();


    // }  

    public function add(Request $request)
    {
         $details = [];
    
        $id = isset($request->id) ? $request->id : 0;

        $batches = '';

        if(is_numeric($id) && $id > 0)
        {
            $batches = Subject::find($id);

            // prd($courses);
            if(empty($batches))
            {
                return redirect($this->ADMIN_ROUTE_NAME.'/subject');
            }
        }
       

        if($request->method() == "POST" || $request->method() == "post")
        {
            
           // prd($request->toArray());

            if(empty($back_url))
            {
                 $back_url = $this->ADMIN_ROUTE_NAME.'/subject';
            }


            if(is_numeric($request->id) && $request->id > 0)
            {
                 $details['category_id'] = 'required';
                 $details['course_id'] = 'required';                
                $details['image'] = '';   
                 $details['subject_name'] = 'required';              
              
              

            }else{

                  $details['category_id'] = 'required';
                 $details['course_id'] = 'required';                
                $details['image'] = '';   
                 $details['subject_name'] = 'required';   
            }

          $this->validate($request , $details); 

            // prd($dd);

           $createdDetails = $this->save($request , $id);

           if($createdDetails)
           {
                $alert_msg = "Subject Created Successfully";

                if(is_numeric($id) & $id > 0)
                {
                    $alert_msg = "Subject Updated Successfully";
                } 
                return redirect(url($back_url))->with('alert-success',$alert_msg);
           }else{

            return back()->with('alert-danger', 'something went wrong, please try again or contact the administrator.');
           }

        }

        $page_Heading = "Add Subject";
        if(isset($batches->id))
        {

            $batch_name = $batches->subject_name;
            $page_Heading = 'Update -'.$batch_name;

        }

        $category = Category::select('id','category_name')->where('status','1')->get();

        $details['page_Heading'] = $page_Heading;
        $details['id'] = $id;
        $details['category'] = $category;
        $details['batches'] = $batches;

       return view('admin.content.form',$details);

    }


    public function save(Request $request, $id = 0)
    {
        $details = $request->except(['_token', 'back_url']);


        $old_img = '';

        $batches = new Subject;

        if(is_numeric($id) && $id > 0)
        {
            $exist = Subject::find($id);

            if(isset($exist->id) && $exist->id == $id)
            {   
                $batches = $exist;

                $old_img = $exist->image;

            }

        }

        foreach($details as $key => $val)
        {
            $batches->$key = $val;
        }

        $isSaved = $batches->save();

        if($isSaved)
        {
            $this->saveImage($request , $batches , $old_img);
        }

        return $isSaved;
    }

    private function saveImage($request, $batches, $oldImg=''){

    $file = $request->file('image');

    //prd($file);
    if ($file) {
        $path = 'subjects/';
        $thumb_path = 'subjects/thumb/';
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
            $batches->image = $image;
            $batches->save();         
        }

        if(!empty($uploaded_data)){   
            return  $uploaded_data;
        }  

    }

}





  public function get_courses(Request $request)
  {
      // prd($request->toArray());  

       $category_id = $request->category_id;

       $html = '<option value="" selected disabled>Select Course</option>';

       if(!empty($category_id))
       {
         $course = Course::select('id','course_name')->where('category_id',$category_id)->get();

         if(!empty($course))
         {

          //  print_r($course);
            foreach($course as $c)
            {   
                
                $html.= '<option value='.$c->id.'>'.$c->course_name.'</option>';

            }

         }

       }
     
       
      echo $html;
         
      
  }


public function change_batch_status(Request $request){
  $id = isset($request->id) ? $request->id :'';
  $status = isset($request->status) ? $request->status :'';

  $batches = Batch::where('id',$id)->first();
  if(!empty($batches)){

   Batch::where('id',$id)->update(['status'=>$status]);
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
        $back_url = $this->ADMIN_ROUTE_NAME.'/subject';
    }

     if(is_numeric($id) && $id > 0)
     {
        //echo $id;
        $is_delete = Subject::where('id', $id)->update(['is_delete'=> '1']);
     }

     //die;

     if(!empty($is_delete))
     {
        return back()->with('alert-success', 'Subject Deleted Successfully');
     }else{

        return back()->with('alert-danger', 'something went wrong, please try again...');
     }
    
}


public function getcontent(Request $request)
{
     $content = Content::where('is_delete',0)->paginate(5);
        $data['content'] = $content;
        return view('admin.content.index',$data);

}

public function addcontent(Request $request,$id)
{
     $details = [];

    $id = isset($request->id) ? $request->id : 0;

    $contents = '';

    // if(is_numeric($id) && $id > 0)
    // {
    //     $contents = Content::find($id);

    //     // prd($courses);
    //     if(empty($batches))
    //     {
    //         return redirect($this->ADMIN_ROUTE_NAME.'/subject');
    //     }
    // }
   

    if($request->method() == "POST" || $request->method() == "post")
    {
        
        prd($request->toArray());

        if(empty($back_url))
        {
             $back_url = $this->ADMIN_ROUTE_NAME.'/subject';
        }


        if(is_numeric($request->id) && $request->id > 0)
        {
             $details['category_id'] = 'required';
             $details['course_id'] = 'required';                
            $details['image'] = '';   
             $details['subject_name'] = 'required';              
          
          

        }else{

              $details['category_id'] = 'required';
             $details['course_id'] = 'required';                
            $details['image'] = '';   
             $details['subject_name'] = 'required';   
        }

      $this->validate($request , $details); 

        // prd($dd);

       $createdDetails = $this->save($request , $id);

       if($createdDetails)
       {
            $alert_msg = "Subject Created Successfully";

            if(is_numeric($id) & $id > 0)
            {
                $alert_msg = "Subject Updated Successfully";
            } 
            return redirect(url($back_url))->with('alert-success',$alert_msg);
       }else{

        return back()->with('alert-danger', 'something went wrong, please try again or contact the administrator.');
       }

    }

    $page_Heading = "Add Subject";
    if(isset($batches->id))
    {

        $batch_name = $batches->subject_name;
        $page_Heading = 'Update -'.$batch_name;

    }

        $category = Category::select('id','category_name')->where('status','1')->get();

        $details['page_Heading'] = $page_Heading;
        $details['id'] = $id;
        $details['category'] = $category;
        $details['batches'] = $batches;

       return view('admin.content.form',$details);

    }


   
}




