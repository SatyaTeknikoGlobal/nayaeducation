@include('admin.common.header')

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
                <a href="{{ route($routeName.'.user.export', ['back_url' => $BackUrl]) }}" class="btn btn-primary"><i class="fas fa-file-export" aria-hidden="true"></i>Export</a>
                &nbsp;&nbsp;&nbsp;
                <a href="{{ route($routeName.'.user.add', ['back_url' => $BackUrl]) }}" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Add User</a>
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
                    <input type="text" name="search" value="{{old('search',$search)}}" class="form-control" placeholder="Search...." aria-label="Recipient's username">
                    <button class="btn input-group-text btn-dark waves-effect waves-light" type="submit">Search</button>
                  </div>
                </form>
              </div>




            </div>
          </div>
        </div>
      </div>


      @include('snippets.errors')
      @include('snippets.flash')




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
                       <td>{{$user->id}}</td>
                       <td>{{$user->name ?? ''}}</td>
                       <td>{{$user->email ?? ''}}</td>
                       <td>{{$user->phone ?? ''}}</td>
                       <td>{{$user->wallet ?? ''}}</td>
                       <td>{{$user->dob ?? ''}}</td>
                       <td>{{$user->gender ?? ''}}</td>
                       <td><a href="{{$imageUrl}}" target="_blank"><img src="{{$imageUrl}}" height="50" width="50"></a></td>
                       <td>  
                        <a class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#walletmodal{{$user->id}}" title="Wallet" ><i class="fas fa-wallet"></i></a>&nbsp;&nbsp;&nbsp;


                        <div id="walletmodal{{$user->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title" id="standard-modalLabel">{{$user->name ?? ''}} (<b>Rs:{{$user->wallet ?? 0}}</b>)</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form class="card-body" action="{{route($routeName.'.user.wallet')}}" method="post" accept-chartset="UTF-8" enctype="multipart/form-data" role="form">
                                {{ csrf_field() }}
                                <div class="modal-body">
                                  <input type="hidden" name="user_id" value="{{$user->id}}">

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










                        <a style="background:#ed6c57;" data-bs-toggle="modal" data-bs-target="#subscriptionmodal{{$user->id}}" class="btn btn-success" title="Subscription"><i class="fa fa-rocket" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;
                        <a class="btn btn-success" title="Edit" href="{{ route($routeName.'.user.edit', $user->id.'?back_url='.$BackUrl) }}"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;

                        <a class="btn btn-danger" title="Delete" onclick="return confirm('Are You Want To Delete ??');" href="{{ route($routeName.'.user.delete', $user->id.'?back_url='.$BackUrl) }}"><i class="fa fa-trash"></i></a>


                        <div id="subscriptionmodal{{$user->id}}" class="modal" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title" id="standard-modalLabel">{{$user->name ?? ''}}</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>

                              <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                  <tr>
                                    <th>S.No.</th>
                                    <th>Course Name</th>
                                    <th>End date</th>                 

                                  </tr>
                                </thead>
                                <tbody>

                                  <tr>
                                    <td>1</td>
                                    <td>Test</td>
                                    <td>11-01-2000</td>
                                    <tr>
                                    </tbody>

                                  </table>




                                  <form class="card-body" action="{{route($routeName.'.user.subscription')}}" method="post" accept-chartset="UTF-8" enctype="multipart/form-data" role="form">
                                    {{ csrf_field() }}
                                    <div class="modal-body">
                                      <input type="hidden" name="user_id" value="{{$user->id}}">

                                      <div class="form-group row">
                                        <label class="col-md-4 col-form-label">Select Course</label>
                                        <div class="col-md-8">
                                          <select class="form-control mb-3" name="course_id" required>
                                            <option value="" selected disabled>Select Course</option>
                                            <?php 
                                            $courseId = [];
                                            $exists = \App\SubscriptionHistory::select('course_id')->where('user_id',$user->id)->get();
                                            if(!empty($exists)){
                                              foreach($exists as $ex){
                                                $courseId[] = $ex->course_id;
                                              }
                                            }
                                            $courses = \App\Course::select('id','course_name')->orderBy('id','desc');
                                            if(!empty($courseId)){
                                              $courses->whereNotIn('id',$courseId);
                                            }
                                            $courses = $courses->get();
                                            if(!empty($courses)){
                                              foreach($courses as $course){
                                                ?>
                                                <option value="{{$course->id}}">{{$course->course_name}}</option>

                                              <?php }}?>

                                            </select>
                                          </div>
                                        </div>
                                        <div class="form-group row">
                                          <label class="col-md-4 col-form-label">Select Type</label>
                                          <div class="col-md-8">
                                            <select class="form-control mb-3" name="type" required>
                                             <option value="monthly">Monthly</option>
                                             <option value="full">Fully</option>
                                           </select>
                                         </div>
                                       </div>

                                       <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
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
                    {{ $users->appends(request()->input())->links('admin.pagination') }}


                  </div> <!-- end card body-->
                </div> <!-- end card -->
              </div><!-- end col-->
            </div>


          </div>
        </div>
      </div>


      @include('admin.common.footer')


