
@include('admin.common.header')

<?php
$BackUrl = CustomHelper::BackUrl();
 $routeName = CustomHelper::getAdminRouteName();


$storage = Storage::disk('public');
$path = 'influencer/thumb/';
// $roleId = Auth::guard('admin')->user()->role_id; 

?>

<div class="content-page">
  <div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

      <!-- start page title -->
      <div class="row">
        <div class="col-12">
          <div class="page-title-box">
            <div class="page-title-right">
              <ol class="breadcrumb m-0">
               <a href="{{ route($routeName.'.subject.add', ['back_url' => $BackUrl]) }}" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i>Add Subject</a>
              </ol>
            </div>
            <h4 class="page-title">Subjects</h4>
          </div>
        </div>
      </div>     
      <!-- end page title --> 
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h4 class="header-title">Subjects</h4>
              <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                <thead>
                  <tr>
                    
                   <th>S.No.</th>
                    <th>Image</th>
                     <th>Category</th>                   
                     <th>Course Name</th>
                      <th>Subject</th>                                       
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
              <?php

                if(!empty($subject))
                {
                  $storage = Storage::disk('public');
                  $path = 'subjects';
                   
                  foreach($subject as $b){

              ?>   

                <tr>
                  <td>{{$b->id}}</td>
                   <td>
                     
                  <?php

                      $html = '';

                  
                      $image = isset($b->image) ? $b->image :'';
                      if(!empty($image)){
                        if($storage->exists($path,$image))
                        {

                          $html.="<a target='_blank' href=' /storage/app/public/$path/$image'><img class='card-img-top' src='/storage/app/public/$path/$image' style='width:50px;height:50px'></a>"  ;

                          }else {

                            $html.="<a target='_blank' href='/storage/app/public/$path/$image'><img class='card-img-top' src='/storage/app/public/$path/default.png' style='width:50px;height:50px'></a>"  ;

                             }  } 

                      echo $html;
                 ?>          
                   </td>
                   <?
                        $category = App\Category::select('id','category_name')->where('id',$b->category_id)->first();
                        $course = App\Course::select('id','course_name')->where('id',$b->course_id)->first();


                    ?>
                  <td>{{$category->category_name ?? ''}}</td>           

                  <td>
                    {{$course->course_name ?? ''}}
                  </td>
                  <td>{{$b->subject_name}}</td>                 
                  <td>
                    <?php
                      if($b->status == 1){ ?>
                        Active

                   <?php   }else{  ?>
                    Inactive
                   
                   <?php } ?>

                  </td>                
                  <td>
                      <?php

                      $htmls = '';

                          $htmls.='<a title="Edit" class="btn btn-primary btn-sm" href="' . route($routeName.'.subject.edit',$b->id.'?back_url='.$BackUrl) . '"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;<a title="Delete" class="btn btn-danger btn-sm" href="' . route($routeName.'.subject.delete',$b->id.'?back_url='.$BackUrl) . '"><i class="fa fa-trash"></i></a>&nbsp;&nbsp;&nbsp;<a title="Content" class="btn btn-info btn-sm" href="' . route($routeName.'.subject.getcontent',$b->id.'?back_url='.$BackUrl) . '">Content</a>';
                        echo $htmls;

                      ?>    
                  </td>
                </tr> 

                <?php } } ?>
                  </tbody>


                </table>

                {{ $subject->appends(request()->input())->links('admin.pagination') }}

              </div> <!-- end card body-->
            </div> <!-- end card -->
          </div><!-- end col-->
        </div>


      </div>
    </div>
  </div>


  @include('admin.common.footer')

  <script>
   function change_course_status(id){
  var status = $('#change_course_status'+id).val();


   var _token = '{{ csrf_token() }}';

            $.ajax({
                url: "{{ route($routeName.'.courses.change_course_status') }}",
                type: "POST",
                data: {id:id, status:status},
                dataType:"JSON",
                headers:{'X-CSRF-TOKEN': _token},
                cache: false,
                success: function(resp){
                    if(resp.success){
                      alert(resp.message);
                    }else{
                      alert(resp.message);
                      
                    }
                }
            });


}



  </script>
