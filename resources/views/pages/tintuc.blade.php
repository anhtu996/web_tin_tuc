@extends('layout.index')
@section('title')
	{{ "Chi tiết" }}
@endsection
@section('content')
<!-- Page Content -->
<div class="container">
    <div class="row">

        <!-- Blog Post Content Column -->
        <div class="col-lg-9">

            <!-- Blog Post -->

            <!-- Title -->
            <h1>{{ $tintuc->TieuDe }}</h1>

            <!-- Author -->
            <p class="lead">
                by <a href="#">admin</a>
            </p>

            <!-- Preview Image -->
            <img class="img-responsive" src="upload/tintuc/{{ $tintuc->Hinh }}" alt="">

            <!-- Date/Time -->
            <p><span class="glyphicon glyphicon-time"></span> Posted on {{ $tintuc->created_at }}</p>
            <hr>

            <!-- Post Content -->
            <p class="lead">{!! $tintuc->NoiDung !!}</p>

            <hr>

            <!-- Blog Comments -->

            <!-- Comments Form -->
            @if (Auth::check())
            	<div class="well">
	                <h4>Viết bình luận ...<span class="glyphicon glyphicon-pencil"></span></h4>
	                {{-- <form id="postComment" action="" role="form"> --}}
	                    <div class="form-group">
	                        <textarea name="NoiDung" id="NoiDungTT" class="form-control" rows="3"></textarea>
	                    </div>
	                    <button  type="button" id="submit" class="btn btn-primary">Gửi</button>
	                    <input type="hidden" id="idTinTuc" name="idTinTuc" value="{{ $tintuc->id }}">
	                    <input type="hidden" name="_token" value="{{csrf_token()}}">
	                {{-- </form> --}}
	            </div>
            @endif
            

            <hr>

            <!-- Posted Comments -->
            <!-- Comment -->
            <div id="comment">
				@foreach ($tintuc->comment as $cmt)
	            	<div class="media">
		                <a class="pull-left" href="#">
		                    <img class="media-object" src="http://placehold.it/64x64" alt="">
		                </a>
		                <div class="media-body">
		                    <h4 class="media-heading">
		                    	{!! $cmt->user->name !!}
		                        <small>{!! $cmt->created_at !!}</small>
		                    </h4>
		                    <p>{!! $cmt->NoiDung !!}</p>
		                </div>
		            </div>
	            @endforeach
            
        	</div>
        </div>

        <!-- Blog Sidebar Widgets Column -->
        <div class="col-md-3">

            <div class="panel panel-default">
                <div class="panel-heading"><b>Tin liên quan</b></div>
                <div class="panel-body">
					@foreach ($tinLienQuan as $tlq)
						<!-- item -->
	                    <div class="row" style="margin-top: 10px;">
	                        <div class="col-md-5">
	                            <a href="tintuc/{{ $tlq->id }}/{{ $tlq->TieuDeKhongDau }}.html">
	                                <img class="img-responsive" src="upload/tintuc/{{ $tlq->Hinh }}" alt="">
	                            </a>
	                        </div>
	                        <div class="col-md-7">
	                            <a href="tintuc/{{ $tlq->id }}/{{ $tlq->TieuDeKhongDau }}.html"><b>{{ $tlq->TieuDe }}</b></a>
	                        </div>
	                        <p style="padding-left: 5px;">
	                        {!! $tlq->TomTat !!}
	                        </p>
	                        <div class="break"></div>
	                    </div>
	                    <!-- end item -->
					@endforeach
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading"><b>Tin nổi bật</b></div>
                <div class="panel-body">
					@foreach ($tinNoiBat as $tnb)
	                    <!-- item -->
	                    <div class="row" style="margin-top: 10px;">
	                        <div class="col-md-5">
	                            <a href="tintuc/{{ $tnb->id }}/{{ $tnb->TieuDeKhongDau }}.html">
	                                <img class="img-responsive" src="upload/tintuc/{{ $tnb->Hinh }}" alt="">
	                            </a>
	                        </div>
	                        <div class="col-md-7">
	                            <a href="tintuc/{{ $tnb->id }}/{{ $tnb->TieuDeKhongDau }}.html"><b>{{ $tnb->TieuDe }}</b></a>
	                        </div>
	                        <p style="padding-left: 5px;">{!! $tnb->TomTat !!}</p>
	                        <div class="break"></div>
	                    </div>
	                    <!-- end item -->
	                @endforeach
                </div>
            </div>
            
        </div>

    </div>
    <!-- /.row -->
</div>
<!-- end Page Content -->
@endsection

@section('script')

    <script type="text/javascript">
    $(document).ready(function(){
            $('#submit').on("click",(function(){
                var idTinTuc = $("#idTinTuc").val();
		   		var NoiDungTT = $("#NoiDungTT").val();
                var url = 'ajax/comment/'+idTinTuc;
                var success = function(result){
                    $('#comment').html(result);
                }
                $.get(url,{ NoiDung : NoiDungTT} ,success);
                $("#NoiDungTT").val('');
            });            
        });

    </script>
@endsection
