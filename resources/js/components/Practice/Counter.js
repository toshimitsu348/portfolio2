import React, { Component } from "react";
import ReactDOM from "react-dom";
import axios from "axios";

class Counter extends Component {
    state = { value: "0" };

    onClickHandler = () => {
        this.setState({ value: this.state.value + 1 });
        //................↑プロパティ名(version) ↑変更する値(nextVersion.toFixed(1))
        // this.setState({プロパティ名: 変更する値})とすることで、指定されたプロパティに対応するstateの値が変更されます。
        // その結果、「this.state.name」で表示できる値も変更されます。
        // 今回はボタンがクリックされた時に、名前の表示を変えるために、右の図のようにsetStateをonClick内で行います。
    };

    // ↓メソド(renderのこと)
    render() {
        console.log("表示の確認");
        return (
            <div>
                <div>カウント値：{this.state.value}</div>
                <div>
                    <button type="button" onClick={this.onClickHandler}>
                        +
                    </button>
                </div>
            </div>
        );
    }
}

export default Counter;

if (document.getElementById("a")) {
    ReactDOM.render(<Counter />, document.getElementById("a"));
}
