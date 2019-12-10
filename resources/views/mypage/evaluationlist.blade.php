@extends('layouts.app')
<!-- ⬆️layouts.appをエクステンド（引き継ぎ）している。 -->

@section('content')

<div class="container">
    <h1>評価した投稿一覧ページ</h1>
    <a href="/mypage/postlist/">マイページ</a>
    <a href="/mypage/profile/">プロフィール</a>

    @foreach($favorites as $favorite)
        <h2>タイトル：{{ $favorite->title }}</h2>
        <p>名前：{{ $favorite->name }}</p>

    @endforeach
</div>

@endsection