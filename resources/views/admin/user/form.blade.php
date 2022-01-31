@include('admin.common.header')

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
                            <a href="{{ url($back_url)}}" class="btn btn-info btn-sm" style='float: right;'>Back</a><?php } ?>
                      </ol>
                  </div>
                  <h4 class="page-title">{{ $page_Heading }}</h4>
              </div>
          </div>
      </div>
      <!--  start page title -->

       @include('snippets.errors')
            @include('snippets.flash')

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h4 class="header-title">{{ $page_Heading }}</h4>

             <form class="card-body" action="" method="post" accept-chartset="UTF-8" enctype="multipart/form-data" role="form">

        {{ csrf_field() }}

                 <input type="hidden" value="id" value="{{$user_id}}">

                <div class="mb-3">
                  <label for="fullname" class="form-label">Name</label>
                   <input class="form-control mb-3" type="text" name="name" id="name"  value="{{old('name',$name)}}" placeholder="Name" aria-label="default input example">

                </div>

                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                <input class="form-control mb-3" type="email" name="email" id="email"  value="{{old('email',$email)}}" placeholder="Email" aria-label="default input example">
                </div>

                 <div class="mb-3">
                     <label for="email" class="form-label">Password</label>
                     <input class="form-control mb-3" type="password" name="password" id="password"  value="" placeholder="Password" aria-label="default input example">
                 </div>

                <div class="mb-3">
                  <label for="fullname" class="form-label">Phone</label>
                   <input class="form-control mb-3" type="number" name="phone" value="{{old('phone',$phone)}}" id="phone"  aria-label="default input example">

                </div>

                 <div class="mb-3">
                  <label for="fullname" class="form-label">Date Of Birth</label>
                   <input class="form-control mb-3" type="date" name="dob" id="dob" value="{{old('dob',$dob)}}"  aria-label="default input example">
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

@include('admin.common.footer')

