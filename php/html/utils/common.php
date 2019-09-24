<?php
// 共通処理を置く場所

function method_prohibit($method) {
    if ($_SERVER['REQUEST_METHOD'] == $method) {
        echo $method, ' は許可されていないメソッドです。';
        exit(0);
    }
}
?>
