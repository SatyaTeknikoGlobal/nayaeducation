<?php echo $__env->make('admin.common.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php
$BackUrl = CustomHelper::BackUrl();
// $SADMIN_ROUTE_NAME = CustomHelper::getAdminRouteName();

$routeName = CustomHelper::getAdminRouteName();
$storage = Storage::disk('public');
$path = 'influencer/';

$category_id = isset($categories->id) ? $categories->id : '';
$category_name = isset($categories->category_name) ? $categories->category_name : '';
$category_description = isset($categories->category_description) ? $categories->category_description : '';
$status = isset($categories->status) ? $categories->status : '1';


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

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h4 class="header-title"><?php echo e($page_Heading); ?></h4>

             <form class="card-body" action="" method="post" accept-chartset="UTF-8" enctype="multipart/form-data" role="form">

        <?php echo e(csrf_field()); ?>


        <input type="hidden" value="<?php echo e($category_id); ?>">
                <div class="mb-3">
                  <label for="fullname" class="form-label">Category Name  * :</label>
                   <input class="form-control mb-3" type="text" name="category_name" id="category_name"  value="<?php echo e(old('category_name',$category_name)); ?>" placeholder="Category Name" aria-label="default input example">

                </div>

                <div class="mb-3">
                  <label for="email" class="form-label">Category Description :</label>
                 <textarea class="form-control mb-3"name="category_description" id="category_description"  placeholder="Write Category Description .........." aria-label="default input example"><?php echo e(old('category_description',$category_description)); ?></textarea>
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

<?php /**PATH /home/appmantr/public_html/nayaeducation/resources/views/admin/categories/form.blade.php ENDPATH**/ ?>