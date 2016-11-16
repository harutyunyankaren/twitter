@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" >
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-sm-6 col-md-4">
                            <img src={{ URL::asset('upload/profile_images.jpg') }} alt="" id="profile_image"
                                 class="img-rounded img-responsive"/>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <h2> {{ $user->name }}</h2>
                            <h4>{{ $user->email }}</h4>
                        </div>
                        <div class="col-sm-3 col-md-3" id="timestep">
                            <h5>Created at -{{ $user->created_at }}</h5>
                            <h5>Updated at - {{ $user->updated_at }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 col-lg-offset-1">
                <div class="row">
                    <div class="col-md-12 ">
                        <div class="text-center"><h2>New Post</h2></div>
                        <form class="form-horizontal" role="form" method="post" action="/create-post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="message" class="col-sm-2 control-label">Text</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" rows="4" name="text"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <input id="submit" name="submit" type="submit" value="Create Post" class="btn btn-primary">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7 col-lg-offset-2">
                @foreach($posts as $post)
                        <div class="row">
                            <div class="thumbnail">
                                <div class="caption ">
                                    <h3>{{ $post->title }}</h3>
                                    <p>{{ $post->text }}</p>
                                    <p>{{ $post->created_at }}</p>
                                </div>
                            </div>
                        </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
