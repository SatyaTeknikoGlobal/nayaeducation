@include('admin.common.header')

<?php
$BackUrl = CustomHelper::BackUrl();
// $SADMIN_ROUTE_NAME = CustomHelper::getAdminRouteName();

$routeName = CustomHelper::getAdminRouteName();
$storage = Storage::disk('public');
$path = 'influencer/';

$faq_id = isset($faqs->id) ? $faqs->id : '';
$questions = isset($faqs->questions) ? $faqs->questions : '';
$answer = isset($faqs->answer) ? $faqs->answer : '';
$status = isset($faqs->status) ? $faqs->status : '1';
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

     <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h4 class="header-title">{{ $page_Heading }}</h4>

            <form class="card-body" action="" method="post" accept-chartset="UTF-8" enctype="multipart/form-data" role="form">

             {{ csrf_field() }}

             <input type="hidden" name="id" value="{{ $faq_id }}">
             <div class="mb-3">
              <label for="fullname" class="form-label">Question</label>
              <textarea class="form-control mb-3"  name="questions" id="questions" placeholder="Write Question" aria-label="default input example">{{ old('questions',$questions) }}</textarea>

            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Answer</label>
              <textarea class="form-control mb-3"name="answer" id="answer"  placeholder="Write Answer .........." aria-label="default input example">{{ old('answer',$answer) }}</textarea>
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

