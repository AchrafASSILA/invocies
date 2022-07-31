@extends('layouts.master')
@section('title')
المنتجات
@stop
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات</span>
						</div>
					</div>
				
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
	@if (session('success'))
			<div class="alert alert-success" role="alert">
				<button aria-label="Close" class="close" data-dismiss="alert" type="button">
					<span aria-hidden="true">&times;</span>
				</button>
				
				{{ session('success') }}
				</div>
						<!-- row -->
	@endif
	@if (session('delete'))
			<div class="alert alert-danger" role="alert">
				<button aria-label="Close" class="close" data-dismiss="alert" type="button">
					<span aria-hidden="true">&times;</span>
				</button>
				
				{{ session('delete') }}
				</div>
						<!-- row -->
	@endif
				<div class="row">
	

	<div class="col-xl-12">
		<div class="card mg-b-20">
			<div class="card-header pb-0">
				<div class="d-flex justify-content-between">
					<h4 class="card-title mg-b-0"><a style="padding: 10px;border-radius: 2px;
						background: #0162e8;
						color: white;
						display: flex;
						justify-content: center;" href="{{route('products.create')}}">اضف منتج</a>
				   </h4>
					<i class="mdi mdi-dots-horizontal text-gray"></i>
				</div>
				 </div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table key-buttons text-md-nowrap">
						<thead>
							<tr>
								<th class="border-bottom-0">#</th>
								<th class="border-bottom-0">اسم المنتج</th>
								<th class="border-bottom-0">وصف المنتج</th>
								<th class="border-bottom-0">اسم القسم</th>
								<th class="border-bottom-0">العمليات</th>
								<th class="border-bottom-0">الصانع</th>
							</tr>
						</thead>
						<tbody>
								@php
									$i = 1;
								@endphp
							@foreach ($products as $product)
							<tr>
								<td>{{$i}}</td>
								<td>{{$product->product_name}}</td>
								<td>
									{{$product->product_desc}}
								</td>
								<td>
									{{$product->section->section_name}}
								</td>
								<td>
									<a href="{{route('products.edit',$product->id)}}" style="padding: 5px;
									background: #009688;
									color: white;
									border-radius: 5px;">تحديث</a>
									
								<form style="display: inline-block;" action="{{route('products.destroy',$product->id)}}" method="post">
									@csrf
									@method('DELETE')
									<button style="padding: 5px;
									background: #e43b6d;
									color: white;
									border-radius: 5px;height:27px;border: none;width:38.97px" onclick = "return confirm('هل تريد حذف هذا المنتج ؟')" type="submit"  >
										حذف
									</button>
								  </form>	
							</td>

								<td>Edinburgh</td>
								
							</tr>
							@php
								$i++;
							@endphp
							@endforeach
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!--/div-->



				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>

<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!-- Internal Modal js-->
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
@endsection