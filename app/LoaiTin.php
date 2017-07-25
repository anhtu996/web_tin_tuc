<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoaiTin extends Model
{
    protected $table = 'LoaiTin';

    public function theLoai()
    {	
    	return $this->belongsTo('App\TheLoai','idTheLoai','id');
    }

    public function tinTuc()
    {	
    	return $this->hasMany('App\TinTuc','idLoaiTin','id');
    }
}
