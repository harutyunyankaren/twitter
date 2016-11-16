@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h3> My Friends </h3>
                @foreach($friends['relations'] as $friend)
                    @if(isset($friend) && !empty($friend))
                        @foreach($friend as $f)
                            <div>
                                @if(isset($f['relations']) && ($f['accepted'] == 1) && isset($f['relations']['friend'])
                                    && isset($f['relations']['friend']['name']))
                                    <div class="col-lg-3"> <h4> {{ $f['relations']['friend']['name'] }}</h4></div>
                                    <div class="col-lg-9">
                                        <a href="/chat/{{ $f['relations']['friend']['id'] }}" class="btn btn-default"
                                           data-friend-id="{{ $f['relations']['friend']['id'] }}">massege</a>
                                    </div>
                                    <br/><br/><br/>

                                @endif

                                @if(isset($f['relations']) && ($f['accepted'] == 1) && isset($f['relations']['friend2'])
                                    && isset($f['relations']['friend2']['name']))
                                        <div class="col-lg-3"> <h4> {{ $f['relations']['friend2']['name'] }}</h4></div>
                                        <div class="col-lg-9">
                                            <a href="/chat/{{ $f['relations']['friend2']['id'] }}" class="btn btn-default "
                                               data-friend-id="{{ $f['relations']['friend2']['id'] }}">massege</a>
                                        </div>
                                        <br/><br/><br/>
                                @endif
                            </div>
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{--<div class="col-lg-6">--}}
                {{--<h3> Friend Requests</h3>--}}
                    {{--@foreach($requests as $request)--}}
                    {{--<span class="requestFriendName">{{ $request->name }}</span>--}}
                        {{--<button class="accept btn btn-default" data-friend-id="{{ $request->id }}"> Accept </button>--}}
                        {{--<button class="cencel btn btn-default" data-friend-id="{{ $request->id }}"> Cencel</button>--}}
                        {{--<br/>--}}
                    {{--@endforeach--}}
            {{--</div>--}}
        </div>
    </div>
@endsection