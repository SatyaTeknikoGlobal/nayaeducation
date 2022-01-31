@include('admin.common.header')

<?php
$BackUrl = CustomHelper::BackUrl();
$routeName = CustomHelper::getAdminRouteName();


$storage = Storage::disk('public');
$path = 'influencer/thumb/';
// $roleId = Auth::guard('admin')->user()->role_id; 

?>
<style>
  
  .dataTables_wrapper{

    overflow: hidden !important;
  }


/*
.faq_ans{
  white-space: normal !important;
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
              <ol class="breadcrumb m-0">
                  <a href="{{ route($routeName.'.faqs.add', ['back_url' => $BackUrl]) }}" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Add FAQs</a>
              </ol>
            </div>
            <h4 class="page-title">FAQs</h4>
          </div>
        </div>
      </div>     
      <!-- end page title --> 
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h4 class="header-title">FAQs</h4>
              <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                <thead>
                  <tr>
                    <th>S.No.</th>
                    <th>Questions</th>
                    <th>Answer</th>                 
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(!empty($faqs)){

                    $i = 1;
                    foreach($faqs as $cat){
                      $question =  mb_strlen(strip_tags($cat->questions),'utf-8') > 50 ? mb_substr(strip_tags($cat->questions),0,50,'utf-8').'...' : strip_tags($cat->questions);
                      $answer =  mb_strlen(strip_tags($cat->answer),'utf-8') > 50 ? mb_substr(strip_tags($cat->answer),0,50,'utf-8').'...' : strip_tags($cat->answer);
                      ?>
                      <tr>
                        <td>{{$i++}}</td>
                        <td>{{$question}}</td>
                        <td>{{$answer}}</td>
                        <td>
                          <select id='change_faq_status{{$cat->id}}' onchange='change_faq_status({{$cat->id}})' class="form-control">
                            <option value='1' <?php if($cat->status ==1)echo "selected";?> >Active</option>
                            <option value='0' <?php if($cat->status ==0)echo "selected";?>>InActive</option>
                          </select> 


                        </td>

                        <td>
                         
                          <a class="btn btn-success" href="{{ route($routeName.'.faqs.edit', $cat->id.'?back_url='.$BackUrl) }}"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;

                          <a class="btn btn-danger" onclick="return confirm('Are You Want To Delete ??');" href="{{ route($routeName.'.faqs.delete', $cat->id.'?back_url='.$BackUrl) }}"><i class="fa fa-trash"></i></a>


                        </td>
                      </tr>
                    <?php }}?>
                  </tbody>


                </table>

                {{ $faqs->appends(request()->input())->links('admin.pagination') }}

              </div> <!-- end card body-->
            </div> <!-- end card -->
          </div><!-- end col-->
        </div>


      </div>
    </div>
  </div>


  @include('admin.common.footer')

  <script>
   

function change_faq_status(faq_id){
  var status = $('#change_faq_status'+faq_id).val();


   var _token = '{{ csrf_token() }}';

            $.ajax({
                url: "{{ route($routeName.'.faqs.change_faq_status') }}",
                type: "POST",
                data: {faq_id:faq_id, status:status},
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
