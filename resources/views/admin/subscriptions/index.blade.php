@include('admin.common.header')

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
                        <h4 class="page-title">Subscription List</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Search By Name,Email,Phone,Course Name</label>
                                <form>
                                    <div class="input-group">
                                        <input type="text" name="search" value="{{old('search',$search)}}" class="form-control" placeholder="Search...." aria-label="Recipient's username">
                                        <button class="btn input-group-text btn-dark waves-effect waves-light" type="submit">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Subscription List</h4>
                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Course Name</th>
                                    <th>Subscription  Type</th>
                                    <th>End Date</th>

                                </tr>
                                </thead>
                                <?php
                                if(!empty($subscription_history)){
                                $i = 1;
                                foreach($subscription_history as $sub_his){
                                    if(!empty($sub_his->end_date)){
                                $user = \App\User::where('id',$sub_his->user_id)->first();
                                $course = \App\Course::where('id',$sub_his->course_id)->first();

                                ?>
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$user->name ?? ''}}</td>
                                    <td>{{$user->email ?? ''}}</td>
                                    <td>{{$user->phone ?? ''}}</td>
                                    <td>{{$course->course_name ?? ''}}</td>
                                    <td>{{$sub_his->type}}</td>
                                    <td>{{date('d M Y',strtotime($sub_his->end_date))}}</td>

                                </tr>

                                <?php } } }?>

                                </tbody>
                            </table>
                            {{ $subscription_history->appends(request()->input())->links('admin.pagination') }}

                      


                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
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
