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

            </div>
            <h4 class="page-title">Notifications</h4>
        </div>
    </div>
</div>    

@include('snippets.errors')
@include('snippets.flash') 
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title">Send Notification Users</h4>
                <p><b>Note:</b>
                  <br>
                  1) If You want to send for subscribed user please choose Any one of the Course to Send Notification..<br>
                  2) If You Want to send notification to all user then dont choose Course..
              </p>
              <form action="" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="mb-3">
                    <label for="fullname" class="form-label">Choose Course</label>
                    <select class="form-control"  name="course_id" >
                      <option selected disabled value="">Select Course</option>
                      <?php if(!empty($courses)){
                        foreach($courses as $course){
                            ?>
                            <option value="{{$course->id}}">{{$course->course_name}}</option>
                        <?php }}?>

                    </select>
                </div>
                <div class="mb-3">
                    <label for="fullname" class="form-label">Enter Title</label>
                    <input type="text" name="title" class="form-control" value="{{old('title')}}" placeholder="Enter Title">
                </div>

                <div class="mb-3">
                    <label for="fullname" class="form-label">Enter Description</label>
                    <textarea name="text" class="form-control" placeholder="Enter Description">{{old('text')}}</textarea>
                </div>

                <div class="mb-3">
                    <label for="fullname" class="form-label">Image</label>
                    <input type="file" name="image" class="form-control">
                </div>



                <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
            </form>

        </div> <!-- end card-body-->
    </div> <!-- end card-->
</div>
<!-- end col -->




    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title">Send Notification Specific Users</h4>
                <form action="{{route('admin.notifications.send_users')}}" method="post" enctype="multipart/form-data">
                  @csrf
                 
                <div class="mb-3">
                    <label for="fullname" class="form-label">Choose User</label>
                 <select class="form-control" name="user_id">
                    <option selected disabled value="">Select User</option>
                      <?php 
                      \App\User::latest('id')
                      ->select('id', 'name')
                      ->where('status',1)
                      ->where('is_delete',0)
                      ->chunk(50, function($users) {
                        foreach ($users as $user) {?>
                            <option value="{{$user->id}}">{{$user->name}}</option>
                       <?php  }
                    });
                    ?>
                    
            

            </select>
        </div>


        <div class="mb-3">
            <label for="fullname" class="form-label">Enter Title</label>
            <input type="text" name="title1" class="form-control" value="{{old('title1')}}" placeholder="Enter Title">
        </div>

        <div class="mb-3">
            <label for="fullname" class="form-label">Enter Description</label>
            <textarea name="text1" class="form-control" placeholder="Enter Description">{{old('text1')}}</textarea>
        </div>

        <div class="mb-3">
            <label for="fullname" class="form-label">Image</label>
            <input type="file" name="image1" class="form-control">
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

@include('admin.common.footer')

