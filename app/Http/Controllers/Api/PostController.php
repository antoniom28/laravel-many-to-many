<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        /*return response()->json([
            "name" => 'anto',
            'surname' => 'marc',
        ]);*/

        $posts = Post::where('category_id' , '!=' , null)->get();
        return response()->json($posts);
    }
}
