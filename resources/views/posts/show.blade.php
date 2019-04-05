@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-defalut">Back</a>
    <h1>{{$post->title}}</h1>
    <div>
        {{-- Posto predajemo tekst iz textarea kao html
            Da bi ga parsovali stavljamo jednu zagradu i !! uzvicnike--}}
        {!!$post->body!!}
    </div>
    <hr>
    <small>Written on {{$post->created_at}}</small>
@endsection