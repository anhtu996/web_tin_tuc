<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TheLoai extends Model
{
    protected $table = 'theloai';

    public function loaiTin()
    {
        return $this->hasMany('App\LoaiTin','idTheLoai','id');
        // idTheloai: là khóa ngoại, id: chính là id của TheLoai
    }

 	//Đối số đầu tiên truyền cho phương thức hasManyThrough là tên của model cuối cùng
  	// chúng ta  muốn truy cập, trong khi đối số thứ 2 là tên của model trung gian.
	// Đối số thứ 3 là foreign key của model trung gian, đối số thứ 4 là foreign key của model cuối cùng và đối số thứ 5 là local key
    public function tinTuc(){
    	return $this->hasManyThrough('App\TinTuc','App\LoaiTin','idTheloai','idLoaiTin','id');
    }
}
