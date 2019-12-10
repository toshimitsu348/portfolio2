@extends('layouts.app')

@section('content')
<div class="container">
  <h1>プロフィール</h1>
  @isset($profile)
    <h2>ユーザー名</h2>
    <p>{{ $profile -> name}}</p>
    <h2>自己紹介</h2>
    <p>{{ $profile -> profile }}</p>
    <a href="/mypage/profileedit/">編集</a>
  @endisset
</div>
@endsection