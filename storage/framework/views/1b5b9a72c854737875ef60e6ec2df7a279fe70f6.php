<?php echo $__env->make('admin.common.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php
$BackUrl = CustomHelper::BackUrl();
$ADMIN_ROUTE_NAME = CustomHelper::getAdminRouteName();
$routeName = CustomHelper::getAdminRouteName();
$storage = Storage::disk('public');
$path = 'category/';
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
              </ol>
          </div>
          <h4 class="page-title">Settings</h4>
      </div>
  </div>
</div>     
<?php echo $__env->make('snippets.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('snippets.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title">Settings</h4>

                <form action="" method="post" enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>



                    <div class="mb-3">
                        <label for="fullname" class="form-label">Refer Earn Amount</label>
                        <input type="text" name="refer_earn_amount" class="form-control" value="<?php echo e($settings->refer_earn_amount ?? ''); ?>" placeholder="Enter Refer Earn Amount">
                        <?php echo $__env->make('snippets.errors_first', ['param' => 'refer_earn_amount'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>

                    <div class="mb-3">
                        <label for="fullname" class="form-label">Contact Email</label>
                        <input type="text" name="contact_email" class="form-control" value="<?php echo e($settings->contact_email ?? ''); ?>" placeholder="Enter Contact Email">
                        <?php echo $__env->make('snippets.errors_first', ['param' => 'contact_email'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>

                    <div class="mb-3">
                        <label for="fullname" class="form-label">Contact Phone</label>
                        <input type="text" name="contact_phone" class="form-control" value="<?php echo e($settings->contact_phone ?? ''); ?>" placeholder="Enter Contact Phone">
                        <?php echo $__env->make('snippets.errors_first', ['param' => 'contact_phone'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>



                    <div class="mb-3">
                        <label for="fullname" class="form-label">Privacy</label>
                        <textarea class="form-control" id="privacy" name="privacypolicy"><?php echo e($settings->privacypolicy ?? ''); ?></textarea>
                        <?php echo $__env->make('snippets.errors_first', ['param' => 'privacypolicy'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>


                    <div class="mb-3">
                        <label for="userName">Terms & Condition<span class="text-danger">*</span></label>
                        <textarea class="form-control" id="terms" name="terms"><?php echo e($settings->terms ?? ''); ?></textarea>
                        <?php echo $__env->make('snippets.errors_first', ['param' => 'terms'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>


                    <div class="mb-3">
                      <label for="userName">About<span class="text-danger">*</span></label>
                      <textarea class="form-control" id="about" name="about_us"><?php echo e($settings->about_us ?? ''); ?></textarea>
                      <?php echo $__env->make('snippets.errors_first', ['param' => 'about_us'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  </div>



                  <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
              </form>

          </div> <!-- end card-body-->
      </div> <!-- end card-->
  </div>
  <!-- end col -->


</div>

</div>
</div>
</div>



<?php echo $__env->make('admin.common.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script>
   CKEDITOR.replace( 'privacy' );
   CKEDITOR.replace( 'terms' );
   CKEDITOR.replace( 'about' );





</script>


<script>

</script>

<?php /**PATH /home/appmantr/public_html/nayaeducation/resources/views/admin/home/settings.blade.php ENDPATH**/ ?>