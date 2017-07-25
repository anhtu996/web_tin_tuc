<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;//su dung middleware cua auth
use App\User;

class UserController extends Controller
{
    public function getDanhSach(){
    	$user = User::all();
    	return view('admin.user.danhsach',['user'=>$user]);
    }
    
    public function getThem(){
    	return view('admin.user.them');
    }

    public function postThem(Request $request){
    	$this->validate(
    		$request,
    	 	[
    	 		'name'=>'required|unique:Users,name|min:3|max:100',
                'email' =>'required|unique:Users,email|min:3|max:100',
                'quyen' =>'required',
                'password' => 'required|min:3|max:32',
                'password2' => 'required|same:password',
    	 	],
    	 	[
    	 		'name.required' => 'Bạn chưa nhập username',
                'name.unique' => 'Username đã tồn tại',
                'email.required' => 'Bạn chưa nhập email',
    	 		'email.unique' => 'email đã tồn tại',
                'quyen.required' => 'Hãy chọn quyền',
                'password.required' => 'Hãy nhập password',
                'password2.required' => 'Hãy nhập lại password',
                'password2.same' => 'Mật khẩu nhập lại chưa đúng',
    	 		'name.min' =>'username phải có độ dài từ 3 đến 100 kí tự',
                'name.max' =>'username phải có độ dài từ 3 đến 100 kí tự',
                'email.min' =>'username phải có độ dài từ 3 đến 100 kí tự',
                'email.max' =>'username phải có độ dài từ 3 đến 100 kí tự',
                'password.min' =>'username phải có độ dài từ 3 đến 100 kí tự',
    	 		'password.max' =>'username phải có độ dài từ 3 đến 100 kí tự'
    	 	]
    	);
    	$user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->quyen = $request->quyen;
    	$user->password = bcrypt($request->password);
    	$user->save();
    	return redirect('admin/user/them')->with('thongbao','Thêm thành công');
    }

    public function getSua($id){
        $user =User::find($id);
        return view('admin.user.sua',['user' => $user]);
    }

    public function postSua(Request $request, $id){
        $user = User::find($id);
        if ($user->name != $request->name) {
            $this->validate(
                $request,
                [
                    'name'=>'required|unique:Users,name|min:3|max:100'
                ],
                [
                    'name.required' => 'Bạn chưa nhập username',
                    'name.unique' => 'Username đã tồn tại',
                    'name.min' =>'username phải có độ dài từ 3 đến 100 kí tự',
                    'name.max' =>'username phải có độ dài từ 3 đến 100 kí tự',
                ]
            );
            $user->name = $request->name;
        }
        $user->quyen = $request->quyen;
        if ($request->changePass =="on") {
            $this->validate(
                $request,
                [
                    'password' => 'required|min:3|max:32',
                    'password2' => 'required|same:password',
                ],
                [
                    'password.required' => 'Hãy nhập password',
                    'password2.required' => 'Hãy nhập lại password',
                    'password2.same' => 'Mật khẩu nhập lại chưa đúng',
                    'password.min' =>'username phải có độ dài từ 3 đến 100 kí tự',
                    'password.max' =>'username phải có độ dài từ 3 đến 100 kí tự'
                ]
            );
            
            $user->password = bcrypt($request->password);
        }
        
        $user->save();
        return redirect('admin/user/sua/'.$id)->with('thongbao','Sửa thành công');
    }

    public function getXoa($id){
    	$user = User::find($id);
    	$user->delete();
    	return redirect('admin/user/danhsach')->with('thongbao','Xóa thành công');
    }

    

    //ham dang nhap
    public function getDangnhapAdmin(){
        return view('admin.login');
    }
    public function postDangnhapAdmin(Request $request){
        $this->validate(
            $request,
            [
                'email'=>'required|min:3|max:100',
                'password' => 'required|min:3|max:32',
            ],
            [
                'email.required' => 'Bạn chưa nhập email',
                'password.required' => 'Bạn chưa nhập password',
                'email.min' =>'username phải có độ dài từ 3 đến 100 kí tự',
                'email.max' =>'username phải có độ dài từ 3 đến 100 kí tự',
                'password.min' =>'password phải có độ dài từ 3 đến 32 kí tự',
                'password.max' =>'password phải có độ dài từ 3 đến 32 kí tự'
            ]
        );
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            return redirect('admin/theloai/danhsach');
        }else{
            return redirect('admin/dangnhap')->with('thongbao','Đăng nhập không thành công');
        }
    }

    public function getDangXuatAdmin(){
        Auth::logout();
        return redirect('admin/dangnhap');
    }
}
