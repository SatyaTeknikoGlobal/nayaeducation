
<?php echo $__env->make('admin.common.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php 
$ADMIN_ROUTE_NAME = CustomHelper::getAdminRouteName();

$url = url()->current();
// echo $url;

$baseurl = url('/');
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
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 


            <?php if(Auth::guard('admin')->user()->role_id == 0){?>
                <div class="row">

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                            <img class="img-icon" src="<?php echo e(asset('public/assets/images/user.png')); ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="col-6">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo e($users); ?></span></h3>
                                            <a href="<?php echo e(route($ADMIN_ROUTE_NAME.'.user.index')); ?>"><p class="text-muted mb-1 text-truncate">Total Users</p>  </a>
                                        </div>
                                    </div>

                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->


                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-lg rounded-circle bg-soft-success border-success border">
                                            <img class="img-icon" src="<?php echo e(asset('public/assets/images/course.png')); ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="col-6">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo e($courses); ?></span></h3>
                                            <a href="<?php echo e(route($ADMIN_ROUTE_NAME.'.courses.index')); ?>"><p class="text-muted mb-1 text-truncate">Total Courses</p>
                                            </a>
                                        </div>
                                    </div>
                                    
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->



                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                          <img class="img-icon" src="<?php echo e(asset('public/assets/images/faculty.png')); ?>">
                                      </div>
                                  </div>
                                  

                                  <div class="col-6">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo e($faculty); ?></span></h3>
                                        <a href="<?php echo e(route($ADMIN_ROUTE_NAME.'.faculties.index')); ?>">
                                            <p class="text-muted mb-1 text-truncate">Total Faculty</p>
                                        </a>
                                    </div>
                                </div>
                                
                            </div> <!-- end row-->
                        </div>
                    </div> <!-- end widget-rounded-circle-->
                </div> <!-- end col-->

                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-soft-warning border-warning border">
                                        <img class="img-icon" src="<?php echo e(asset('public/assets/images/sub_user.png')); ?>">
                                    </div>
                                </div>
                                

                                <div class="col-6">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo e($sub_user); ?></span></h3>
                                        <a href="<?php echo e(route($ADMIN_ROUTE_NAME.'.subscriptions.index')); ?>">
                                            <p class="text-muted mb-1 text-truncate">No of Subscription</p>
                                        </a>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div>
                    </div> <!-- end widget-rounded-circle-->
                </div> <!-- end col-->

            </div>
            <!-- end row-->
        <?php }else{?>
           <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="widget-rounded-circle card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                    <!-- <i class="fe-heart font-22 avatar-title text-primary"></i> -->

                                    <img class="img-icon" src="<?php echo e(asset('public/assets/images/user.png')); ?>">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo e($users); ?></span></h3>
                                    <p class="text-muted mb-1 text-truncate">Total Users</p>
                                </div>
                            </div>
                        </div> <!-- end row-->
                    </div>
                </div> <!-- end widget-rounded-circle-->
            </div> <!-- end col-->

            <div class="col-md-6 col-xl-3">
                <div class="widget-rounded-circle card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle bg-soft-success border-success border">
                                    <img class="img-icon" src="<?php echo e(asset('public/assets/images/course.png')); ?>">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo e($courses); ?></span></h3>
                                    <p class="text-muted mb-1 text-truncate">Total Courses</p>
                                </div>
                            </div>
                        </div> <!-- end row-->
                    </div>
                </div> <!-- end widget-rounded-circle-->
            </div> <!-- end col-->

            <div class="col-md-6 col-xl-3">
                <div class="widget-rounded-circle card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                  <img class="img-icon" src="<?php echo e(asset('public/assets/images/faculty.png')); ?>">
                              </div>
                          </div>
                          <div class="col-6">
                            <div class="text-end">
                                <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo e($faculty); ?></span></h3>
                                <p class="text-muted mb-1 text-truncate">Total Faculty</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-soft-warning border-warning border">
                                <img class="img-icon" src="<?php echo e(asset('public/assets/images/sub_user.png')); ?>">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo e($sub_user); ?></span></h3>
                                <p class="text-muted mb-1 text-truncate">No of Subscription</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->
    </div>
    <!-- end row-->
<?php }?>












                        <!-- <div class="row">
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
    
                                        <h4 class="header-title mb-0">Total Revenue</h4>
    
                                        <div class="widget-chart text-center" dir="ltr">
                                            
                                            <div id="total-revenue" class="mt-0"  data-colors="#f86262"></div>
    
                                            <h5 class="text-muted mt-0">Total sales made today</h5>
                                            <h2>$178</h2>
    
                                            <p class="text-muted w-75 mx-auto sp-line-2">Traditional heading elements are designed to work best in the meat of your page content.</p>
    
                                            <div class="row mt-3">
                                                <div class="col-4">
                                                    <p class="text-muted font-15 mb-1 text-truncate">Target</p>
                                                    <h4><i class="fe-arrow-down text-danger me-1"></i>$7.8k</h4>
                                                </div>
                                                <div class="col-4">
                                                    <p class="text-muted font-15 mb-1 text-truncate">Last week</p>
                                                    <h4><i class="fe-arrow-up text-success me-1"></i>$1.4k</h4>
                                                </div>
                                                <div class="col-4">
                                                    <p class="text-muted font-15 mb-1 text-truncate">Last Month</p>
                                                    <h4><i class="fe-arrow-down text-danger me-1"></i>$15k</h4>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div> 
                            </div> 
                        -->    

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body pb-2">
                                        <h4 class="header-title mb-3">User Analytics</h4>
                                        <canvas id="userChart"></canvas>
                                    </div>
                                </div> <!-- end card -->
                            </div> <!-- end col-->
                        </div>
                        <!-- end row -->

                        
                    </div> <!-- container -->

                </div> <!-- content -->



            </div>

            <?php echo $__env->make('admin.common.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



            <script>
                const ctx = document.getElementById('userChart').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June','July','Aug','Sep','Oct','Nov','Dec'],
                        datasets: [{
                            label: '# No of Users- <?php echo e(date('Y')); ?>',
                            data: [<?php 
                                $year = date('Y');
                                for ($i = 1; $i <= 12; $i++) {
                                    $sub_count = \App\User::whereMonth('created_at',$i)->whereYear('created_at',$year)->count();
                                    ?>
                                    "<?php echo $sub_count?>",

                                    <?php } ?>],


                                    backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)',
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                    ],
                                    borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)',
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    </script><?php /**PATH /home/appmantr/public_html/nayaeducation/resources/views/admin/home/index.blade.php ENDPATH**/ ?>