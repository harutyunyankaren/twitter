<?php

namespace App\Http\Controllers;

use App\Friendship;
use App\Http\Requests;
use App\Post;
use App\User;
use App\Friend;
use App\Massege;

Use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $users = User::where('id', '!=', $user_id)->get();

        $friends = Friendship::where('user_id', $user_id)->where('accepted', 1)
            ->orWhere('friend_id', $user_id)->where('accepted', 1)->get();

        $friends_array = array();
        foreach ($friends as $friend){
            if($friend->friend_id == $user_id){
                $friends_array[] = $friend->user_id;
            };
            if($friend->user_id == $user_id){
                $friends_array[] = $friend->friend_id;
            };
        }

        $friends_requests = Friendship::where('user_id', $user_id)->where('accepted', 0)->get();
        $friends_requests_array = array();
        foreach ($friends_requests as $friend_request){
            $friends_requests_array[] = $friend_request->friend_id;
        }

        $requests = $user::whereHas('friendships1' , function ($query) use ($user_id) {
            $query->where('accepted', 0)->where('friend_id', $user_id);
        })->get();

        $array_requests = array();
        foreach ($requests as $request){
            $array_requests[] = $request->id;
        }

        $folows = Friend::where('u_id', $user_id)->get();
        $folows_array = array();
        foreach ($folows as $folow){
            $folows_array[] = $folow->f_id;
        }

        $user->load('friends.posts');
        $friends_post = array();
        foreach ($user->friends as $friend){
            foreach ($friend->posts as $post){
              $friends_post[] = $post->toArray();
            }
        }
        $collection = collect($friends_post);
        $friends_post = $collection->sortByDesc('created_at');

        return view('home', compact('friends_post', 'users', 'folows_array', 'friends_array', 'friends_requests_array',
            'array_requests'));
    }
}
