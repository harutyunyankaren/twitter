@extends('layouts.app')

@section('content')
    <div class="container">
        @if(empty($data) )
            <h4> Upon request, nothing found.</h4>
        @else
        @foreach($data as $user)
            <div class="row" >
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                    <div class="well well-sm">
                        <div class="row">
                            <div class="col-sm-6 col-md-4">
                                <img src={{ URL::asset('upload/profile_images.jpg') }} alt="" id="profile_image"
                                     class="img-rounded img-responsive"/>
                            </div>
                            <div class="col-sm-3 col-md-3">
                                <h2> {{ $user['name'] }}</h2>
                                <h4>{{ $user['email'] }}</h4>
                            </div>

                            <div class="col-sm-3 col-md-3" id="timestep">
                                <h5>Created at -{{ $user['created_at'] }}</h5>
                                <h5>Updated at - {{ $user['updated_at'] }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        @endif
    </div>
@endsection