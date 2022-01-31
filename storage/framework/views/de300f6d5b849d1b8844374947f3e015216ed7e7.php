<?php echo $__env->make('admin.common.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php
$BackUrl = CustomHelper::BackUrl();
// $SADMIN_ROUTE_NAME = CustomHelper::getAdminRouteName();

$routeName = CustomHelper::getAdminRouteName();
$storage = Storage::disk('public');
$path = 'banners/';

 $banner_id = isset($banners->id) ? $banners->id : '';

 $image = isset($banners->image) ? $banners->image : '';
 $category_id = isset($banners->category_id) ? $banners->category_id : '';
 $course_id = isset($banners->course_id) ? $banners->course_id : '';
 $link = isset($banners->link) ? $banners->link : '';
 $status = isset($banners->status) ? $banners->status : '';

 //print_r($banners);


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


                 <input type="hidden" id="id" value="<?php echo e($banner_id); ?>">


                <div class="mb-3">
                  <label for="fullname" class="form-label">Course Name</label>
                   <select id="course_id" name="course_id" class="form-control mb-3">
                    <option value="" selected disabled>Select Course</option>
                    <?php
                        if(!empty($course)){
                       foreach($course as $cat){ ?>
                    <option value="<?php echo e($cat->id); ?>" <?php if($category_id == $cat->id) echo "selected";?>><?php echo e($cat->course_name); ?></option>
                    <?php } }?>
                   
                  </select>

                </div>

                <div class="mb-3">
                  <label for="email" class="form-label">Link</label>
                <input type="text" class="form-control mb-3" name="link" id="link" placeholder="Enter Link" value="<?php echo e(old('link',$link)); ?>">
                </div>

                <div class="mb-3">
                  <label for="fullname" class="form-label">Upload Image</label>
                   <input class="form-control mb-3" type="file" name="image" id="image" aria-label="default input example">

                    <?php
                        if(!empty($image)){
                            if($storage->exists($path.$image)){ ?>
                    <div class=" image_box" style="display: inline-block">
                        <a href="<?php echo e(url('public/storage/'.$path.$image)); ?>" target="_blank">
                            <img src="<?php echo e(url('public/storage/'.$path.$image)); ?>" style="width:70px;">
                        </a>


                    </div>
                           <?php  }
                        }
                    ?>


                </div>


                <div class="form-group">
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

<?php /**PATH /home/appmantr/public_html/nayaeducation/resources/views/admin/banners/form.blade.php ENDPATH**/ ?>