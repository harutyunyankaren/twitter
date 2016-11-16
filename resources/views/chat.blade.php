@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-5 col-sm-8 col-xs-8">
                <div class="chat-box" >

                    @if(isset($masseges) && !empty($masseges))
                        <input type="hidden" name="room_id" value="{{ $masseges[0]['room_id'] }}">
                        <input type="hidden" name="sender_id" value="{{ $masseges[0]['sender_id'] }}">
                        <h3>Chat with {{ $user->name }}</h3>
                        <div class="chat" id="scroll">
                            @foreach($masseges as $massege)
                                @if($massege->sender_id == Auth::user()->id)
                                    <div class="me"> {{'You : '. $massege->massege }} </div>
                                @else
                                    <div class="you"> {{$massege->massege.' : ' .$user->name}} </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        {{ dd('not massege') }}
                        <h3>No Chat with {{ $user->name }}</h3>
                    @endif
                </div>
                <br/>
                <input type="text" id="text" class="form-control send read-chat-box" data-friend-id="{{ $user->id }}"
                       data-auth-name="{{ Auth::user()->name }}">
            </div>
        </div>
    </div>
@endsection