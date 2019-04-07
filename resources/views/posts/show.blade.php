@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-defalut">Back</a>
    <h1>{{$post->title}}</h1>
    <div>
        <img src="/storage/cover_images/{{ $post->cover_image }}">
        {{-- Posto predajemo tekst iz textarea kao html
            Da bi ga parsovali stavljamo jednu zagradu i !! uzvicnike--}}
        {!!$post->body!!}

    </div>
    <hr>
    <small>Written on {{$post->created_at}} by {{ $post->user->name }}</small>
    <hr>
    {{-- U uslovu naglasavamo da korisnik ukoliko je gost nece moci
        da vidi opcije za brisanje i edit jer nisu njegovi postovi--}}
    @if (!Auth::guest())
        @if (Auth::user()->id == $post->user_id)
            <a href="/posts/{{$post->id}}/edit" class="btn btn-dark">Edit</a>
            {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'float-right', 'enctype' => 'multipart/form-data']) !!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!! Form::close() !!}
        @endif
    @endif
@endsection