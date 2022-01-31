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
              <ol class="breadcrumb m-0">
                  <a href="<?php echo e(route($routeName.'.categories.add', ['back_url' => $BackUrl])); ?>" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Add Category</a>
              </ol>
            </div>
            <h4 class="page-title">Categories</h4>
          </div>
        </div>
      </div>     
      <!-- end page title --> 
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h4 class="header-title">Categories</h4>
              <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                <thead>
                  <tr>
                    <th>S.No.</th>
                    <th>Name</th>
                    <th>Description</th>                 
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(!empty($categories)){

                    $i = 1;
                    foreach($categories as $cat){
                      ?>
                      <tr>
                        <td><?php echo e($i++); ?></td>
                        <td><?php echo e($cat->category_name); ?></td>
                        <td><?php echo e($cat->category_description); ?></td>
                        <td>
                          <select id='change_category_status<?php echo e($cat->id); ?>' onchange='change_category_status(<?php echo e($cat->id); ?>)' class="form-control">
                            <option value='1' <?php if($cat->status ==1)echo "selected";?> >Active</option>
                            <option value='0' <?php if($cat->status ==0)echo "selected";?>>InActive</option>
                          </select> 


                        </td>

                        <td>
                         
                          <a class="btn btn-success" href="<?php echo e(route($routeName.'.categories.edit', $cat->id.'?back_url='.$BackUrl)); ?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;

                          <a class="btn btn-danger" onclick="return confirm('Are You Want To Delete ??');" href="<?php echo e(route($routeName.'.categories.delete', $cat->id.'?back_url='.$BackUrl)); ?>"><i class="fa fa-trash"></i></a>


                        </td>
                      </tr>
                    <?php }}?>
                  </tbody>


                </table>

                <?php echo e($categories->appends(request()->input())->links('admin.pagination')); ?>


              </div> <!-- end card body-->
            </div> <!-- end card -->
          </div><!-- end col-->
        </div>


      </div>
    </div>
  </div>


  <?php echo $__env->make('admin.common.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <script>
    function change_category_status(id){
      var status = $('#change_category_status'+id).val();
      var _token = '<?php echo e(csrf_token()); ?>';
      $.ajax({
        url: "<?php echo e(route($routeName.'.categories.change_category_status')); ?>",
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
<?php /**PATH /home/appmantr/public_html/nayaeducation/resources/views/admin/categories/index.blade.php ENDPATH**/ ?>