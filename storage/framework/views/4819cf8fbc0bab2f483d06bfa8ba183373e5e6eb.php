<?php echo $__env->make('admin.common.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php
$BackUrl = CustomHelper::BackUrl();
$routeName = CustomHelper::getAdminRouteName();


$storage = Storage::disk('public');
$path = 'influencer/thumb/';
// $roleId = Auth::guard('admin')->user()->role_id; 
$search = isset($search) ? $search :'';
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
                <a href="<?php echo e(route($routeName.'.user.export', ['back_url' => $BackUrl])); ?>" class="btn btn-primary"><i class="fas fa-file-export" aria-hidden="true"></i>Export</a>
                &nbsp;&nbsp;&nbsp;
                <a href="<?php echo e(route($routeName.'.user.add', ['back_url' => $BackUrl])); ?>" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Add User</a>
              </ol>
            </div>
            <h4 class="page-title">Users</h4>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="mb-3">
                <label class="form-label">Search By Name,Email,Phone</label>
                <form>
                  <div class="input-group">
                    <input type="text" name="search" value="<?php echo e(old('search',$search)); ?>" class="form-control" placeholder="Search...." aria-label="Recipient's username">
                    <button class="btn input-group-text btn-dark waves-effect waves-light" type="submit">Search</button>
                  </div>
                </form>
              </div>




            </div>
          </div>
        </div>
      </div>


      <?php echo $__env->make('snippets.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php echo $__env->make('snippets.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      

      <!-- end page title --> 
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h4 class="header-title">Users</h4>
              <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                <thead>
                  <tr>

                    <th>#ID</th>
                    <th>Name</th>
                    <th>Email</th>                   
                    <th>Phone</th>
                    <th>Wallet</th>
                    <th>Dob</th>
                    <th>Gender</th>
                    <th>Image</th>                           
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(!empty($users)){
                    foreach ($users as $user){
                      $image = $user->image;
                      $imageUrl = url('/api/public/images/users/user.png');
                      if(!empty($image)){
                        $imageUrl = url('/api/public/images/users/'.$image);
                      }
                      ?>
                      <tr>
                       <td><?php echo e($user->id); ?></td>
                       <td><?php echo e($user->name ?? ''); ?></td>
                       <td><?php echo e($user->email ?? ''); ?></td>
                       <td><?php echo e($user->phone ?? ''); ?></td>
                       <td><?php echo e($user->wallet ?? ''); ?></td>
                       <td><?php echo e($user->dob ?? ''); ?></td>
                       <td><?php echo e($user->gender ?? ''); ?></td>
                       <td><a href="<?php echo e($imageUrl); ?>" target="_blank"><img src="<?php echo e($imageUrl); ?>" height="50" width="50"></a></td>
                       <td>  
                        <a class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#walletmodal<?php echo e($user->id); ?>" title="Wallet" ><i class="fas fa-wallet"></i></a>&nbsp;&nbsp;&nbsp;

                        <a style="background:#ed6c57;" data-bs-toggle="modal" data-bs-target="#subscriptionmodal<?php echo e($user->id); ?>" class="btn btn-success" title="Subscription"><i class="fa fa-rocket" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;
                        <a class="btn btn-success" title="Edit" href="<?php echo e(route($routeName.'.user.edit', $user->id.'?back_url='.$BackUrl)); ?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;

                        <a class="btn btn-danger" title="Delete" onclick="return confirm('Are You Want To Delete ??');" href="<?php echo e(route($routeName.'.user.delete', $user->id.'?back_url='.$BackUrl)); ?>"><i class="fa fa-trash"></i></a>


                         <div id="walletmodal<?php echo e($user->id); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title" id="standard-modalLabel"><?php echo e($user->name ?? ''); ?> (<b>Rs:<?php echo e($user->wallet ?? 0); ?></b>)</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form class="card-body" action="<?php echo e(route($routeName.'.user.wallet')); ?>" method="post" accept-chartset="UTF-8" enctype="multipart/form-data" role="form">
                                <?php echo e(csrf_field()); ?>

                                <div class="modal-body">
                                  <input type="hidden" name="user_id" value="<?php echo e($user->id); ?>">

                                  <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Type</label>
                                    <div class="col-md-10">
                                      <select class="form-control mb-3" name="type" required>
                                        <option value="" selected disabled>Select Type</option>
                                        <option value="credit">Credit</option>
                                        <option value="debit">Debit</option>

                                      </select>
                                    </div>
                                  </div>


                                  <div class="form-group row">
                                    <label class="col-sm-2 col-form-label" >Amount</label>
                                    <div class="col-sm-10"><input type="number" class="form-control form-control-rounded mb-3" name="amount" placeholder="Enter Amount" required aria-label="default input example"></div>
                                  </div>
                                </div>

                                <div class="modal-footer">
                                  <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" id="submit_wallet" class="btn btn-primary">Save</button>
                                </div>
                              </form>
                            </div><!-- /.modal-content -->
                          </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->










                      </td>
                    </tr>

                  <?php }}?>

                </tbody>


              </table>
              <?php echo e($users->appends(request()->input())->links('admin.pagination')); ?>



            </div> <!-- end card body-->
          </div> <!-- end card -->
        </div><!-- end col-->
      </div>


    </div>
  </div>
</div>


<?php echo $__env->make('admin.common.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php /**PATH /home/appmantr/public_html/nayaeducation/resources/views/admin/user/index.blade.php ENDPATH**/ ?>