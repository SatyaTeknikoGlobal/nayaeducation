@include('admin.common.header')

<?php
 $BackUrl = CustomHelper::BackUrl();
 $routeName = CustomHelper::getAdminRouteName();


$storage = Storage::disk('public');
$path = 'influencer/thumb/';
// $roleId = Auth::guard('admin')->user()->role_id; 
?>
<div class="page-wrapper">
      <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
          <div class="breadcrumb-title pe-3">Home</div>
          <div class="ps-3">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Content</li>
              </ol>
            </nav>
          </div>
          <div class="ms-auto">
            <div class="btn-group">
              <a href="" class="btn btn-primary"><i class="fas fa-plus" aria-hidden="true"></i> Add Content</a>
            </div>
          </div>
        </div>



        @include('snippets.errors')
            @include('snippets.flash')
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase">All Content</h6>
        <hr/>
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                  <tr>
                  
                    <th>S.No.</th>
                    <th>Image</th>
                     <th>Category</th>                   
                     <th>Course Name</th>
                      <th>Subject Name</th>
                       <th>Title</th>
                       <th>HLS</th>    
                        <th>HLS Type</th>                                       
                    <th>Status</th>
                    <th>Action</th>

                  </tr>
                </thead>
                <tbody>

               

                </tbody>
              </table>
            </div>
          </div>
        </div>



      </div>
    </div>




@include('admin.common.footer')

<script>
 


  function change_course_status(id){
  var status = $('#change_course_status'+id).val();


   var _token = '{{ csrf_token() }}';

            $.ajax({
                url: "{{ route($routeName.'.subject.change_course_status') }}",
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
