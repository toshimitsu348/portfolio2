@extends('layouts.app')

@section('content')
<a href="/mypage/profile/">プロフィール</a>
<a href="/mypage/evaluationlist/">評価した投稿</a>
<div class="container">
    <h1>マイページ</h1>
    <h2>投稿リスト</h2>
    @foreach($posts as $post)
        <h2>タイトル：{{ $post->title }}</h2>
        <p>内容：{{ $post->content }}</p>
        <a href="/mypage/postedit/{{$post->id}}" class="btn btn-primary">編集</a>
    @endforeach
</div>

@endsection