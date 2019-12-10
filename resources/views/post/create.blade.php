@extends('layouts.app')

@section('content')

<div class="container">
    <h1>解説内容作成</h1>
    <!-- フォームエリア -->
    <h2>フォーム</h2>
    <!--actionの説明→ formタグに指定する属性で、必ず指定しなければならない。フォームの送信ボタンを押して送信されるデータの送信先を指する。データの送信先のことをURIという。 -->
    <form action="/post/store" method="POST">
      <div class="form-group">
        <label for="title">関連期間（始）</label>
        <input name="begin_at" id="begin_at" type="date">
      </div>

      <div class="form-group">
        <label for="title">関連期間（終）</label>
        <input name="end_at" id="end_at" type="date">
      </div>

      <div class="form-group">
        <label for="title">タイトル</label>
        <input name="title" id="title" class="form-control">
      </div>

      <div class="form-group">
        <label for="content">内容</label>
        <textarea name="content" rows="4" cols="40" id="content" class="form-control"></textarea>
      </div>
      {{ csrf_field() }}
      <button class="btn btn-success"> 投稿 </button>
    </form>

</div>

@endsection