@extends('layouts.app')
<!-- ⬆️layouts.appをエクステンド（引き継ぎ）している。 -->

@section('content')

<div class="container">
    <h1>トップページ</h1>
    <div class="mb-4">
        <a href="/post/create" class="btn btn-primary">解説新規作成</a>
        <a href="/mypage/postlist/" class="btn btn-success">マイページ</a>
    </div>

    <div id="post-list"></div>
</div>

@endsection