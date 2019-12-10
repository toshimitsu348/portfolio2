@extends('layouts.app')

@section('content')

<div class="container">
    <h1>投稿内容 編集画面</h1>

    <form action="/post/update/{{$post->id}}" method="POST">
        <!-- ⬆️action属性：ファームが送信（サブミット）された時actionのURLが実行される（web.phpのpostメソッドの/post/storeのURLに飛ばされる）。actionアクション属性がない場合：今いるURLに飛ばされる。つまりRoute::get('/post/postedit/{contribut_id}', 'PostController@edit');このルーティングのpost版Route::post('/post/postedit/{contribut_id}', 'PostController@edit');に飛ばされる（この場合はmethod="POST"だから）。method属性が指定されていないときは自動的にgetメソッドになる。-->
        <div class="form-group">
            <label for="title">タイトル</label>
          <input name="title" id="title" class="form-control" value="{{$post->title}}">
        </div>
        <div class="form-group">
            <label for="content">内容</label>
          <textarea name="content" rows="4" cols="40" id="content" class="form-control">{{$post->content}}</textarea>
        </div>

        {{ csrf_field() }}
        <button class="btn btn-success">完了</button>
    </form>
</div>

@endsection