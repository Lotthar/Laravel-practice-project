@extends('layouts.app')

@section('content')
    <h1>Posts</h1>
    @if (count($posts) > 0)
        @foreach ($posts as $post)
            <div class="card text-white bg-dark mb-3">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img style="width:100%;" src="/storage/cover_images/{{ $post->cover_image }}" alt="">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        @if (Auth::user() == null || Auth::user() == '')
                            <h3 class="card-header">{{$post->title}}</h3>
                            <p>{{ $post->body }}</p>
                            <small class="card-body">Written on {{$post->created_at}} by {{ $post->user->name }}</small>
                        @else
                            <h3 class="card-header"><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
                            <p>{{ $post->body }}</p>
                            <small class="card-body">Written on {{$post->created_at}} by {{ $post->user->name }}</small>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        {{$posts->links()}}
    @else
        <p>No posts found</p>
    @endif
@endsection
