<?php

// データベース接続関数
function dbconnect() {
    $db = new mysqli('mysql','root','root','shoes_db');

    if ($db->connect_error){
        echo $db->connect_error;
    }else{
        $db->set_charset("utf8");
    };

    return $db;
}
