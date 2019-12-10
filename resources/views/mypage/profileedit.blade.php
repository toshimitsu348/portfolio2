@extends('layouts.app')

@section('content')

<div class="container">
    <h1>プロフィール 編集画面</h1>
    <form action="/mypage/profileupdate/" method="POST">
        <!-- ⬆️action属性：ファームが送信（サブミット）された時actionのURLが実行される（web.phpのpostメソッドの/post/storeのURLに飛ばされる）。actionアクション属性がない場合：今いるURLに飛ばされる。つまりRoute::get('/post/postedit/{contribut_id}', 'PostController@edit');このルーティングのpost版Route::post('/post/postedit/{contribut_id}', 'PostController@edit');に飛ばされる（この場合はmethod="POST"だから）。method属性が指定されていないときは自動的にgetメソッドになる。-->
        <div class="form-group">
            <label for="name">ユーザー名</label>
          <input name="name" id="name" class="form-control" value="{{$profile->name}}">
        </div>
        <div class="form-group">
            <label for="profile">自己紹介文</label>
          <textarea name="profile" rows="4" cols="40" id="profile" class="form-control">{{$profile->profile}}</textarea>
        </div>

        {{ csrf_field() }}
        <button class="btn btn-success">完了</button>
    </form>
</div>

@endsection 