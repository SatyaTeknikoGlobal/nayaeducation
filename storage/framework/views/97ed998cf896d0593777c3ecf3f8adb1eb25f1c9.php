<?php echo $__env->make('admin.common.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php
$BackUrl = CustomHelper::BackUrl();
// $SADMIN_ROUTE_NAME = CustomHelper::getAdminRouteName();

$routeName = CustomHelper::getAdminRouteName();
$storage = Storage::disk('public');
$path = 'influencer/';

$user_id = isset($users->id) ? $users->id : '';
$name = isset($users->name) ? $users->name : '';
$email = isset($users->email) ? $users->email : '';
$phone = isset($users->phone) ? $users->phone : '';
$dob = isset($users->dob) ? $users->dob : '';
$gender = isset($users->gender) ? $users->gender : '';
$status = isset($users->status) ? $users->status : '';

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


                 <input type="hidden" value="id" value="<?php echo e($user_id); ?>">

                <div class="mb-3">
                  <label for="fullname" class="form-label">Name</label>
                   <input class="form-control mb-3" type="text" name="name" id="name"  value="<?php echo e(old('name',$name)); ?>" placeholder="Name" aria-label="default input example">

                </div>

                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                <input class="form-control mb-3" type="email" name="email" id="email"  value="<?php echo e(old('email',$email)); ?>" placeholder="Email" aria-label="default input example">
                </div>

                 <div class="mb-3">
                     <label for="email" class="form-label">Password</label>
                     <input class="form-control mb-3" type="password" name="password" id="password"  value="" placeholder="Password" aria-label="default input example">
                 </div>

                <div class="mb-3">
                  <label for="fullname" class="form-label">Phone</label>
                   <input class="form-control mb-3" type="number" name="phone" value="<?php echo e(old('phone',$phone)); ?>" id="phone"  aria-label="default input example">

                </div>

                 <div class="mb-3">
                  <label for="fullname" class="form-label">Date Of Birth</label>
                   <input class="form-control mb-3" type="date" name="dob" id="dob" value="<?php echo e(old('dob',$dob)); ?>"  aria-label="default input example">
                </div>


                 <div class="mb-3">
                  <label for="fullname" class="form-label">Gender</label>
                       <select id="gender" name="gender" class="form-control mb-3">
                    <option value="" selected disabled>Select Gender</option>
                     <option value="male" <?php if($gender == 'male'){echo "selected";}?>>Male</option>

                           <option value="female"  <?php if($gender == 'female'){echo "selected";}?>>Female</option>
                   
                  </select>

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

<?php /**PATH /home/appmantr/public_html/nayaeducation/resources/views/admin/user/form.blade.php ENDPATH**/ ?>