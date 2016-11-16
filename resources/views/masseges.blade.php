@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-5 col-sm-4 col-xs-4">
                <div class="new-chat-box">
                    @foreach($compacts as $compact)
                        @if($compact['read'] == 0 && $compact['sender_id'] != Auth::user()->id)
                            <div class="newMassege read alert alert-info row" data-id="{{ $compact['sender_id'] }}"
                                data-auth-name="{{ Auth::user()->name }}" data-auth-id="{{ Auth::user()->id }}">
                                <div class="col-lg-3"> <h4>{{ $compact['name'] }}</h4></div>
                                <div class="col-lg-6"> {{ $compact['massege'] }}</div>
                                <input type="hidden" data-sender-id="{{ $compact['sender_id'] }}" id="{{ $compact['sender_id'] }}">
                                    <div class="col-lg-1 badge badge-newmessage" data-sender-id="{{ $compact['sender_id'] }}"
                                         @if($compact['unread'] <= 0) style="display: none" @endif>
                                        {{ (isset($compact['unread']) && !empty($compact['unread'] )) ? $compact['unread']  : '' }}
                                    </div>

                            </div>
                        @else
                            @if($compact['sender_id'] == Auth::user()->id)
                                <div class="newMassege read alert alert-success row" data-id="{{ $compact['getter_id'] }}"
                                     data-auth-name="{{ Auth::user()->name }}" data-auth-id="{{ Auth::user()->id }}">
                                    <div class="col-lg-3"> <h4>{{ $compact['name'] }}</h4></div>
                                    <div class="col-lg-6"> {{ $compact['massege'] }}</div>
                                    <input type="hidden" data-sender-id="{{ $compact['sender_id'] }}" id="{{ $compact['sender_id'] }}">
                                    <div class="col-lg-1 badge badge-newmessage"
                                         @if($compact['unread'] <= 0) style="display: none" @endif
                                    > {{ (isset($compact['unread']) && !empty($compact['unread'] )) ? $compact['unread']  : '' }} </div>

                                </div>
                            @else
                                <div class="newMassege read alert alert-success row" data-id="{{ $compact['sender_id'] }}"
                                     data-auth-name="{{ Auth::user()->name }}" data-auth-id="{{ Auth::user()->id }}">
                                    <div class="col-lg-3"> <h4>{{ $compact['name'] }}</h4></div>
                                    <div class="col-lg-6"> {{ $compact['massege'] }}</div>
                                    <input type="hidden" data-sender-id="{{ $compact['sender_id'] }}" id="{{ $compact['sender_id'] }}">
                                    <div class="col-lg-1 badge badge-newmessage"
                                         @if($compact['unread'] <= 0) style="display: none" @endif
                                    > {{ (isset($compact['unread']) && !empty($compact['unread'] )) ? $compact['unread']  : '' }} </div>

                                </div>
                            @endif

                        @endif
                    @endforeach
                </div>
            </div>

            <div class="chat-box  col-lg-4 col-md-5 col-sm-8 col-xs-8">
                <div class="chat" id="scroll"></div>
            </div>
        </div>
    </div>
@endsection
<script type="text/javascript" src="{{ asset('/js/jquery-3.1.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/plugins/bootstrap/js/bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/getCountMessages.js') }}"></script>
