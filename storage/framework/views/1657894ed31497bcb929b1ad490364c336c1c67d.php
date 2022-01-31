<?php echo $__env->make('admin.common.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php
$BackUrl = CustomHelper::BackUrl();
// $SADMIN_ROUTE_NAME = CustomHelper::getAdminRouteName();

$routeName = CustomHelper::getAdminRouteName();

$course_id = isset($courses->id) ? $courses->id : '';
$category_id = isset($courses->category_id) ? $courses->category_id : '';
$course_name = isset($courses->course_name) ? $courses->course_name : '';
$course_description = isset($courses->course_description) ? $courses->course_description : '';
$image = isset($courses->image) ? $courses->image : '';

$type = isset($courses->type) ? $courses->type : '';
$start_date = isset($courses->start_date) ? $courses->start_date : '';
$duration = isset($courses->duration) ? $courses->duration : '';
$monthly_month = isset($courses->monthly_amount) ? $courses->monthly_amount : '';
$full_amount = isset($courses->full_amount) ? $courses->full_amount : '';
$syllabus = isset($courses->syllabus) ? $courses->syllabus : '';
$status = isset($courses->status) ? $courses->status : '1';

$storage = Storage::disk('public');

$path = 'courses/';


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


                 <input type="hidden" value="<?php echo e($course_id); ?>">

                  <div class="mb-3">
                  <label for="fullname" class="form-label">Category :</label>
                       <select id="category_id" name="category_id" class="form-control mb-3">
                    <option value="" selected disabled>Select Category</option>
                    <?php   if(!empty($category)){
                           foreach($category as $cat){ ?>
                    <option value="<?php echo e($cat->id); ?>" <?php if($category_id == $cat->id) echo "selected";?>><?php echo e($cat->category_name); ?></option>
                    <?php } }?>
                   
                  </select>

                </div> 

                <div class="mb-3">
                  <label for="fullname" class="form-label">Course Name</label>
                   <input class="form-control mb-3" type="text" name="course_name" id="course_name"  value="<?php echo e(old('course_name',$course_name)); ?>" placeholder="Course Name" aria-label="default input example">

                </div>

                <div class="mb-3">
                  <label for="email" class="form-label">Course Description</label>
                 <textarea class="form-control mb-3" name="course_description" id="course_description"  placeholder="Write Category Description .........." aria-label="default input example"><?php echo e(old('course_description',$course_description)); ?></textarea>
                </div>

                <div class="mb-3">
                  <label for="fullname" class="form-label">Upload Image</label>
                   <input class="form-control mb-3" type="file" name="image" id="image" aria-label="default input example">

                    <?php if(!empty($image)){
                    if($storage->exists($path.$image)){
                    ?>
                    <div class=" image_box" style="display: inline-block">
                        <a href="<?php echo e(url('public/storage/'.$path.$image)); ?>" target="_blank">
                            <img src="<?php echo e(url('public/storage/'.$path.'thumb/'.$image)); ?>" style="width:70px;">
                        </a>
                        <br>
                    </div>
                <?php } }?>




                </div>

                 <div class="mb-3">
                  <label for="fullname" class="form-label">Course Type:</label>
                       <select id="type" name="type" class="form-control mb-3">
                    <option value="" selected disabled>Select Type</option>
                     <option value="pre_recorded" <?php if($type == 'pre_recorded') echo "selected";?>>Pre Recorded</option>
                         <option value="live" <?php if($type == 'live') echo "selected";?>>Live</option>
                   
                  </select>

                </div>

                 <div class="mb-3">
                  <label for="fullname" class="form-label">Start Date</label>
                   <input class="form-control mb-3" type="date" name="start_date" value="<?php echo e(old('start_date', $start_date)); ?>" id="start_date" placeholder="Start Date" aria-label="default input example">

                </div>

                 <div class="mb-3">
                  <label for="fullname" class="form-label">Course Duration (in months)</label>
                   <input class="form-control mb-3" type="number" name="duration" id="duration" value="<?php echo e(old('duration',$duration)); ?>" placeholder="Course Duration" aria-label="default input example">

                </div>

                 <div class="mb-3">
                  <label for="fullname" class="form-label">Full Amount</label>
                   <input class="form-control mb-3" type="number" name="full_amount" value="<?php echo e(old('full_amount',$full_amount)); ?>" id="full_amount" placeholder="Enter Monthly Amount" aria-label="default input example">

                </div>

                 <div class="mb-3">
                  <label for="fullname" class="form-label">Monthly Amount</label>
                   <input class="form-control mb-3" type="number" name="monthly_amount" value="<?php echo e(old('monthly_month',$monthly_month)); ?>" id="monthly_amount" placeholder="Enter Monthly Amount" aria-label="default input example">

                </div>

                 <div class="mb-3">
                  <label for="fullname" class="form-label">Syllabus</label>
                   <textarea class="form-control mb-3" name="syllabus" id="description"  placeholder="Write Syllabus Description .........." aria-label="default input example"><?php echo e(old('syllabus',$syllabus)); ?></textarea>

                </div>
                  <div class="mb-3">
                                        <label>Status</label>
                                        <div>
                                         Active: <input type="radio" name="status" value="1" <?php echo ($status == '1')?'checked':''; ?> checked>
                                         &nbsp;
                                         Inactive: <input type="radio" name="status" value="0" <?php echo ( strlen($status) > 0 && $status == '0')?'checked':''; ?> >

                                         <?php echo $__env->make('snippets.errors_first', ['param' => 'status'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                     </div>
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

<?php /**PATH /home/appmantr/public_html/nayaeducation/resources/views/admin/courses/form.blade.php ENDPATH**/ ?>