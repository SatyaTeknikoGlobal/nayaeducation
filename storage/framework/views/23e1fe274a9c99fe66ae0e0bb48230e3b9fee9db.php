<!doctype html>
<html lang="en">

  
<!-- Mirrored from creatantech.com/demos/codervent/rocker/vertical/authentication-signup by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 17 Dec 2021 06:35:52 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="<?php echo e(asset('public/assets/images/favicon-32x32.png')); ?>" type="image/png" />
    <!-- loader-->
    <link href="<?php echo e(asset('public/assets/css/pace.min.css')); ?>" rel="stylesheet" />
    <script src="<?php echo e(asset('public/assets/js/pace.min.html')); ?>"></script>
    <!-- Bootstrap CSS -->
    <link href="<?php echo e(asset('public/assets/css/bootstrap.min.css')); ?>" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="<?php echo e(asset('public/assets/css/app.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('public/assets/css/icons.css')); ?>" rel="stylesheet">
    <title>Sign Up</title>
  </head>

    <body class="bg-login">
    <!--wrapper-->
    <div class="wrapper">
        <div class="d-flex align-items-center justify-content-center my-5 my-lg-0">
            <div class="container">
                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2">
                    <div class="col mx-auto">
                        <div class="my-4 text-center">
                           <img class="logo-img" src="<?php echo e(asset('public/assets/img/logoNE.png')); ?>" alt="logo" width="{conf.logoWidth}" height="200" width="200"><span class="splash-description">
      <a href=""><b>NAYA</b>Education</a>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="border p-4 rounded">
                                    <div class="text-center">
                                        <h3 class="">Sign Up</h3>
                                        <p>Already have an account? <a href="<?php echo e(url('admin/login')); ?>">Sign in here</a>
                                        </p>
                                    </div>
                                    <div class="d-grid">
                                         
                                    </div>
                                    <div class="login-separater text-center mb-4"> <span>OR SIGN UP WITH EMAIL</span>
                                        <hr/>
                                    </div>
                                    <div class="form-body">
                                        <form class="row g-3">
                                            <div class="col-sm-6">
                                                <label for="inputFirstName" class="form-label">First Name</label>
                                                <input type="email" class="form-control" id="inputFirstName" placeholder="Jhon">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="inputLastName" class="form-label">Last Name</label>
                                                <input type="email" class="form-control" id="inputLastName" placeholder="Deo">
                                            </div>
                                            <div class="col-12">
                                                <label for="inputEmailAddress" class="form-label">Email Address</label>
                                                <input type="email" class="form-control" id="inputEmailAddress" placeholder="example@user.com">
                                            </div>
                                            <div class="col-12">
                                                <label for="inputChoosePassword" class="form-label">Password</label>
                                                <div class="input-group" id="show_hide_password">
                                                    <input type="password" class="form-control border-end-0" id="inputChoosePassword" value="12345678" placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label for="inputSelectCountry" class="form-label">Country</label>
                                                <select class="form-select" id="inputSelectCountry" aria-label="Default select example">
                                                    <option selected>India</option>
                                                    <option value="1">United Kingdom</option>
                                                    <option value="2">America</option>
                                                    <option value="3">Dubai</option>
                                                </select>
                                            </div>
                                           <!--  <div class="col-12">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">I read and agree to Terms & Conditions</label>
                                                </div>
                                            </div> -->
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary"><i class='bx bx-user'></i>Sign up</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
    </div>
    <!--end wrapper-->
    <!-- Bootstrap JS -->
  <!--   <img src="<?php echo e(asset('public/assets/js/bootstrap.bundle.min.js')); ?>"></script> -->
    <!--plugins-->
   <!--  <img src="<?php echo e(asset('public/assets/js/jquery.min.js')); ?>"></script>
    <img src="<?php echo e(asset('public/assets/plugins/simplebar/js/simplebar.min.js')); ?>"></script>
    <img src="<?php echo e(asset('public/assets/plugins/metismenu/js/metisMenu.min.js')); ?>"></script>
    <img src="<?php echo e(asset('public/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')); ?>"></script> -->
    <!--Password show & hide js -->
    <script>
        $(document).ready(function () {
            $("#show_hide_password a").on('click', function (event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });
    </script>
    <!--app JS-->
    <img src="<?php echo e(asset('public/assets/js/app.js')); ?>"></script>
    </body>


<!-- Mirrored from creatantech.com/demos/codervent/rocker/vertical/authentication-signup by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 17 Dec 2021 06:35:52 GMT -->
</html>
<?php /**PATH /home/appmantr/public_html/nayaeducation/resources/views/admin/register/index.blade.php ENDPATH**/ ?>