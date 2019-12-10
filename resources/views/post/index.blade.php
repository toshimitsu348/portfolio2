@extends('layouts.app')
<!-- ⬆️layouts.appをエクステンド（引き継ぎ）している。 -->

@section('content')

<div class="container">
    <h1>トップページ</h1>
    <a href="/post/create">解説新規作成</a>
    <a href="/mypage/postlist/">マイページ</a>

    @foreach($posts as $post)
    <!-- $posts配列の中に$postオブジェクトが複数入っている。[Post, Post, Post];-->
        <h2>タイトル：{{ $post->title }}</h2>
        <!--⬆️$posts配列の中から一つ$postオブジェクトを取り出し、$postオブジェクトからtitleというプロパティーを取り出している。 -->
        <p>名前：{{ $post->name }}</p>
        <p>内容：{{ $post->content }}</p>

        @if($post->is_favorite)
        <a href="/post/favorite/delete/{{$post->id}}" class="btn btn-primary">評価取り消し</a><span>{{$post->count}}</span>
        @else
        <a href="/post/favorite/{{$post->id}}" class="btn btn-primary">評価</a><span>{{$post->count}}</span>
        @endif
    @endforeach
</div>

@endsection