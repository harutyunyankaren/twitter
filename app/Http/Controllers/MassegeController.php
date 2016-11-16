<?php

namespace App\Http\Controllers;

use App\Massege;
use Illuminate\Http\Request;

use App\Http\Requests;
use Response;
use App\User;
use App\Room;
use Illuminate\Support\Facades\Auth;

class MassegeController extends Controller
{
    public function messages(){
        $user = Auth::user();
        $user_id = $user->id;

        // Get all messages
        $allMessages = Massege::where('getter_id', $user_id)
            ->orwhere('sender_id', $user_id)
            ->orderBy('created_at', 'desc')->get();
        $messages = $allMessages->groupBy('room_id');
        $compacts = array();

        foreach ($messages as $message) {
            $lastMsg = $message->first();
            $msg = $lastMsg->massege;
            $sender_id = $lastMsg['sender_id'];
            $getter_id = $lastMsg['getter_id'];
            $read = $lastMsg['read'];
            if($sender_id == Auth::user()->id){
                $sender = User::find($getter_id);
                $unread = Massege::where('read', 0)->where('getter_id', Auth::user()->id)
                    ->where('sender_id', $getter_id)->count();
            }else{
                $sender = User::find($sender_id);
                $unread = Massege::where('read', 0)->where('getter_id', Auth::user()->id)
                    ->where('sender_id', $sender_id)->count();
            }

            $compacts[] = [ 'sender_id' => $sender_id, 'getter_id' => $getter_id, 'name' => $sender->name,
                'massege' => $msg, 'read' => $read, 'unread' => $unread];
        }
        return view('masseges', compact('compacts'));
    }


    public function showChat($id){

        $us = Auth::user();
        $friends = $us->load('friendships1', 'friendships2', 'friendships1.friend', 'friendships2.friend2');
        $user = User::find($id);
        $sender_id = Auth::user()->id;
        $getter_id = $id;
        $masseges = Massege::where('sender_id', $sender_id)->where('getter_id', $getter_id)
            ->orWhere('sender_id', $getter_id)->where('getter_id', $sender_id);
        $chatsCount = $masseges->count();
        $masseges = $masseges->skip($chatsCount - 20)->take(20)->get();
        return view('chat', compact('masseges', 'user', 'friends'));
    }

    public function sendMessage(Request $request){
        $sender_id = Auth::user()->id;

        if (\Request::ajax()){

            $room = Room::where('user1_id', $sender_id)->where('user2_id', $request->getter_id)->
                orWhere('user1_id', $request->getter_id)->where('user2_id', $sender_id)->first();
            if ($room){
                $room_id = $room->id;
                $message = new Massege();
                $message->sender_id = $sender_id;
                $message->massege = $request->input('text');
                $message->getter_id = $request->getter_id;
                $message->room_id = $room_id;

                if($message->save()){
                    return Response::json($room_id);
                } else{
                    return Response::json(['save' => false]);
                }
            } else{
                $newRoom = new Room();
                $newRoom->user1_id = $sender_id;
                $newRoom->user2_id = $request->getter_id;
                $newRoom->save();
                $room = Room::where('user1_id', $sender_id)->where('user2_id', $request->getter_id)->first();
                $room_id = $room->id;
                $message = new Massege();
                $message->sender_id = $sender_id;
                $message->massege = $request->input('text');
                $message->getter_id = $request->getter_id;
                $message->room_id = $room_id;

                if($message->save() && $newRoom->save()){
                    return Response::json($room_id);
                } else{
                    return Response::json(['save' => false]);
                }
            }


        };

    }

    public function readMessage(Request $request){
        $getter_id = Auth::user()->id;

        if (\Request::ajax()){
            $sender_id = $request->getter_id;

            $newMasseges = Massege::where('sender_id', $sender_id)->where('getter_id', $getter_id)->where('read',0)->get();
            foreach ($newMasseges as $newMassege){
                $newMassege = Massege::find($newMassege->id);
                $newMassege->read = 1;
                $newMassege->save();
            }
        }
    }


    public function newMessage(Request $request){
        $getter_id = Auth::user()->id;
        if (\Request::ajax()){
            $sender_id = $request->sender_id;
            $user = User::find($sender_id);
            $sender_name = $user->name;
            $getter_name = Auth::user()->name;
            $newChats = Massege::where('sender_id', $sender_id)->where('getter_id', $getter_id)
                ->orWhere('sender_id', $getter_id)->where('getter_id', $sender_id);
            $chatsCount = $newChats->count();
            $newChats = $newChats->skip($chatsCount - 20)->take(20)->get();
            $chats[] = ['messages' => $newChats, 'sender_name' => $sender_name];

            if ($chats){
                return Response::json($chats);
            } else{
                return Response::json(['not_massege' => false]);
            }
        }
    }

    public function updateMessage(Request $request){
        if (\Request::ajax()){
            $sender_id = $request->sender_id;
            $user = User::find($sender_id);
            $sender_name = $user->name;
            $room_id = $request->room_id;
            $newMessages  = Massege::where('room_id', $room_id)->where('read', 0)
                ->where('getter_id', Auth::user()->id)->get();

            $chats = ['messages' => $newMessages, 'sender_name' => $sender_name];
            if ($newMessages){
                return Response::json($chats);
            } else{
                return Response::json('not_new_massege');
            }

        }
    }

    public function updateCountUserMessage(Request $request){
        if(\Request::ajax()){
            $countMessages = Massege::where('read', 0)->where('getter_id', Auth::user()->id)->get();
            $a = $countMessages->groupBy('room_id');
            $countUserMessage = $a->count();
        }
        if ($countUserMessage > 0){
            return response::json($countUserMessage);
        }
        else {
            return response::json('');
        }
    }

    public function updateNewMessage(){
        $user = Auth::user();
        $user_id = $user->id;
        if (\Request::ajax()){
            $newMessage = Massege::where('getter_id', Auth::user()->id)
                ->orwhere('sender_id', $user_id)
                ->orderBy('created_at', 'desc')->get();

            $newMessages = $newMessage->groupBy('room_id');
            if ($newMessages->count() > 0) {
                foreach ($newMessages as $message) {
                    $lastMsg = $message->first();
                    $msg = $lastMsg->massege;
                    $read = $lastMsg['read'];
                    $sender_id = $lastMsg['sender_id'];
                    $getter_id = $lastMsg['getter_id'];
                    if ($sender_id == Auth::user()->id) {
                        $sender = User::find($getter_id);
                        $unread = Massege::where('read', 0)->where('getter_id', Auth::user()->id)
                            ->where('sender_id', $getter_id)->count();
                    } else {
                        $sender = User::find($sender_id);
                        $unread = Massege::where('read', 0)->where('getter_id', Auth::user()->id)
                            ->where('sender_id', $sender_id)->count();
                    }

                    $compacts[] = ['sender_id' => $sender_id, 'getter_id' => $getter_id, 'name' => $sender->name,
                        'massege' => $msg, 'read' => $read, 'unread' => $unread];
                }
                return response::json($compacts);
            }
            else {
                return response::json('Not new messages');
            }




        }
    }

}
