import React from "react";

function FavoriteButton(props) {
    const {
        is_favorite,
        is_login,
        count,
        post_id,
        addFavorite,
        deleteFavorite
    } = props;

    // ログインしていない場合
    if (!is_login) {
        return (
            <button className="btn btn-success" data-post-id={post_id} disabled>
                <i className="fas fa-check"></i>
                こちらの機能はログインしないと利用できません
            </button>
        );
    }

    if (is_favorite) {
        // お気に入り登録してある場合
        return (
            <button
                className="btn btn-success"
                onClick={deleteFavorite}
                data-post-id={post_id}
            >
                <i className="fas fa-check"></i> いいね済 {count}
            </button>
        );
    } else {
        // お気に入り登録してない場合
        return (
            <button
                className="btn btn-outline-success"
                onClick={addFavorite}
                data-post-id={post_id}
            >
                <i className="fas fa-thumbs-up"></i> いいね {count}
            </button>
        );
    }
}

export default FavoriteButton;
