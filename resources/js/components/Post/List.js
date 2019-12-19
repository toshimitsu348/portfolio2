import React, { Component } from "react";
import ReactDOM from "react-dom";
import axios from "axios";
import FavoriteButton from "./FavoriteButton";

class PostList extends Component {
    state = {
        posts: [],
        is_login: false
    };

    async componentDidMount() {
        // 投稿一覧の取得
        const response = await axios.post("/post/list");
        this.setState({
            posts: response.data.posts,
            is_login: response.data.is_login
        });
    }

    // お気に入りに追加
    addFavorite = async event => {
        const post_id = event.target.dataset.postId;
        await axios.post("/post/favorite/create", {
            post_id
        });

        const posts = this.state.posts;
        this.setState({
            posts: posts.map(post => {
                if (post.id == post_id) {
                    post.is_favorite = true;
                    post.count++;
                }
                return post;
            })
        });
    };

    // お気に入りから削除
    deleteFavorite = async event => {
        const post_id = event.target.dataset.postId;
        await axios.post("/post/favorite/delete", {
            post_id
        });

        const posts = this.state.posts;
        this.setState({
            posts: posts.map(post => {
                if (post.id == post_id) {
                    post.is_favorite = false;
                    post.count--;
                }
                return post;
            })
        });
    };

    // 投稿一覧の作成
    createPostList() {
        const { posts, is_login } = this.state;
        return posts.map(post => {
            return (
                <div className="card mb-4" key={`post-${post.id}`}>
                    <h5 className="card-header">{post.title}</h5>
                    <div className="card-body">{post.content}</div>
                    <div className="card-footer">
                        <FavoriteButton
                            is_favorite={post.is_favorite}
                            is_login={is_login}
                            count={post.count}
                            post_id={post.id}
                            addFavorite={this.addFavorite}
                            deleteFavorite={this.deleteFavorite}
                        />
                    </div>
                </div>
            );
        });
    }

    render() {
        const postList = this.createPostList();
        return <div>{postList}</div>;
    }
}

export default PostList;

if (document.getElementById("post-list")) {
    ReactDOM.render(<PostList />, document.getElementById("post-list"));
}
