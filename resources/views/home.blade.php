@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-lg-7">
            @foreach($friends_post as $post)
                <div class="row">
                    <div class="thumbnail">
                        <div class="caption ">
                            <h3>{{ $post['title'] }}</h3>
                            <p>{{ $post['text'] }}</p>
                            <p>{{ $post['created_at'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>



        <div class="col-lg-5 ">
            @foreach($users as $user)
                <div class="row">
                    <div class="col-lg-3" > <p> {{ $user->name }} </p> </div>
                    <div class="tools col-lg-9 row">
                        <div class="col-lg-4">
                            @if(in_array($user->id, $folows_array))
                                <button  class="folow btn btn-warning " data-folow="1" data-friend-id="{{ $user->id }}">
                                    Folowed
                                </button>
                            @else
                                <button  class="folow btn btn-success" data-folow="0" data-friend-id="{{ $user->id }}">
                                    Folow
                                </button>
                            @endif
                        </div>


                        <div class="col-lg-8">
                            @if(in_array($user->id, $friends_array))
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        Friend
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                        <li>
                                            <a class="deleteFriend " data-friend="delete" data-friend-id="{{ $user->id }}" > Delete </a>
                                        </li>
                                    </ul>
                                </div>

                            @elseif(in_array($user->id, $friends_requests_array))
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        Friend Request sent
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                        <li>  <a class="cancelFriendRequest " data-friend="cancel" data-friend-id="{{ $user->id }}">
                                                Cancel Friend Request </a>
                                        </li>
                                    </ul>
                                </div>


                            @elseif(in_array($user->id, $array_requests))

                                <button class="accept btn btn-default" data-friend="accept"
                                        data-friend-id="{{ $user->id }}"> Accept
                                </button>
                                <button class="cancel btn btn-default" data-friend="cencel"
                                        data-friend-id="{{ $user->id }}"> Cencel
                                </button>
                                <br/>
                            @else
                                <button  class="sendFriendRequest btn btn-success" data-friend="send" data-friend-id="{{ $user->id }}">
                                    Add Friend
                                </button>

                            @endif
                        </div>


                    </div>
                </div>
                <br/><br/>
            @endforeach
        </div>
    </div>


    {{----------------- model ----------}}
    <div id="requestSentModel">
        <div class="col-lg-8">
            <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Friend Request sent
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><a class="cancelFriendRequest " data-friend="cancel" data-friend-id="">
                            Cancel Friend Request </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div id="deleteFriendModel">
        <div class="col-lg-8">
            <div class="dropdown" >
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Friend
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li>
                        <a class="deleteFriend " data-friend="delete" data-friend-id="" > Delete </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-8">

    <div id="addFriendModel">
        <button  class="sendFriendRequest btn btn-success" data-friend="send" data-friend-id="">
            Add Friend
        </button>
    </div>
        </div>
    {{------------------------}}



</div>


@endsection
