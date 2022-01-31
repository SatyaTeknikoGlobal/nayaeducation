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
                 
              </ol>
            </div>
            <h4 class="page-title">Contact Us List</h4>
          </div>
        </div>
      </div>     
      <!-- end page title --> 
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h4 class="header-title">Contact Us List</h4>
              <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                <thead>
                  <tr>
                    <th>S.No.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Description</th>                 
                    <th>Status</th>                 
                  </tr>
                </thead>
                <tbody>
                  <?php if(!empty($contacts)){
                    $i = 1;
                    foreach($contacts as $cat){
                      $user = \App\User::where('id',$cat->user_id)->first();

                      ?>
                      <tr>
                        <td><?php echo e($i++); ?></td>
                        <td><?php echo e($cat->name ?? $user->name); ?></td>
                        <td><?php echo e($cat->email ?? $user->email); ?></td>
                        <td><?php echo e($cat->phone ?? $user->phone); ?></td>
                         <td><?php echo $cat->message; ?></td>
                        <td>
                          <select id='change_contacts_status<?php echo e($cat->id); ?>' onchange='change_contacts_status(<?php echo e($cat->id); ?>)' class="form-control">
                            <option value='1' <?php if($cat->status ==1)echo "selected";?> >Solved</option>
                            <option value='0' <?php if($cat->status ==0)echo "selected";?>>Not Solve</option>
                          </select> 


                        </td>
                      </tr>
                    <?php }}?>
                  </tbody>


                </table>

                <?php echo e($contacts->appends(request()->input())->links('admin.pagination')); ?>


              </div> <!-- end card body-->
            </div> <!-- end card -->
          </div><!-- end col-->
        </div>


      </div>
    </div>
  </div>


  <?php echo $__env->make('admin.common.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <script>
    function change_contacts_status(id){
      var status = $('#change_contacts_status'+id).val();
      var _token = '<?php echo e(csrf_token()); ?>';
      $.ajax({
        url: "<?php echo e(route($routeName.'.contacts.change_contacts_status')); ?>",
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
<?php /**PATH /home/appmantr/public_html/nayaeducation/resources/views/admin/contacts/index.blade.php ENDPATH**/ ?>