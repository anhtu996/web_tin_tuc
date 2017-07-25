<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoaiTin;
use App\TheLoai;
use App\TinTuc;
class TinTucController extends Controller
{
    public function getDanhSach(){
    	$tintuc = TinTuc::orderBy('id','DESC')->get();
    	return view('admin.tintuc.danhsach',['tintuc'=>$tintuc]);
    }

    public function getThem(){
    	$theloai = TheLoai::all();
    	$loaitin = LoaiTin::all();
    	return view('admin.tintuc.them',['theloai'=>$theloai,'loaitin'=>$loaitin]);
    }

    public function postThem(Request $request){
    	$this->validate(
    		$request,
    	 	[
    	 		'LoaiTin'=>'required',
                'TieuDe'=>'required|unique:TinTuc,TieuDe|min:3',
                'TomTat' => 'required',
                'NoiDung' => 'required'
    	 	],
    	 	[
    	 		'LoaiTin.required' => 'Bạn chưa nhập loại tin',
    	 		'TieuDe.required' => 'Bạn chưa nhập tiêu đề',
    	 		'TieuDe.unique' =>'Tên tiêu đề đã bị trùng',
    	 		'Ten.min' =>'Tên thể loại phải có ít nhất 3 kí tự',
                'TomTat.required' =>'Bạn chưa nhập tóm tắt',
                'NoiDung.required' =>'Bạn chưa nhập nội dung',

    	 	]
    	);
    	$tintuc = new TinTuc;

    	$tintuc->TieuDe = $request->TieuDe;
    	$tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;
        $tintuc->SoLuotXem = 0;


        if ($request->hasFile('Hinh')) {
            $file = $request->file('Hinh');
            $duoi = $file->getClientOriginalExtension();
            if ( $duoi != "jpg" && $duoi != "png" && $duoi !="jpeg") {
                return redirect('admin/tintuc/them')->with('loi','Bạn chỉ được phép nhập ảnh');
            }
            $name = $file->getClientOriginalName();
            $Hinh = str_random(4) . "_" . $name;
            while (file_exists('upload/tintuc/'.$Hinh)) {
                $Hinh = str_random(4) . "_" . $name;
            }
            $file->move("upload/tintuc",$Hinh);
            $tintuc->Hinh = $Hinh;
        }else{
            $tintuc->Hinh ="";
        }

    	$tintuc->save();
    	return redirect('admin/tintuc/them')->with('thongbao','Thêm thành công');
    }

    public function getSua($id){
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
        $tintuc = Tintuc::find($id);
        return view('admin.tintuc.sua',['theloai'=>$theloai,'loaitin'=>$loaitin,'tintuc' => $tintuc]);
    }

    public function postSua(Request $request, $id){
        $tintuc = Tintuc::find($id);
        $this->validate(
            $request,
            [
                'LoaiTin'=>'required',
                'TieuDe'=>'required|min:3',
                'TomTat' => 'required',
                'NoiDung' => 'required'
            ],
            [
                'LoaiTin.required' => 'Bạn chưa nhập loại tin',
                'TieuDe.required' => 'Bạn chưa nhập tiêu đề',
                'Ten.min' =>'Tên thể loại phải có ít nhất 3 kí tự',
                'TomTat.required' =>'Bạn chưa nhập tóm tắt',
                'NoiDung.required' =>'Bạn chưa nhập nội dung',

            ]
        );
        if ($tintuc->TieuDe != $request->TieuDe) {
            $this->validate(
                $request,
                ['TieuDe'=>'unique:TinTuc,TieuDe'],
                ['TieuDe.unique' =>'Tên tiêu đề đã bị trùng']
            );
        }
        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;

        if ($request->hasFile('Hinh')) {
            $file = $request->file('Hinh');
            $duoi = $file->getClientOriginalExtension();
            if ( $duoi != "jpg" && $duoi != "png" && $duoi !="jpeg") {
                return redirect('admin/tintuc/them')->with('loi','Bạn chỉ được phép nhập ảnh');
            }
            $name = $file->getClientOriginalName();
            $Hinh = str_random(4) . "_" . $name;
            while (file_exists('upload/tintuc/'.$Hinh)) {
                $Hinh = str_random(4) . "_" . $name;
            }
            $file->move("upload/tintuc",$Hinh);
            if(file_exists("upload/tintuc/".$tintuc->Hinh))
                unlink("upload/tintuc/".$tintuc->Hinh);
            $tintuc->Hinh = $Hinh;
        }
        $tintuc->save();
        return redirect('admin/tintuc/sua/'.$id)->with('thongbao','sửa thành công');
    }

    public function getXoa($id){
    	$tintuc =TinTuc::find($id);
        if(file_exists("upload/tintuc/".$tintuc->Hinh))
            unlink("upload/tintuc/".$tintuc->Hinh);
    	$tintuc->delete();
    	return redirect('admin/tintuc/danhsach')->with('thongbao','Xóa thành công');
    }
}
