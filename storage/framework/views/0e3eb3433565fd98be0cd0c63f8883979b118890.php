<?php echo $__env->make('admin.common.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php
$BackUrl = CustomHelper::BackUrl();
$routeName = CustomHelper::getAdminRouteName();


$storage = Storage::disk('public');
$path = 'live_class/';
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
                <a href="<?php echo e(route($routeName.'.live_class.add', ['back_url' => $BackUrl])); ?>" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Add Live Class</a>
              </ol>
            </div>
            <h4 class="page-title">Live Class</h4>
          </div>
        </div>
      </div>     
      <!-- end page title --> 
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h4 class="header-title">Live Class</h4>
              <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                <thead>
                  <tr>
                    <th>S.No.</th>
                    <th>Title</th>
                    <th>Image</th>

                    <th>Course Name</th>                 
                    <th>Faculty Name</th>
                    <th>Start Date & Time</th>  
                    <th>End Date & Time</th>  
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(!empty($live_classes)){

                    $i = 1;
                    foreach($live_classes as $live){
                      $course = \App\Course::where('id',$live->course_id)->first();
                      $faculty = \App\Admin::where('id',$live->faculty_id)->first();
                      $liveclass = 0;
                      $limeImg = url('public/storage/live_class/live.gif');
                      // if(date('Y-m-d') >= $live->start_date && date('Y-m-d') <= $live->end_date){

                      //   if(date('H:i:s') >=$live->start_time && date('H:i:s') <=$live->end_time){
                      //     $liveclass = 1;
                      //   }
                      // }

                      // if(date('Y-m-d') <= $live->end_date){
                      //   if(date('H:i:s') <=$live->end_time){
                      //     $liveclass = 1;
                      //   }
                      // }


                      ?>
                      <tr>
                        <td><?php echo e($i++); ?></td>
                        <td><?php echo e($live->title); ?>

                          <?php if($liveclass == 1){?>
                          <img src="<?php echo e($limeImg); ?>" height="40%" width="40%">
                        <?php }?>
                        </td>

                        <td>
                          <?php 
                          $image = $live->image;
                          if(!empty($image)){
                          if($storage->exists($path.$image)){
                          ?>
                          <div class=" image_box" style="display: inline-block">
                            <a href="<?php echo e(url('public/storage/'.$path.$image)); ?>" target="_blank">
                                <img src="<?php echo e(url('public/storage/'.$path.'thumb/'.$image)); ?>" style="width:70px;">
                            </a>
                            <br>
                        </div>
                        <?php }}?>
                        </td>

                        <td><?php echo e($course->course_name ?? ''); ?></td>
                        <td><?php echo e($faculty->name ?? ''); ?></td>
                        <td><?php echo e(date('d M Y',strtotime($live->start_date))); ?> <?php echo e(date('h:i A',strtotime($live->start_time))); ?></td>
                        <td><?php echo e(date('d M Y',strtotime($live->end_date))); ?> <?php echo e(date('h:i A',strtotime($live->end_time))); ?></td>


                        <td>
                          <select id='change_liveclass_status<?php echo e($live->id); ?>' onchange='change_liveclass_status(<?php echo e($live->id); ?>)' class="form-control">
                            <option value='1' <?php if($live->status ==1)echo "selected";?> >Active</option>
                            <option value='0' <?php if($live->status ==0)echo "selected";?>>InActive</option>
                          </select> 


                        </td>

                        <td>
                          <?php if($liveclass == 1){?>
                          <a class="btn btn-success" href="<?php echo e(route($routeName.'.live_class.edit', $live->id.'?back_url='.$BackUrl)); ?>"><i class="fa fa-television"></i></a>&nbsp;&nbsp;&nbsp;
                        <?php }?>

                          <a class="btn btn-success" href="<?php echo e(route($routeName.'.live_class.edit', $live->id.'?back_url='.$BackUrl)); ?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;

                          <a class="btn btn-danger" onclick="return confirm('Are You Want To Delete ??');" href="<?php echo e(route($routeName.'.live_class.delete', $live->id.'?back_url='.$BackUrl)); ?>"><i class="fa fa-trash"></i></a>


                        </td>
                      </tr>
                    <?php }}?>
                  </tbody>


                </table>

                <?php echo e($live_classes->appends(request()->input())->links('admin.pagination')); ?>


              </div> <!-- end card body-->
            </div> <!-- end card -->
          </div><!-- end col-->
        </div>


      </div>
    </div>
  </div>


  <?php echo $__env->make('admin.common.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <script>
    function change_liveclass_status(id){
      var status = $('#change_liveclass_status'+id).val();
      var _token = '<?php echo e(csrf_token()); ?>';
      $.ajax({
        url: "<?php echo e(route($routeName.'.live_class.change_liveclass_status')); ?>",
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
<?php /**PATH /home/appmantr/public_html/nayaeducation/resources/views/admin/live_classes/index.blade.php ENDPATH**/ ?>