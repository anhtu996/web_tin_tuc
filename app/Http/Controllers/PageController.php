<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;//su dung middleware cua auth

use App\TheLoai;
use App\Slide;
use App\LoaiTin;
use App\TinTuc;
use App\User;
class PageController extends Controller
{
	function __construct()
	{
		$theloai = TheLoai::all();
		$slide = Slide::all();
		view()->share('theloai',$theloai);		
		view()->share('slide',$slide);		
	}

    public function trangChu()
    {   	
    	return view('pages.trangchu');
    }

    public function lienHe()
    {   	
    	return view('pages.lienhe');
    }

    public function loaitin($id)
    {   
    	$loaitin = LoaiTin::find($id);
    	$tintuc = TinTuc::where('idLoaiTin',$id)->paginate(5);	
    	return view('pages.loaitin',['loaitin' => $loaitin,'tintuc'=>$tintuc]);
    }

    public function tinTuc($id)
    {   
    	$tintuc = TinTuc::find($id);
    	$tinNoiBat = TinTuc::where('id','<>',$id)->where('NoiBat','=',1)->orderBy('created_at','DESC')->take(4)->get();
    	$tinLienQuan = TinTuc::where('id','<>',$id)->where('NoiBat','=',1)->where('idLoaiTin',$tintuc->idLoaiTin)->orderBy('created_at','DESC')->take(4)->get();
    	return view('pages.tintuc',['tintuc'=>$tintuc,'tinNoiBat' =>$tinNoiBat, 'tinLienQuan' => $tinLienQuan]);
    }

    // dang nhap dang xuat
    //ham dang nhap
    public function getDangNhap(){
        return view('pages.dangnhap');
    }
    public function postDangNhap(Request $request){
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

            return redirect('trangchu');
        }else{
            return redirect('trangchu')->with('thongbao','Đăng nhập không thành công');
        }
    }

    public function getDangXuat(){
        Auth::logout();
        return redirect('trangchu');
    }

    //tai khoan
    public function getTaiKhoan(){
        return view('pages.taikhoan');
    }

    public function postTaiKhoan(Request $request){
        $user = Auth::user();
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
        return redirect('taikhoan')->with('thongbao','Sửa thành công');
    }

    public function getDangKi(Request $request){
        return view('pages.dangki');
    }
    public function postDangKi(Request $request){
        $this->validate(
            $request,
            [
                'name'=>'required|unique:Users,name|min:3|max:100',
                'email' =>'required|unique:Users,email|min:3|max:100',
                'password' => 'required|min:3|max:32',
                'password2' => 'required|same:password',
            ],
            [
                'name.required' => 'Bạn chưa nhập username',
                'name.unique' => 'Username đã tồn tại',
                'email.required' => 'Bạn chưa nhập email',
                'email.unique' => 'email đã tồn tại',
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
        $user->quyen = 0;
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect('dangki')->with('thongbao','Đăng kí thành công');
    }

    public function timKiem(Request $request){
        $tukhoa = $request->tukhoa;
        $tintuc = TinTuc::where('TieuDe','like',"%$tukhoa%")->orWhere('TomTat','like',"%$tukhoa%")->orWhere('NoiDung','like',"%$tukhoa%")->take(30)->paginate(5);
        return view('pages.timkiem',['tintuc' => $tintuc, 'tukhoa' => $tukhoa]);
    }


}
