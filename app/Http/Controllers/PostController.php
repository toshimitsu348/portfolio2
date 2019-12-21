<?php
// postControllerやFavoriteControllerのことを「リソースコントローラ」と呼ぶ。
namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Favorite;
use Illuminate\Support\Facades\Auth;
// ⬆️Authファイルを読み込む。newされたらインスタンスになる。

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::get();//getによりDBのpostsテーブルのカラムを全件取得し、それを$posts変数に代入。
        $loginuser_id = Auth::id();//Auth::id()はuserテーブル（laravel承認機能のuserテーブル）のidカラムの中からログイン中のid番号（フィールドの中の数値）だけを取得する。
        foreach ($posts as $post) {
            // $post->idをもとに、お気に入りされている件数を取得して、$count変数にいれる
            $count = Favorite::where('post_id', $post->id)->count();
        
            // ↓postのオブジェクトにcountプロパティを追加。
            $post->count = $count;
            //↓is_favoriteプロパティ(お気に入りしていますか？の意味)にtrue（変数の型がBoolean型）が入っている。is_favoriteにtrueが入っているとこの投稿に対して「いいね」してる状態。
            // $post->is_favorite = true;
            $myfavorite = Favorite::where('post_id', $post->id)->where('user_id', $loginuser_id)->first();
            // ↑繰り返しの投稿に対して自分のidで絞り込んでいる。->first()は一件のオブジェクトだけ取得する。->getは全件のデータが配列で取得される。
            
            if ($myfavorite) {
            // php言語による仕様：if()の中に比較演算子やBoolean型を入れなくてもいい感じに判定してくれる。
                $post->is_favorite = true;
                // $postのis_favoriteプロパティーにtrue（Boolean型の値）を代入している。$post->is_favoriteで$post変数にis_favoriteプロパティーを追加している。
            } else {
                $post->is_favorite = false;
            }
        }
        // dd($posts);
        return view('post.index', ['posts' => $posts, 'loginuser_id' => $loginuser_id]);
                                        //$posts変数をpostディレクトリの中のindex.blade.phpへ渡す。 
    }

    public function index2(){
        $apikey = "1fdaa6b20f9180e90ed97dec5e6b0cae"; //TMDbのAPIキー
        $error = "";
        $movieArray = [];

        if (array_key_exists('movie_title', $_GET) && $_GET['movie_title'] != "") {
            $url_Contents = file_get_contents("https://api.themoviedb.org/3/search/movie?api_key=".$apikey."&language=ja-JA&query=".$_GET['movie_title']."&page=1&include_adult=false");
            $movieArray = json_decode($url_Contents, true);
        }
        return view('post.index2', ['movieArray' => $movieArray, 'error' => $error]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');//laravelのresources/views/post/create.blade.phpのファイルを取得してレンダリング（bladeファイルからhtmlに変換すること）する。
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //public function store〜]);までの塊を メソッドと呼ぶ（下記の場合storeメソッドと呼ぶ）
    public function store(Request $request)
    {
        // // 投稿内容の受け取って変数に入れる
        // $begin_at = $request->begin_at;
        // $end_at = $request->end_at;
        // $title = $request->title;
        // $content = $request->content;
        // ⬇︎DB（Post.phpのモデルを介してpostsテーブル）に指定したカラムを保存。
        // Post::create([
        //     'id' => Auth::id(),
        //     'begin_at' => $begin_at,
        //     'end_at' => $end_at,
        //     'title' => $title,
        //     'content' => $content
        // ]);
        //上のコメントアウトされている部分と下のコード同じ内容。
        Post::create([
            //⬆️Postモデルの中のcreateメソッド（クラスに属している関数：メソッド）
            'user_id' => Auth::id(),
            'begin_at' => $request->begin_at,
            'end_at' => $request->end_at,
            'title' => $request->title,
            'content' => $request->content,
            'tmdb_id' => 1
            //⬆️$begin_atなどの変数に代入しないで$requestから直接DBに値を保存
            ]);
            return redirect('/post/index');//指定したページにいってください。
            //⬆️laravelが用意している関数（クラスに属していない関数：関数）　
            // view:指定したファイルを呼び出す。
            // redirect:指定したURLを呼び出す。
            // クラスに属している関数：メソッド
            // クラスに属していない関数：関数
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function favorite($post_id){
        Favorite::create([
            'user_id' => Auth::id(),
            'post_id' => $post_id
        ]);
        return redirect('/post/index');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function postlist()
    {
        $loginuser_id = Auth::id();
        $posts = Post::where('user_id', $loginuser_id)->get();
        return view('mypage.postlist', ['posts' => $posts]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($post_id) {
        $post = Post::find($post_id);
        // findの説明 find()でidを指定して取得
        // Laravelではデータベースのテーブルに「id」というカラムが用意されていることが前提になっています。
        // これを利用した便利な書き方がfind()です。つまり、id番号を指定するだけでget()やfirst()を使わなくてもデータが取得できます。
        // やり方はこうです。
        // $id = 1;
        // $item = \App\Item::find($id);
        // find()を使うとwhere()を使わなくてよくなります。そのためコード量が少なくなるので、特別な理由がない場合はこちらを使うことをおすすめします。
        // また、下のコードのようにidは複数指定することもできます。この場合は複数データが取得されますので、foreach()などを使ってループさせながらデータ取得するといいでしょう。
        // $items = \App\Item::find([1, 2]);

        // Eloquent独自のメソッドとして、主キーを指定してデータを取得する場合は、find()メソッドが使えます。
        // 下のコードの内容は、Frameworkテーブルの id = 1 のレコードを取得する というもの。
        // $data = Framework::find(1);

        return view('mypage.postedit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $post_id) {

        Post::find($post_id)->update([

            'title' => $request->title,
            'content' => $request->content
        ]);
        return redirect("/mypage/postlist/");
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }

    /**
     * 投稿一覧の取得(API用)
     */
    public function list(Request $request) {
        $posts = Post::get();
        $loginuser_id = Auth::id();
        foreach ($posts as $post) {
            $count = Favorite::where('post_id', $post->id)->count();
            $post->count = $count;

            $myfavorite = Favorite::where('post_id', $post->id)->where('user_id', $loginuser_id)->first();
            $post->is_favorite = $myfavorite ? true : false;
        }
        return response()->json(['posts' => $posts, 'is_login' => Auth::check()]);
    }

    // React練習用
    public function counter()
    {
        return view('practice.counter');
    }
}

