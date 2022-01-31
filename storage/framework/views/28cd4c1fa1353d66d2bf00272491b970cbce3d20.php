<?php echo $__env->make('admin.common.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php
$BackUrl = CustomHelper::BackUrl();
// $SADMIN_ROUTE_NAME = CustomHelper::getAdminRouteName();

$routeName = CustomHelper::getAdminRouteName();
$storage = Storage::disk('public');
$path = 'live_class/';

$live_class_id = isset($live_class->id) ? $live_class->id : '';
$title = isset($live_class->title) ? $live_class->title :'';
$course_id = isset($live_class->course_id) ? $live_class->course_id :'';
$faculty_id = isset($live_class->faculty_id) ? $live_class->faculty_id :'';
$start_date = isset($live_class->start_date) ? $live_class->start_date :'';
$start_time = isset($live_class->start_time) ? $live_class->start_time :'';
$end_date = isset($live_class->end_date) ? $live_class->end_date :'';
$end_time = isset($live_class->end_time) ? $live_class->end_time :'';
$image = isset($live_class->image) ? $live_class->image :'';
$channel_id = isset($live_class->channel_id) ? $live_class->channel_id :'';
$status = isset($live_class->status) ? $live_class->status :'1';


?>

<div class="content-page">
  <div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
      <div class="row">
          <div class="col-12">
              <div class="page-title-box">
                  <div class="page-title-right">
                      <ol class="breadcrumb m-0">
                         <?php if(request()->has('back_url')){ $back_url= request('back_url');  ?>
              <a href="<?php echo e(url($back_url)); ?>" class="btn btn-info btn-sm" style='float: right;'>Back</a><?php } ?>
                      </ol>
                  </div>
                  <h4 class="page-title"><?php echo e($page_Heading); ?></h4>
              </div>
          </div>
      </div>
      <!--  start page title -->

            <?php echo $__env->make('snippets.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('snippets.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h4 class="header-title"><?php echo e($page_Heading); ?></h4>

             <form class="card-body" action="" method="post" accept-chartset="UTF-8" enctype="multipart/form-data" role="form">

        <?php echo e(csrf_field()); ?>


              <input type="hidden" value="<?php echo e($live_class_id); ?>">

                <div class="mb-3">
                  <label for="fullname" class="form-label">Channel ID  * :</label>
                   <input class="form-control mb-3" type="text" name="channel_id" id="channel_id"  value="<?php echo e(old('channel_id',$channel_id)); ?>" placeholder="Channel Name" aria-label="default input example">

                </div>


                   <div class="mb-3">
                  <label for="fullname" class="form-label">Title  * :</label>
                   <input class="form-control mb-3" type="text" name="title" id="title"  value="<?php echo e(old('title',$title)); ?>" placeholder="Title" aria-label="default input example">

                </div>


                <div class="mb-3">
                  <label for="fullname" class="form-label">Course  * :</label>
                  <select class="form-control" name="course_id">
                   <?php if(!empty($courses)){
                    foreach($courses as $course){
                    ?>
                    <option value="<?php echo e($course->id); ?>" <?php if($course_id == $course->id) echo "selected"?>><?php echo e($course->course_name); ?></option>
                  <?php }}?>
                   </select>

                </div>


                <div class="mb-3">
                  <label for="fullname" class="form-label">Faculty  * :</label>
                  <select class="form-control" name="faculty_id">
                    <option value="" selected disabled>Select Faculty</option>
                   <?php if(!empty($faculties)){
                    foreach($faculties as $facul){
                    ?>
                    <option value="<?php echo e($facul->id); ?>" <?php if($faculty_id == $facul->id) echo "selected"?>><?php echo e($facul->name); ?></option>
                  <?php }}?>
                   </select>

                </div>


                <div class="mb-3">
                  <label for="fullname" class="form-label">Start Date  * :</label>
                   <input class="form-control mb-3" type="date" name="start_date" id="start_date"  value="<?php echo e(old('start_date',$start_date)); ?>" aria-label="default input example">

                </div>

                <div class="mb-3">
                  <label for="fullname" class="form-label">Start Time  * :</label>
                   <input class="form-control mb-3" type="time" name="start_time" id="start_time"  value="<?php echo e(old('start_time',$start_time)); ?>" aria-label="default input example">

                </div>


                <div class="mb-3">
                  <label for="fullname" class="form-label">End Date  * :</label>
                   <input class="form-control mb-3" type="date" name="end_date" id="end_date"  value="<?php echo e(old('end_date',$end_date)); ?>" aria-label="default input example">

                </div>

                <div class="mb-3">
                  <label for="fullname" class="form-label">End Time  * :</label>
                   <input class="form-control mb-3" type="time" name="end_time" id="end_time"  value="<?php echo e(old('end_time',$end_time)); ?>" aria-label="default input example">

                </div>


                <div class="mb-3">
                  <label for="fullname" class="form-label">Image  * :</label>
                   <input class="form-control mb-3" type="file" name="image" id="image"  value="<?php echo e(old('image',$image)); ?>" aria-label="default input example">
                   <?php 
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
                </div>

                 <div class="mb-3">
                                    <label for="fullname" class="form-label">Status</label>
                                    <br>
                                        Active: <input type="radio" name="status" value="1" <?php echo ($status == '1')?'checked':''; ?> >
                                        &nbsp;
                                        Inactive: <input type="radio" name="status" value="0" <?php echo ( strlen($status) > 0 && $status == '0')?'checked':''; ?> >

                                </div>
              

                <div>
                  <input type="submit" class="btn btn-success" value="Submit">
                </div>

              </form>
            </div>
          </div> <!-- end card-->
        </div> <!-- end col-->
      </div>

    </div>
  </div>
</div>

<?php echo $__env->make('admin.common.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php /**PATH /home/appmantr/public_html/nayaeducation/resources/views/admin/live_classes/form.blade.php ENDPATH**/ ?>