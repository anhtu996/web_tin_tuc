@extends('layout.index')
@section('title')
	{{ "Trang chủ" }}
@endsection
@section('content')

<!-- Page Content -->
<div class="container">

	<!-- slider -->
	@include('layout.slider')
    <!-- end slide -->

    <div class="space20"></div>


    <div class="row main-left">
        @include('layout.menu-left')

        <div class="col-md-9">
            <div class="panel panel-default">            
            	<div class="panel-heading" style="background-color:#337AB7; color:white;" >
            		<h2 style="margin-top:0px; margin-bottom:0px;">Laravel Tin Tức</h2>
            	</div>

            	<div class="panel-body">
        			@foreach ($theloai as $tl)
            			@if (count($tl->loaiTin)>0)
		        			<!-- item -->
		    				<div class="row-item row">
			                	<h3>
			                		<a href="category.html">{{ $tl->Ten }}</a> | 
			                		@foreach ($tl->loaiTin as $lt)
			                			<small><a href="loaitin/{{ $lt->id }}/{{ $lt->TenKhongDau }}.html"><i>{{ $lt->Ten }}</i></a>/</small>
			                		@endforeach	
			                	</h3>
		                		<div class="col-md-8 border-right">
		                			<?php 
		                				//su dung collection trong laravel
										$data = $tl->tinTuc->where('NoiBat',1)->sortByDesc('created_at')->take(5);
										$tin1 = $data->shift();
										//khi dung ham shift thi no se tra ve du lieu kieu mang
										// var_dump($tin1);
									?>
			                		<div class="col-md-5">
				                        <a href="detail.html">
				                            <img class="img-responsive" src="upload/tintuc/{{ $tin1['Hinh'] }}" alt="">
				                        </a>
				                    </div>
									
									{{-- @foreach ($data as $dt) --}}
										<div class="col-md-7">
					                        <h3>{{ $tin1['TieuDe'] }}</h3>
					                        <p>{{ $tin1['TomTat'] }}</p>
					                        <a class="btn btn-primary" href="tintuc/{{ $tin1['id'] }}/{{ $tin1['TieuDeKhongDau'] }}.html">Xem thêm <span class="glyphicon glyphicon-chevron-right"></span></a>
										</div>
									{{-- @endforeach --}}
				                    
		                		</div>

								<div class="col-md-4">
									@foreach ($data->all() as $dt)
										<a href="tintuc/{{ $dt->id }}/{{ $dt->TieuDeKhongDau }}.html">
											<h4>
												<span class="glyphicon glyphicon-list-alt"></span>
												{{ $dt->TieuDe }}
											</h4>
										</a>
									@endforeach
									

								</div>
							
								<div class="break"></div>
		               		</div>
			                <!-- end item -->
			            @endif
	            	@endforeach    
				</div>
            </div>
    	</div>
    </div>
    <!-- /.row -->
</div>
<!-- end Page Content -->

@endsection