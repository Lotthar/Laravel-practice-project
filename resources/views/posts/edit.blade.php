@extends('layouts.app')

@section('content')
    <h1>Edit Post</h1>
    {{-- Predajemo metodu iz Post kontrolera i onaj parametar koji zelimo da promjenimo/editujemo --}}
    {{-- Treaba ponekad da provjerimo koja je vrsta rute koju nasa metoda podrzava --}}
    {{-- Pa onda odraditi takvu vrstu zahtjeva pr (Post,Put,Get...) --}}
    {!! Form::open(['action' => ['PostsController@update', $post->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('title', 'Title')}}
            {{Form::text('title', $post->title , ['class' => 'form-control', 'placeholder' => 'Title'])}}
        </div>
        <div class="form-group">
            {{Form::label('body', 'Body')}}
            {{Form::textarea('body', $post->body , ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body'])}}
        </div>
        <div class="form-group">
            {{Form::file('cover_image')}}
        </div>
        {{-- dodamo skriveno polje ukoliko nam je druga metoda koju zelimo --}}
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection