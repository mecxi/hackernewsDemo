@extends('layout.master')

@section('contents')
    <h1>{{ $title }}</h1>
    <ul id="items">
        @foreach($stories as $story)
            <li class="item">
                <span class="item-score">{{ $story->score }}</span>
                <a href="{{ $story->url }}"><span class="item-title">{{ $story->title }}</span></a><br/>
                <span class="item-info">posted {{ $story->date_created  }} by {{ $story->by }} <a href="/comments/{{$story->id }}">{{ $story->comments_count }}</a></span>
            </li>
        @endforeach
    </ul>
@endsection
