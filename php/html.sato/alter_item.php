<html lang ="ja">
    <head>
        <meta charset="utf-8">
        <mata name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0"
        <meta http-equiv="content-type" content="text/html";charaser="utf-8">
        <!-- <link rel="stylesheet" href="stylesheet-list.css"
        type="text/css"></link> -->
        <meta name="kyeword" content="">
        <meta name="description" content="">
        <title>管理者用ページ -変更ページ</title>
    </head>

    
    <form action="serch.php" method="post">
        <body>
            <h1>PLESER JAPAN -検索画面-</h1>
                <!-- ボタン -->
                <input type="button" onClick="location.href='http://192.168.24.50:8282/register_item.php'"  value="削除">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <input type="text"  name="serch" value="">
                <input type="submit" onClick="location.href='http://192.168.24.50:8282/serch.php'"  value="検索">
                <input type="button"   value="一覧に戻る" onclick="location.href='http://192.168.24.50:8282/admin.add.php'"><br><br>
                <!-- ボタン終わり -->
            <?php
                //データベース接続
                $db = new mysqli('mysql','root','root','shoes_db');
                if ($db->connect_error){
                    echo $db->connect_error;
                    exit();
                    }else{
                        $db->set_charset("utf8");
                    }