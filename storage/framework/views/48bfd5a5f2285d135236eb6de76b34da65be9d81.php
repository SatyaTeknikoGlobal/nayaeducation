<?php echo $__env->make('admin.common.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php
$BackUrl = CustomHelper::BackUrl();
// $SADMIN_ROUTE_NAME = CustomHelper::getAdminRouteName();

$routeName = CustomHelper::getAdminRouteName();
$storage = Storage::disk('public');
$path = 'influencer/';

$batch_id = isset($batches->id) ? $batches->id : '';
$course_id = isset($batches->course_id) ? $batches->course_id : '';
$category_id = isset($batches->category_id) ? $batches->category_id : '';
$subject_name = isset($batches->subject_name) ? $batches->subject_name : '';


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


                 <input type="hidden" value="<?php echo e($batch_id); ?>">

                  <div class="mb-3">
                  <label for="fullname" class="form-label">Category :</label>
                       <select id="category_id" name="category_id" class="form-control mb-3">
                    <option value="" selected disabled>Select Category</option>
                    <?php
                            if(!empty($category)){
                           foreach($category as $cat){ ?>
                <option value="<?php echo e($cat->id); ?>" <?php if($category_id == $cat->id) echo 'selected';?>><?php echo e($cat->category_name); ?></option>
                <?php } }?>
                   
                  </select>

                </div> 

                 <div class="mb-3">
                  <label for="fullname" class="form-label">Course</label>
                    <select name="course_id" id="course_id" class="form-control mb-3">
                        <option value="" selected disabled>Select Course</option>                  
                        <?php
                            if(!empty($course)){
                                foreach ($course as $cou){
                        ?>
                        <option value="<?php echo e($cou->id); ?>" <?php if($course_id == $cou->id) echo "selected";?>><?php echo e($cou->course_name); ?></option>
                        <?php }}?>
                   
                  </select>

                </div> 

                <div class="mb-3">
                  <label for="fullname" class="form-label">Subject</label>
                   <input class="form-control mb-3" type="text" name="subject_name" value="<?php echo e(old('subject_name',$subject_name)); ?>" id="subject_name" placeholder="Enter Subject" aria-label="default input example">

                </div>

               
                <div class="mb-3">
                  <label for="fullname" class="form-label">Upload Image</label>
                   <input class="form-control mb-3" type="file" name="image" value="" id="image" aria-label="default input example">

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

<script type="text/javascript">
    $(document).ready(function() {
       $('.ckeditor').ckeditor();
    });

    $('#category_id').on('change',function() {
        
        var _token = '<?php echo e(csrf_token()); ?>';
        var category_id = this.value;
        // alert("category_id = "+category_id);

        $.ajax({
          url: "<?php echo e(route($routeName.'.subject.get_courses')); ?>",
            type: "POST",
            data: {category_id:category_id},
            dataType:"HTML",
            headers:{'X-CSRF-TOKEN': _token},
            cache: false,
            success: function(resp){

               $('#course_id').html(resp);
           }
       });

    })




</script><?php /**PATH /home/appmantr/public_html/nayaeducation/resources/views/admin/subject/form.blade.php ENDPATH**/ ?>