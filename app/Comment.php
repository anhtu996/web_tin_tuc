<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'Comments';

    public function tinTuc()
    {	
    	return $this->belongsTo('App\TinTuc','idTinTuc','id');
    }

    public function user()
    {	
    	return $this->belongsTo('App\User','idUser','id');
    }
}
