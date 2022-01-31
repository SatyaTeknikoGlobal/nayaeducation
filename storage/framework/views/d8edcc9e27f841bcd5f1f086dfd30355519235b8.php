<?php echo $__env->make('admin.common.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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
            </div>
            <h4 class="page-title">DGL Forms</h4>
          </div>
        </div>
      </div>     
      <!-- end page title --> 
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h4 class="header-title">DGL Forms</h4>
              <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                <thead>
                  <tr>
                    <th>S.No.</th>
                    <th>Name</th>
                    <th>Email</th>                 
                  </tr>
                </thead>
                <tbody>
                  <?php if(!empty($dgl_forms)){

                    $i = 1;
                    foreach($dgl_forms as $cat){
                      ?>
                      <tr>
                        <td><?php echo e($i++); ?></td>
                        <td><?php echo e($cat->name); ?></td>
                        <td><?php echo e($cat->email); ?></td>
                        
                        <td>
                          <a class="btn btn-success" href="<?php echo e(route($routeName.'.dgl_forms.details', $cat->id.'?back_url='.$BackUrl)); ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
                        </td>
                      </tr>
                    <?php }}?>
                  </tbody>


                </table>

                <?php echo e($dgl_forms->appends(request()->input())->links('admin.pagination')); ?>


              </div> <!-- end card body-->
            </div> <!-- end card -->
          </div><!-- end col-->
        </div>


      </div>
    </div>
  </div>


  <?php echo $__env->make('admin.common.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/appmantr/public_html/nayaeducation/resources/views/admin/dgl_forms/index.blade.php ENDPATH**/ ?>