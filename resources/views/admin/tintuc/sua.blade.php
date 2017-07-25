@extends('admin.layout.index')
@section('content')

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Tin tức
                    <small>{{ $tintuc->TieuDe }}</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">
                @if(count($errors) > 0)
                   <div class="alert alert-danger">
                       @foreach($errors->all() as $err)
                           {{$err}}
                       @endforeach
                   </div>
               @endif

               @if(session('thongbao'))
                   <div class="alert alert-success">
                       {{session('thongbao')}}

                   </div>
               @endif
               <form action="admin/tintuc/sua/{{ $tintuc->id }}" method="POST" enctype="multipart/form-data">
                   <div class="form-group">
                       <label>Thể loại</label>
                       <select class="form-control" name="TheLoai" id="TheLoai">
                           @foreach($theloai as $tl)
                               <option 
                                @if ($tintuc->loaiTin->theLoai->id == $tl->id)
                                    {{" selected "}}
                                @endif
                               value="{{$tl->id}}">{{$tl->Ten}}</option>
                           @endforeach
                       </select>
                   </div>
                   <div class="form-group">
                       <label>Loại tin</label>
                       <select class="form-control" id="LoaiTin" name="LoaiTin">
                           @foreach($loaitin as $lt)
                               <option 
                                @if ($lt->id == $tintuc->idLoaiTin)
                                    {{" selected "}}
                                @endif
                               value="{{$lt->id}}">{{$lt->Ten}}</option>
                           @endforeach
                       </select>
                   </div>
                   <div class="form-group">
                       <label>Tiêu đề</label>
                       <input class="form-control" name="TieuDe" value="{{ $tintuc->TieuDe }}" placeholder="Nhập tiêu đề" />
                   </div>
                   <div class="form-group">
                       <label>Tóm tắt</label>

                       <textarea  name="TomTat" id="editor1" value="" class="form-control ckeditor" rows="3">{{ $tintuc->TomTat }}</textarea>
                   </div>
                   <div class="form-group">
                       <label>Nội dung</label>
                       <textarea name="NoiDung" id="editor2" value=""  class="form-control ckeditor" rows="5">{{ $tintuc->NoiDung }}</textarea>
                   </div>
                   <div class="form-group">
                       <label>Hình ảnh</label><br/>
                       <img src="upload/tintuc/{{ $tintuc->Hinh }}" alt="{{ $tintuc->Hinh }}" width="300px">
                       <input type="file" class="form-control" name="Hinh" />
                   </div>
                   <div class="form-group">
                       <label>Nổi bật</label>
                       <label class="radio-inline">
                           <input name="NoiBat" value="0" checked="" type="radio">Không
                       </label>
                       <label class="radio-inline">
                           <input 
                            @if ($tintuc->NoiBat == 1)
                                {{" checked "}}
                            @endif
                           name="NoiBat" value="1" type="radio">Có
                       </label>
                   </div>
                   <button type="submit" class="btn btn-default">Sửa</button>
                   <button type="reset" class="btn btn-default">Reset</button>
                   <input type="hidden" name="_token" value="{{csrf_token()}}">
               <form>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Bình luận
                    <small>Danh sách</small>
                </h1>
            </div>
            @if(session('thongbaocomment'))
                <div class="alert alert-success">
                    {{session('thongbaocomment')}}

                </div>
            @endif
            <!-- /.col-lg-12 -->
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr align="center">
                        <th>ID</th>
                        <th>Người dùng</th>
                        <th>Nội dung</th>
                        <th>Ngày Đăng</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tintuc->comment as $cm)
                    <tr class="odd gradeX" align="center">
                        <td>{{$cm->id}}</td>
                        <td>{{$cm->user->name}}</td>
                        <td>{{$cm->NoiDung}}</td>
                        <td>{{$cm->created_at}}</td>
                        <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/comment/xoa/{{$tintuc->id}}/{{ $cm->id }}"> Delete</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#TheLoai').change(function(){
                var idTheLoai = $(this).val();
                var url = 'admin/ajax/loaitin/'+idTheLoai;
                var dataType = 'text';
                var success = function(result){
                    $('#LoaiTin').html(result);
                }
                $.get(url, success, dataType);
            });            
        });
    </script>
@endsection

@section('js')
    <script>
        CKEDITOR.replace( 'editor1', {
            // Define the toolbar groups as it is a more accessible solution.
            toolbarGroups: [
                {"name":"document","groups":["mode"]},
                {"name":"basicstyles","groups":["basicstyles"]},
                {"name":"links","groups":["links"]},
                {"name":"paragraph","groups":["list","blocks"]},
                
                {"name":"insert"},
                {"name":"styles","groups":["styles"]},
                {"name":"about","groups":["about"]}
            ],
            // Remove the redundant buttons from toolbar groups defined above.
           
            removeButtons: 'Flash,Table,HorizontalRule,SpecialChar,PageBreak,Iframe,Subscript,Superscript,Anchor,Styles'
        } );

        CKEDITOR.replace( 'editor2', {
            // Define the toolbar groups as it is a more accessible solution.
            toolbarGroups: [
                {"name":"document","groups":["mode"]},
                {"name":"basicstyles","groups":["basicstyles"]},
                {"name":"links","groups":["links"]},
                {"name":"paragraph","groups":["list","blocks"]},
                
                {"name":"insert"},
                {"name":"styles","groups":["styles"]},
                {"name":"about","groups":["about"]}
            ],
            // Remove the redundant buttons from toolbar groups defined above.
           
            removeButtons: 'Flash,Table,HorizontalRule,SpecialChar,PageBreak,Iframe,Subscript,Superscript,Anchor,Styles'
        } );
    </script>
@endsection