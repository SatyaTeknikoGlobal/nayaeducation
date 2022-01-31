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
                 <a href="{{ route($routeName.'.banners.add', ['back_url' => $BackUrl]) }}" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Add Banner</a>
              </ol>
            </div>
            <h4 class="page-title">Banners</h4>
          </div>
        </div>
      </div>     
      <!-- end page title --> 
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h4 class="header-title">Banners</h4>
              <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                <thead>
                  <tr>
                    
                    <th>S.No.</th>
                    <th>Image</th>                                                 
                    <th>Course Name</th>  
                    <th>Link</th>                     
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(!empty($banners)){

                    $i = 1;
                    foreach($banners as $cat){
                      ?>
                      <tr>
                        <td>{{$i++}}</td>
                        <td>
                          
                            <?php

                               $image = isset($cat->image) ? $cat->image : '';
                                $storage = Storage::disk('public');
                                $path = 'banners';

                                if(!empty($image))
                                {
                            ?>

                                <a href="{{ url('public/storage/'.$path.'/'.$image) }}" target='_blank'><img src="{{ url('public/storage/'.$path.'/'.$image) }}" style='width:100px;heith:100px;'></a>


                          <?php } ?>

                        </td>

                        
                         <?php
                           $course =  App\Course::select('id','course_name')->where('id',$cat->course_id)->first();
                          ?>
                      
                        <td>{{$course->course_name}}</td>
                          <td>{{$cat->link}}</td>                       
                        <td>
                          <select id='change_banner_status{{$cat->id}}' onchange='change_banner_status({{$cat->id}})' class="form-control">
                            <option value='1' <?php if($cat->status ==1)echo "selected";?> >Active</option>
                            <option value='0' <?php if($cat->status ==0)echo "selected";?>>InActive</option>
                          </select> 


                        </td>

                        <td>
                         
                          <a class="btn btn-success" href="{{ route($routeName.'.banners.edit', $cat->id.'?back_url='.$BackUrl) }}"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;

                          <a class="btn btn-danger" onclick="return confirm('Are You Want To Delete ??');" href="{{ route($routeName.'.banners.delete', $cat->id.'?back_url='.$BackUrl) }}"><i class="fa fa-trash"></i></a>


                        </td>
                      </tr>
                    <?php }}?>
                  </tbody>


                </table>

                {{ $banners->appends(request()->input())->links('admin.pagination') }}

              </div> <!-- end card body-->
            </div> <!-- end card -->
          </div><!-- end col-->
        </div>


      </div>
    </div>
  </div>


  @include('admin.common.footer')

  <script>
   function change_banner_status(id){
  var status = $('#change_banner_status'+id).val();


   var _token = '{{ csrf_token() }}';

            $.ajax({
                url: "{{ route($routeName.'.banners.change_banner_status') }}",
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
