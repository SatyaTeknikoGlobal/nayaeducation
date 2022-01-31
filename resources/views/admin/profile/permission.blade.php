
@include('admin.common.header')

<?php
$BackUrl = CustomHelper::BackUrl();
$routeName = CustomHelper::getAdminRouteName();
$storage = Storage::disk('public');

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
							</ol>
						</div>
						<h4 class="page-title">Permission For Faculty</h4>
					</div>
				</div>
			</div>     
			<!-- end page title --> 


			@include('snippets.errors')
			@include('snippets.flash')
			<style>
				.switch {
					position: relative;
					display: inline-block;
					width: 60px;
					height: 34px;
				}

				.switch input { 
					opacity: 0;
					width: 0;
					height: 0;
				}

				.slider {
					position: absolute;
					cursor: pointer;
					top: 0;
					left: 0;
					right: 0;
					bottom: 0;
					background-color: #ccc;
					-webkit-transition: .4s;
					transition: .4s;
				}

				.slider:before {
					position: absolute;
					content: "";
					height: 26px;
					width: 26px;
					left: 4px;
					bottom: 4px;
					background-color: white;
					-webkit-transition: .4s;
					transition: .4s;
				}

				input:checked + .slider {
					background-color: #2196F3;
				}

				input:focus + .slider {
					box-shadow: 0 0 1px #2196F3;
				}

				input:checked + .slider:before {
					-webkit-transform: translateX(26px);
					-ms-transform: translateX(26px);
					transform: translateX(26px);
				}

/* Rounded sliders */
.slider.round {
	border-radius: 34px;
}

.slider.round:before {
	border-radius: 50%;
}
</style>

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-md-4">
						<h4 class="mb-3 header-title">Permission For Faculty</h4>
					</div>
					<div class="col-md-2">
						<h4 class="mb-3 header-title">List</h4>
					</div>
					<div class="col-md-2">
						<h4 class="mb-3 header-title">Add</h4>
					</div>
					<div class="col-md-2">
						<h4 class="mb-3 header-title">Update</h4>
					</div>
					<div class="col-md-2">
						<h4 class="mb-3 header-title">Delete</h4>
					</div>
				</div>
					
					<div class="row">

						<?php if(!empty($sectionArr)){
							foreach ($sectionArr as $key => $value) {
								$add = '';
								$edit = '';
								$list = '';
								$delete = '';

								$exist = \App\Permission::where('section',$key)->first();
								if(!empty($exist)){
									if($exist->add == 1){
										$add = 'checked';
									}
									if($exist->list == 1){
										$list = 'checked';
									}
									if($exist->edit == 1){
										$edit = 'checked';
									}
									if($exist->delete == 1){
										$delete = 'checked';
									}



								}


								?>
								<div class="col-md-4">
									<div class="mb-3">
										<h4>{{$value}}</h4>
									</div>
								</div>

								<div class="col-md-2">
									<div class="mb-3">
										<label class="switch">
											<input type="checkbox" {{$list}} onclick="update_permission('{{$key}}','list',this)" id="checkboxlist{{$key}}">
											<span class="slider round"></span>
										</label>
									</div>
								</div>

								<div class="col-md-2">
									<div class="mb-3">
										<label class="switch">
											<input type="checkbox" {{$add}} onclick="update_permission('{{$key}}','add',this)">
											<span class="slider round"></span>
										</label>
									</div>
								</div>

								<div class="col-md-2">
									<div class="mb-3">
										<label class="switch">
											<input type="checkbox" {{$edit}} onclick="update_permission('{{$key}}','edit',this)">
											<span class="slider round"></span>
										</label>
									</div>
								</div>
								<div class="col-md-2">
									<div class="mb-3">
										<label class="switch">
											<input type="checkbox" {{$delete}} onclick="update_permission('{{$key}}','delete',this)">
											<span class="slider round"></span>
										</label>
									</div>
								</div>

							<?php }}?>
						</div>

					

				</div> <!-- end card-body-->
			</div> <!-- end card-->
		</div>
		<!-- end col -->

	</div>

</div>
</div>
</div>


@include('admin.common.footer')



<script type="text/javascript">
	function update_permission(key,section,permission) {
		if(permission.checked){
			permission = 1;
		}
		else{
			permission = 0;
		}

		var _token = '{{ csrf_token() }}';

		$.ajax({
			url: "{{ route($routeName.'.update_permission') }}",
			type: "POST",
			data: {key:key,section:section,permission:permission},
			dataType:"JSON",
			headers:{'X-CSRF-TOKEN': _token},
			cache: false,
			success: function(resp){
			}
		});
	}
</script>