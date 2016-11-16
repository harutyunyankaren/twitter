<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Response;
use App\Post;
use App\User;
use App\Friend;
use App\Massege;
use Auth;

class PostController extends Controller
{
    public function createPost(Request $request){
        $user = Auth::user();
        $post = new Post();
        $post->title = $request->title;
        $post->text = $request->text;
        $user->posts()->save($post);
        return redirect('/profile');

    }

    public function showProfile(){
        $user = Auth::user();
        $user_id = $user->id;

        $posts = Post::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();

        return view('/profile', compact('posts', 'user'));
    }

    public function folow(Request $request){
        $user = Auth::user();
        if (\Request::ajax()){
            $f_id = $request['f_id'];
            $friend = new Friend();
            $friend->f_id = $f_id;

            if($user->friends()->save($friend))
            {
                return Response::json(['save' => true ]);
            } else{
                return Response::json(['save' => false]);
            }
        };
    }

    public function notFolow(Request $request)
    {
        $user = Auth::user();
        if (\Request::ajax()) {
            $f_id = $request['f_id'];
            if (Friend::where('f_id', $f_id)->delete()) {
                return Response::json(['removed' => true]);
            } else {
                return Response::json(['removed' => false]);
            }
        }
    }


    public function addFriend(Request $request){
        $friend_id = $request->friend_id;
//        dd($friend_id);

    }
}
