<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;//su dung middleware cua auth
use App\Comment;

class CommentController extends Controller
{
    public function getXoa($idTinTuc, $idComment){
    	$comment = Comment::find($idComment);
    	$comment->delete();
    	return redirect('admin/tintuc/sua/'. $idTinTuc)->with('thongbaocomment','Xóa comment thành công');
    }

    
}
