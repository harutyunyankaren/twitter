<?php

namespace App\Http\Controllers;

use App\Friendship;
use Auth;
use Illuminate\Http\Request;
use Response;
use App\User;
use App\Massege;


class FriendController extends Controller
{
    public function showFriends(){
        $user = Auth::user();
        $user_id = $user->id;
        $friends = $user->load('friendships1', 'friendships2', 'friendships1.friend', 'friendships2.friend2');

        $requests = $user::whereHas('friendships1' , function ($query) use ($user_id) {
                    $query->where('accepted', 0)->where('friend_id', $user_id);
                })->get();

        return view('friends', compact('friends', 'requests'));
    }

    public function friendRequest(Request $request){
        $user = Auth::user();
        $user_id = $user->id;
        if(\Request::ajax()){
            $friendship = new Friendship();
            $friendship->friend_id = $request->friend_id;
            $friendship->user_id = $user_id;
            if($user->friendships1()->save($friendship)){
                return Response::json(['save' => true ]);
            } else{
                return Response::json(['save' => false]);
            }
        };
    }

    public function cancelOrDeleteFriendRequest(Request $request){
        $user = Auth::user();
        $auth_id = $user->id;

        if (\Request::ajax()) {
            $friend_id = $request['friend_id'];
            $friendship = Friendship::where('friend_id', $friend_id)->where('user_id', $auth_id)
                ->orWhere('user_id', $friend_id)->where('friend_id', $auth_id)->first();

            $friendship->delete();

            if ($friendship) {
                return Response::json(['removed' => true]);
            } else {
                return Response::json(['removed' => false]);
            }
        }
    }

    public function acceptFriendRequest(Request $request){
        $user = Auth::user();
        $auth_id = $user->id;

        if(\Request::ajax()){
            $friend_id = $request['friend_id'];
            $addFriend = Friendship::where('friend_id', $friend_id)->where('user_id', $auth_id)->where('accepted', 0)
                ->orWhere('user_id', $friend_id)->where('friend_id', $auth_id)->first()->where('accepted', 0)->first();
            $accept = Friendship::find($addFriend->id);
            $accept->accepted = "1";
            if($accept->save()){
                return Response::json(['save' => true ]);
            } else{
                return Response::json(['save' => false]);
            }
        }
    }

    public function searchUsers(Request $request){
        $query = $request->searchUsers;
        $users=User::where('name','LIKE',''.$query.'%')->get();

        $data=array();
        foreach ($users as $user) {
            $data[]=array(
                'id'=>$user->id,
                'name'=>$user->name,
                'email'=>$user->email,
                'created_at'=>$user->created_at,
                'updated_at'=>$user->updated_at,
            );
        }
        return view('/searchUsers',compact('data', $data));
    }

}
