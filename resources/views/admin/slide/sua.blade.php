@extends('admin.layout.index')
@section('content')

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Slide
                    <small>{{ $slide->Ten }}</small>
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
                <form action="admin/slide/sua/{{ $slide->id }}" method="POST" enctype="multipart/form-data">
                    
                    <div class="form-group">
                        <label>Tên slide</label>
                        <input class="form-control" value="{{ $slide->Ten }}" name="Ten" placeholder="Nhập tên slide" />
                    </div>
                    <div class="form-group">
                        <label>Hình ảnh</label><br/>
                        <img src="upload/slide/{{ $slide->Hinh }}" width="575px" style="margin-bottom: 15px" alt="{{ $slide->Hinh }}"><br/>
                        <input type="file" value="{{ $slide->Hinh }}"  class="form-control" name="Hinh" />
                    </div>
                    <div class="form-group">
                        <label>Nội dung</label>
                        <textarea name="NoiDung" id="editor1" class="form-control ckeditor" rows="5">{{ $slide->NoiDung }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Link</label>
                        <input class="form-control" value="{{ $slide->link }}" name="Link" placeholder="Nhập link" />
                    </div>
                    <button type="submit" class="btn btn-default">Sửa</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                <form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
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
</script>
@endsection