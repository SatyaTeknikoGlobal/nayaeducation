<!doctype html>
    <html lang="en">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--favicon-->
        <link rel="icon" href="{{asset('public/assets/images/logo/logo.png')}}" type="image/png" />
        <!-- loader-->
        <link href="{{asset('public/assets/css/pace.min.css')}}" rel="stylesheet" />
        <script src="{{asset('public/assets/js/pace.min.js')}}"></script>
        <!-- Bootstrap CSS -->
        <link href="{{asset('public/assets/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
        <link href="{{asset('public/assets/css/app.css')}}" rel="stylesheet">
        <link href="{{asset('public/assets/css/icons.css')}}" rel="stylesheet">
        <title>Forget Password-NayaEducation</title>
        
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<style type="text/css">
     .btn-primary:hover {
    color: #fff;
    background-color: #2d6c8b;
    border-color: #2d6c8b;
}
</style>

    </head>

    <body class="bg-login">
      <!--wrapper-->
      <div class="wrapper">
        <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
            <div class="container-fluid">
                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                    <div class="col mx-auto">
                        <div class="mb-4 text-center d-flex">
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <img class="logo-img" src="{{asset('public/assets/images/logo/text.png')}}" alt="logo" width="{conf.logoWidth}" style="width: 100%;height: auto;">
                                <br>

                                <div class="border p-4 rounded">
                                    <div class="form-body">
                                        @include('snippets.errors')
                                        @include('snippets.flash')

                                        <form class="row g-3" action="" method="post">
                                            {{ csrf_field() }}
                                            <div class="col-12">
                                                <label for="email" class="form-label">Email Address</label>
                                                <input type="text" class="form-control" name="email" id="email" placeholder="Email Address">
                                            </div>



                                             <div class="col-md-6 text-end"> <i class="fa fa-sign-in" aria-hidden="true"></i> <a href="{{url('admin/login')}}">Click Here</a> to Login
                                                </div>


                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-link"></i>Send Link</button>
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

</body>


<!-- Mirrored from creatantech.com/demos/codervent/rocker/vertical/authentication-signin by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 17 Dec 2021 06:35:52 GMT -->
</html>
