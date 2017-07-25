<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;//su dung middleware cua auth

use App\LoaiTin;
use App\TinTuc;
use App\Comment;

class AjaxController extends Controller
{
    public function getLoaiTin($idTheLoai)
    {
    	$loaitin = LoaiTin::where('idTheLoai',$idTheLoai)->get();
    	foreach ($loaitin as $lt) {
    		echo "<option value='". $lt->id ."'>". $lt->Ten ."</option>";
    	}
    }

    public function getComment($idTinTuc, Request $request)
    {	
    	
    	$comment  =  new Comment;
    	$comment ->idUser = Auth::user()->id;
    	$comment ->idTinTuc = $idTinTuc;
    	$comment->NoiDung = $request->NoiDung;
    	$comment->save();
    	$comment = Comment::where('idTinTuc',$idTinTuc)->get();

    	foreach ($comment as $cmt) {
            echo 
            '<div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="http://placehold.it/64x64" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">'
                        .$cmt->user->name.
                        '<small>'. $cmt->created_at. '</small>
                    </h4>
                    <p>'. $cmt->NoiDung. '</p>
                </div>
            </div>';
    	}
    }
}
