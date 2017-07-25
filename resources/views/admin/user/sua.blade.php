@extends('admin.layout.index')
@section('content')

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">User
                    <small>{{ $user->name }}</small>
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
                <form action="admin/user/sua/{{ $user->id }}" method="POST">                  
                    <div class="form-group">
                        <label>Tên User</label>
                        <input class="form-control" value="{{ $user->name }}" name="name" placeholder="Nhập tên user" />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" value="{{ $user->email }}" name="email" placeholder="Nhập địa chỉ email" readonly="" />
                    </div>
                    
                    <div class="form-group">
                        <label>Đổi mật khẩu</label>
                        <input type="checkbox" name="changePass" id="changePass">
                        <input type="password" class="form-control password" name="password" placeholder="Nhập password"  disabled="" />
                    </div>
                    <div class="form-group">
                        <label>Nhập lại Password</label>
                        <input type="password" class="form-control password" name="password2" placeholder="Nhập lại password" disabled=""/>
                    </div>
                    <div class="form-group">
                        <label>Quyền</label>
                        <select class="form-control" name="quyen">
                            <option value="0">Người dùng</option>
                            <option 
                            @if ($user->quyen==1)
                                {{" selected "}}
                            @endif
                            value="1">Admin</option>
                        </select>
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
        $(document).ready(function(){
            $('#changePass').change(function(){
                if($(this).is(":checked")){
                    $('.password').removeAttr('disabled');
                }else {
                    $('.password').attr('disabled','');
                }
            });            
        });
    </script>           
@endsection