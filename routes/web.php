<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\TheLoai;
Route::get('/', function () {
    return view('welcome');
});

Route::get('admin/dangnhap', 'UserController@getDangnhapAdmin')->middleware('adminLogout');
Route::post('admin/dangnhap', 'UserController@postDangnhapAdmin');
Route::get('admin/logout', 'UserController@getDangXuatAdmin');

Route::group(['prefix'=>'admin','middleware'=>'adminLogin'], function () {
    Route::group(['prefix'=>'theloai'], function (){

    	Route::get('danhsach', 'TheLoaiController@getDanhSach');

	    Route::get('them', 'TheLoaiController@getThem');
	    Route::post('them', 'TheLoaiController@postThem');

	    Route::get('sua/{id}', 'TheLoaiController@getSua');
	    Route::post('sua/{id}', 'TheLoaiController@postSua');

	    Route::get('xoa/{id}', 'TheLoaiController@getXoa');
	    
    });

    Route::group(['prefix'=>'loaitin'], function (){

    	Route::get('danhsach', 'LoaiTinController@getDanhSach');

	    Route::get('them', 'LoaiTinController@getThem');
	    Route::post('them', 'LoaiTinController@postThem');

	    Route::get('sua/{id}', 'LoaiTinController@getSua');
	    Route::post('sua/{id}', 'LoaiTinController@postSua');

	    Route::get('xoa/{id}', 'LoaiTinController@getXoa');
	    
    });

    Route::group(['prefix'=>'tintuc'], function (){

        Route::get('danhsach', 'TintucController@getDanhSach');

        Route::get('them', 'TintucController@getThem');
        Route::post('them', 'TintucController@postThem');

        Route::get('sua/{id}', 'TintucController@getSua');
        Route::post('sua/{id}', 'TintucController@postSua');

        Route::get('xoa/{id}', 'TintucController@getXoa');
        
    });

    Route::group(['prefix'=>'comment'], function (){
        Route::get('xoa/{idTinTuc}/{idComment}', 'CommentController@getXoa');       
    });

    Route::group(['prefix'=>'slide'], function (){

        Route::get('danhsach', 'SlideController@getDanhSach');

        Route::get('them', 'SlideController@getThem');
        Route::post('them', 'SlideController@postThem');

        Route::get('sua/{id}', 'SlideController@getSua');
        Route::post('sua/{id}', 'SlideController@postSua');

        Route::get('xoa/{id}', 'SlideController@getXoa');
        
    });

    Route::group(['prefix'=>'user'], function (){

        Route::get('danhsach', 'UserController@getDanhSach');

        Route::get('them', 'UserController@getThem');
        Route::post('them', 'UserController@postThem');

        Route::get('sua/{id}', 'UserController@getSua');
        Route::post('sua/{id}', 'UserController@postSua');

        Route::get('xoa/{id}', 'UserController@getXoa');
        
    });

    Route::group(['prefix'=>'ajax'], function (){

        Route::any('loaitin/{idTheLoai}', 'AjaxController@getLoaiTin');
        
    });
});

Route::get('trangchu', 'PageController@trangChu');
Route::get('lienhe', 'PageController@lienHe');
Route::get('loaitin/{id}/{tenKhongDau}.html', 'PageController@loaiTin');
Route::get('tintuc/{id}/{tenKhongDau}.html', 'PageController@tinTuc');
Route::get('dangnhap', 'PageController@getDangNhap');
Route::post('dangnhap', 'PageController@postDangNhap');
Route::get('dangxuat', 'PageController@getDangXuat');

Route::get('dangki', 'PageController@getDangKi');
Route::post('dangki', 'PageController@postDangKi');

Route::get('taikhoan', 'PageController@getTaiKhoan');
Route::post('taikhoan', 'PageController@postTaiKhoan');

Route::post('timkiem', 'PageController@timKiem');


Route::group(['prefix'=>'ajax'], function (){
        Route::get('comment/{idTinTuc}', 'AjaxController@getComment');    
});




use App\LoaiTin;
Route::get('thu', function () {
    $theloai = LoaiTin::find(1);
    echo $theloai->theLoai->Ten;
    var_dump($theloai->theLoai);

    // foreach ($theloai->theLoai as $loaitin) {
    // 	echo $loaitin->Ten.'<br/>';
    // }
});

Route::get('thu2', function () {
    return view('admin.loaitin.danhsach');
});



