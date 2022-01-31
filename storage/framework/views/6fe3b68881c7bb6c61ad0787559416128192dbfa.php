<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <title>Dashboard | NayaEducation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo e(asset('public/assets/images/logo/logo.png')); ?>">

    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <!-- Plugins css -->
    <link href="<?php echo e(asset('public/assets/new/libs/flatpickr/flatpickr.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('public/assets/new/libs/selectize/css/selectize.bootstrap3.css')); ?>" rel="stylesheet" type="text/css" />
    
    <!-- App css -->
    <link href="<?php echo e(asset('public/assets/new/css/config/creative/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="<?php echo e(asset('public/assets/new/css/config/creative/app.min.css')); ?>" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="<?php echo e(asset('public/assets/new/css/config/creative/bootstrap-dark.min.css')); ?>" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
    <link href="<?php echo e(asset('public/assets/new/css/config/creative/app-dark.min.css')); ?>" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

    <!-- icons -->
    <link href="<?php echo e(asset('public/assets/new/css/icons.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    

    <!-- third party css -->
    <link href="<?php echo e(asset('public/assets/new/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('public/assets/new/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('public/assets/new/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('public/assets/new/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css')); ?>" rel="stylesheet" type="text/css" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">


    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/assets/plugins/chart.js/Chart.min.css')); ?>" />




  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>











</head>

<style type="text/css">
    .dataTables_info{
        display: none;
    }
    #basic-datatable_paginate{
        display: none;
    }

    .pager {
        padding-left: 0;
        margin: 20px 0;
        text-align: center;
        list-style: none;
    }
    .pager li {
        display: inline;
    }.pager li>a, .pager li>span {
        display: inline-block;
        padding: 5px 14px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 15px;
    }

    a {
        color: #337ab7;
        text-decoration: none;
    }
    .img-icon{
        margin: 11px;
        height: 70%;
        width: 70%;
    }

    .dataTables_length{
        display: none;
    }
    .dataTables_filter{
        display: none;
    }
    .close{
        float: right;
    }

    .btn-primary:hover {
    color: #fff;
    background-color: #2d6c8b;
    border-color: #2d6c8b;
}
</style>








<?php 
$storage = Storage::disk('public');
$profilepath = 'user/';
$profileImg = url('public/storage/user/user.png');
if(!empty(Auth::guard('admin')->user()->image)){
    $image = Auth::guard('admin')->user()->image;
    if($storage->exists($profilepath.$image)){
        $profileImg = url('public/storage/'.$profilepath.'thumb/'.$image);
    }

}
?>

<style type="text/css">
    .nav-user img {
       height: 50px;
    width: 50px;
}
</style>



<!-- body start -->
<body class="loading" data-layout-mode="horizontal" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": true}'>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <div class="navbar-custom">
            <div class="container-fluid">
                <ul class="list-unstyled topnav-menu float-end mb-0">

                    <li class="dropdown notification-list topbar-dropdown">
                        <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="<?php echo e($profileImg); ?>" alt="user-image" class="rounded-circle">
                            <span class="pro-user-name ms-1">
                                <?php echo e(Auth::guard('admin')->user()->name ?? ''); ?> <i class="arrow-down"></i> 
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                            <!-- item-->
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome !</h6>
                            </div>

                            <!-- item-->
                            <a href="<?php echo e(route('admin.profile')); ?>" class="dropdown-item notify-item">
                                <span>My Account</span>
                            </a>

                            <?php if(Auth::guard('admin')->user()->role_id == 0){?>
                                 <a href="<?php echo e(route('admin.permission')); ?>" class="dropdown-item notify-item">
                                <span>Permission To Faculty</span>
                             </a>

                           

                            <!-- item-->
                            <a href="<?php echo e(route('admin.setting')); ?>" class="dropdown-item notify-item">
                                <span>Settings</span>
                            </a>
                             <?php }?>
                            <!-- item-->
                            <a href="<?php echo e(route('admin.logout')); ?>" class="dropdown-item notify-item">
                                <span>Logout</span>
                            </a>

                        </div>
                    </li>

                </ul>

                <!-- LOGO -->
                <div class="logo-box">
                    <a href="<?php echo e(url('/admin')); ?>" class="logo logo-dark text-center">
                        <span class="logo-sm">
                            <img src="<?php echo e(asset('public/assets/images/logo/logo.png')); ?>" alt="" height="22">
                            <!-- <span class="logo-lg-text-light">UBold</span> -->
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo e(asset('public/assets/images/logo/text.png')); ?>" alt="" height="50">
                            <!-- <span class="logo-lg-text-light">U</span> -->
                        </span>
                    </a>

                    <a href="<?php echo e(url('/admin')); ?>" class="logo logo-light text-center">
                        <span class="logo-sm">
                            <img src="<?php echo e(asset('public/assets/images/logo/logo.png')); ?>" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo e(asset('public/assets/images/logo/text.png')); ?>" alt="" height="50">
                        </span>
                    </a>
                </div>

                <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                    <li>
                        <button class="button-menu-mobile waves-effect waves-light">
                            <i class="fe-menu"></i>
                        </button>
                    </li>

                    <li>
                        <!-- Mobile menu toggle (Horizontal Layout)-->
                        <a class="navbar-toggle nav-link" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>   
                </ul>
                <div class="clearfix"></div>
            </div>
        </div>

        <?php echo $__env->make('admin.common.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/appmantr/public_html/nayaeducation/resources/views/admin/common/header.blade.php ENDPATH**/ ?>