<?php echo $__env->make('admin.common.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php
$BackUrl = CustomHelper::BackUrl();
$routeName = CustomHelper::getAdminRouteName();


$storage = Storage::disk('public');
$path = 'influencer/thumb/';
// $roleId = Auth::guard('admin')->user()->role_id; 

?>
<style>

/*  .chat-list li .chat-img {
    display: inline-block;
    width: 45px;
    vertical-align: top;
}*/

</style>

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
            <h4 class="page-title">Chats</h4>
          </div>
        </div>
      </div>     
      <!-- end page title --> 
      <div class="row">
        <!-- start chat users-->
        <div class="col-xl-3 col-lg-4">
          <div class="card">
            <div class="card-body">

              <div class="d-flex align-items-start mb-3">
                <img src="<?php echo e(asset('public/assets/new/images/users/user-1.jpg')); ?>" class="me-2 rounded-circle" height="42" alt="Brandon Smith">
                <div class="w-100">
                  <h5 class="mt-0 mb-0 font-15">
                    <a class="text-reset"><?php echo e(Auth::guard('admin')->user()->name ?? ''); ?></a>
                  </h5>
                </div>
              </div>

              <!-- start search box -->
              <form class="search-bar mb-3">
                <div class="position-relative">
                  <input type="text" id="search" class="form-control form-control-light" placeholder="Search Students">
                  <span class="fas fa-search"></span>
                </div>
              </form>
              <!-- end search box -->

              <h6 class="font-13 text-muted text-uppercase mb-2">Contacts</h6>

              <!-- users -->
              <div class="row">
                <div class="col">
                  <div data-simplebar="init" style="max-height: 375px;"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: auto; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px;">

                    <p id="user_list">

                    </p>



                   <!--  <a href="javascript:void(0);" class="text-body">
                      <div class="d-flex align-items-start p-2">
                        <img src="<?php echo e(asset('public/assets/new/images/users/user-7.jpg')); ?>" class="me-2 rounded-circle" height="42" alt="Maria C">
                        <div class="w-100">
                          <h5 class="mt-0 mb-0 font-14">
                            <span class="float-end text-muted fw-normal font-12">Thu</span>
                            Maria C
                          </h5>
                          <p class="mt-1 mb-0 text-muted font-14">
                            <span class="w-25 float-end text-end"><span class="badge badge-soft-danger">2</span></span>
                            <span class="w-75">Are we going to have this week's planning meeting today?</span>
                          </p>
                        </div>
                      </div>
                    </a> -->

                   <!--  <a href="javascript:void(0);" class="text-body">
                      <div class="d-flex align-items-start bg-light p-2">
                        <img src="<?php echo e(asset('public/assets/new/images/users/user-10.jpg')); ?>" class="me-2 rounded-circle" height="42" alt="Rhonda D">
                        <div class="w-100">
                          <h5 class="mt-0 mb-0 font-14">
                            <span class="float-end text-muted fw-normal font-12">Wed</span>
                            Rhonda D
                          </h5>
                          <p class="mt-1 mb-0 text-muted font-14">
                            <span class="w-75">Please check these design assets...</span>
                          </p>
                        </div>
                      </div>
                    </a> -->

                    


                  </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 820px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 171px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div>
                  <!-- end slimscroll-->
                </div>
                <!-- End col -->
              </div>                                        
              <!-- end users -->
            </div> <!-- end card-body-->
          </div> <!-- end card-->

        </div>
        <!-- end chat users-->

        <!-- chat area -->
        <div class="col-xl-9 col-lg-8">

          <div class="card">
            <div class="card-body py-2 px-3 border-bottom border-light">
              <div class="row justify-content-between py-1">
                <div class="col-sm-7">
                  <p id="user_name">
                  </p>



                </div>
              </div>
            </div>
            <div class="card-body">
              <ul class="conversation-list" data-simplebar="init" style="max-height: 460px;"><div class="simplebar-wrapper" style="margin: 0px -15px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: auto; overflow: hidden scroll; "  id="chat_scroll" ><div class="simplebar-content" style="padding: 0px 15px;">

                <p id="chat-data">

                </p>

              </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 853px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 248px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></ul>

              <div class="row">
                <div class="col">
                  <div class="mt-2 bg-light p-3 rounded">
                    <!-- <form class="needs-validation" novalidate="" name="chat-form" id="chat-form"> -->
                      <div class="row">
                        <div class="col mb-2 mb-sm-0">
                          <input type="text" name="message" id="message" class="form-control border-0" placeholder="Enter your text" required="">
                          <div class="invalid-feedback">
                            Please enter your messsage
                          </div>
                        </div>
                        <div class="col-sm-auto">
                          <div class="btn-group">
                            <a onclick="openFileOption()" class="btn btn-light"><i class="fa fa-paperclip"></i></a>
                            <input type="file" name="file" id="file" style="display:none;">
                            <button onclick="chat_submit()" class="btn btn-success chat-send w-100"><i class="fa fa-paper-plane"></i></button>
                          </div>
                        </div>
                        <!-- end col -->
                      </div>
                      <!-- end row-->
                      <!-- </form> -->
                    </div>
                  </div>
                  <!-- end col-->
                </div>
                <!-- end row -->
              </div>
              <!-- end card-body -->                                    
            </div>
          </div>
          <!-- end chat area-->

        </div> <!-- end row-->


      </div>
    </div>
  </div>

  <?php //echo $user_id; ?>

  <input type="hidden" name="user_id" id="user_id" value="<?php echo e($user_id ?? 0); ?>">
  <input type="hidden" name="page" id="page" value="1">


  <?php echo $__env->make('admin.common.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>




  <script>
   $(document).ready(function(){
     var user_id = $('#user_id').val();
     var page = $('#page').val();
     setInterval(function() {
      get_chats();
    }, 5000);
   });


   $("#chat_scroll").scroll(function() {
    var page = $('#page').val();
    var objDiv = document.getElementById('chat_scroll');
    var doScroll=objDiv.scrollTop>=(objDiv.scrollHeight-objDiv.clientHeight);    
    if( doScroll) {
      objDiv.scrollTop = objDiv.scrollHeight;
      page++;
      var user_id = $('#user_id').val();
      $('#page').val(page);
      var user_id = $('#user_id').val();
      get_chats(user_id,page);
    }
  });





   function chat_submit(){
    var user_id = $('#user_id').val();
    var page = $('#page').val();
    var message = $('#message').val();
    if(message==''){
      alert('Type Something!!');
      return false;
    }
    var _token = '<?php echo e(csrf_token()); ?>';
    $.ajax({
      url: "<?php echo e(route($routeName.'.chats.send_message')); ?>",
      type: "get",
      data: {user_id:user_id,message:message},
      dataType:"HTML",
      headers:{'X-CSRF-TOKEN': _token},
      cache: false,
      success: function(resp){
        $('#message').val('');
        get_user_chat(user_id,page);
      }
    });
  }



  function openFileOption(){
    document.getElementById("file").click();
  }


  $('#file').change(function() {


    var user_id = $('#user_id').val();
    var page = $('#page').val();
    var data = new FormData();
    data.append('file', $('#file').prop('files')[0]);
    data.append('reciever_id', user_id);
    var _token = '<?php echo e(csrf_token()); ?>';
    $.ajax({
      type: 'post',
      url: "<?php echo e(route($routeName.'.chats.upload_file')); ?>",
      processData: false,
      contentType: false,
      data: data,
      dataType:"JSON",
      headers:{'X-CSRF-TOKEN': _token},
      cache: false,
      success: function (response) {
        get_chats(user_id,page);   
      },
    });
  });




  $( document ).ready(function() {
    var user_id = $('#user_id').val();
    get_user_list(search='',user_id);
    if(user_id!=0){
      get_user_name(user_id);
      get_user_chat(user_id);
    }
  });


  function get_user_name(user_id)
  {
    var _token = '<?php echo e(csrf_token()); ?>';
    $.ajax({
      url: "<?php echo e(route($routeName.'.chats.get_user_name')); ?>",
      type: "POST",
      data: {user_id:user_id},
      dataType:"HTML",
      headers:{'X-CSRF-TOKEN': _token},
      cache: false,
      success: function(resp){
        $('#user_id').val(user_id);
        $('#user_name').html(resp);
      }
    });
  }



  $('#search').keyup(function() {
    var search = this.value;
    var length = search.length;
     if(length >= 3){         
      get_user_list(search); 
     }
  });


  function get_user_list(search='',user_id=''){
   var _token = '<?php echo e(csrf_token()); ?>';
   var page = $('#page').val();
   $.ajax({
    url: "<?php echo e(route($routeName.'.chats.get_user_list')); ?>",
    type: "POST",
    data: {search:search,user_id:user_id},
    dataType:"HTML",
    headers:{'X-CSRF-TOKEN': _token},
    cache: false,
    success: function(resp){
      $('#user_list').html(resp);


    }
  });
 }


 function get_user_chat(user_id,page=1){
 
  var page = $('#page').val();
  $('#user_id').val(user_id);
    // alert(user_id);
    get_user_name(user_id);
    get_user_list(search='',user_id,page=1); 

    get_chats(user_id,page);   
  }
  
  function get_chats(user_id,page=1){
    var user_id = $('#user_id').val();
    var page = $('#page').val();
    var _token = '<?php echo e(csrf_token()); ?>';
    $.ajax({
      url: "<?php echo e(route($routeName.'.chats.get_user_chat')); ?>",
      type: "get",
      data: {user_id:user_id,page:page},
      dataType:"HTML",
      headers:{'X-CSRF-TOKEN': _token},
      cache: false,
      success: function(resp){
        $("#chat-data").html(resp);
      }
    });
  }

</script><?php /**PATH /home/appmantr/public_html/nayaeducation/resources/views/admin/chats/index1.blade.php ENDPATH**/ ?>