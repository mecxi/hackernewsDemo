@extends('layout.master')


@section('contents')
    <h1>{{ $title }}</h1>
    <!-- comment header title -->
    <ul id="items" style="border-top: 1px solid #ddd7d7;">
        <li class="item">
            <a href="{{ $story->url }}"><span class="item-title">{{ $story->title }}</span></a><br/>
            <span class="item-info-comment">posted {{ $story->date_created  }} by {{ $story->by }} <a href="/comments/{{$story->id }}">{{ $story->comments_count }}</a></span>
        </li>
    </ul>
    <!-- /comment header title -->

    <!-- comments replies -->
    <ul id="items-caret">
        @foreach($comments as $comment)
            {!! format_tree_view($comment) !!}
        @endforeach
    </ul>
    <!-- /comments replies -->
@endsection

{{--<ul id="items-caret">--}}
    {{--<li><span class="caret">by todsacerdoti posted 2 days</span>--}}
        {{--<span class="caret-desc">this is some description</span>--}}
        {{--<ul class="nested">--}}
            {{--<li>Water<span class="no-caret-desc">this is some description</span></li>--}}
            {{--<li>Coffee</li>--}}
            {{--<li><span class="caret">Tea</span>--}}
                {{--<ul class="nested">--}}
                    {{--<li>Black Tea</li>--}}
                    {{--<li>White Tea</li>--}}
                    {{--<li><span class="caret">Green Tea</span>--}}
                        {{--<ul class="nested">--}}
                            {{--<li>Sencha</li>--}}
                            {{--<li>Gyokuro</li>--}}
                            {{--<li>Matcha</li>--}}
                            {{--<li>Pi Lo Chun</li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li><span class="caret">Tea</span>--}}
                {{--<ul class="nested">--}}
                    {{--<li>Black Tea</li>--}}
                    {{--<li>White Tea</li>--}}
                    {{--<li><span class="caret">Green Tea</span>--}}
                        {{--<ul class="nested">--}}
                            {{--<li>Sencha</li>--}}
                            {{--<li>Gyokuro</li>--}}
                            {{--<li>Matcha</li>--}}
                            {{--<li>Pi Lo Chun</li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</li>--}}
        {{--</ul>--}}
    {{--</li>--}}
    {{--<li><span class="caret">Beverages</span>--}}
        {{--<ul class="nested">--}}
            {{--<li>Water</li>--}}
            {{--<li>Coffee</li>--}}
            {{--<li><span class="caret">Tea</span>--}}
                {{--<ul class="nested">--}}
                    {{--<li>Black Tea</li>--}}
                    {{--<li>White Tea</li>--}}
                    {{--<li><span class="caret">Green Tea</span>--}}
                        {{--<ul class="nested">--}}
                            {{--<li>Sencha</li>--}}
                            {{--<li>Gyokuro</li>--}}
                            {{--<li>Matcha</li>--}}
                            {{--<li>Pi Lo Chun</li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li><span class="caret">Tea</span>--}}
                {{--<ul class="nested">--}}
                    {{--<li>Black Tea</li>--}}
                    {{--<li>White Tea</li>--}}
                    {{--<li><span class="caret">Green Tea</span>--}}
                        {{--<ul class="nested">--}}
                            {{--<li>Sencha</li>--}}
                            {{--<li>Gyokuro</li>--}}
                            {{--<li>Matcha</li>--}}
                            {{--<li>Pi Lo Chun</li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</li>--}}
        {{--</ul>--}}
    {{--</li>--}}
{{--</ul>--}}

