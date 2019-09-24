<?php
session_start();
?>

<html lang ="ja">
    <head>
        <meta charset="utf-8">
        <mata name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0"
        <meta http-equiv="content-type" content="text/html";charaser="utf-8">
        <!-- <link rel="stylesheet" href="stylesheet-list.css"
        type="text/css"></link> -->
        <meta name="kyeword" content="">
        <meta name="description" content="">
        <title>管理者用ページ</title>
    </head>

    <body>
        <h1>PLESER JAPAN</h1>
        <!-- ボタン -->
            <form action="" method="get">
                <input type="text"  name="search" value="">
                <input type="submit" onClick="location.href='http://192.168.24.50:8282/admin.add.php'"  value="検索">
               
            </form>
            <form action="add_stocks_newitem.php">
                <input type="submit" name="new_item" value="新規追加" >


            </form>
         <!-- ボタン終わり -->


            <div class="all_items">

            <?php
                //データベース接続
                $db = new mysqli('mysql','root','root','shoes_db');
                if ($db->connect_error){
                    echo $db->connect_error;
                    exit();
                    }else{
                        $db->set_charset("utf8");
                    }

                //検索の変数を受け取る
                $search = "$_GET[search]";
                 //もし変数$searchに値がなければ一覧を表示、あれば検索結果を表示する
                 if (empty($search)) {
                    $sql =  "select items.number,type,about,maker,cost,selling_price,       stock,stocks.id,stock,product_status,color,size from           items"
                            ." join stocks on items.number=stocks.number"
                            ." order by items.number";
                 } else {
                    $sql =  "select items.number,type,about,maker,cost,selling_price,stock,stocks.id,stock,product_status,color,size from items"
                            ." join stocks on items.number=stocks.number"
                            ." and items.number like '%$search%'"
                            ." order by items.number";
                 }

                echo '<table border="1" frame="border" style="table-layout:fixed">';
                echo   '<tr>';
                echo        '<th width=2%></th>';
                echo        '<th width=10%>number</th>';
                echo        '<th width=10%>type</th>';
                echo        '<th width=10%>about</th>';
                echo        '<th width=5%>maker</th>';
                echo        '<th width=5%>cost</th>';
                echo        '<th width=5%>selling_price</th>';
                echo        '<th width=10%>stock</th>';
                echo        '<th width=10%>product_status</th>';
                echo        '<th width=8%>color</th>';
                echo        '<th width=5%>size</th>';
                echo   '</tr>';
                if ($result = $db->query($sql)) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        //修正ボタンを押してstocksのプライマリーキー送信してadmin.stocks.alter.phpで値をとってくるようにしたい
                        echo '<td>
                                <form action="admin.stocks.alter.php" method="get">
                                <input type="submit" value="修正">
                                <input type="hidden"              name="target_id" value="',$row['id'],'">
                                <input type="hidden"         name="number" value="',$row['number'],'">
                                </form>


                                <form action="admin.stocks.delete.php" method="get">
                                <input type="submit" value="削除">
                                <input type="hidden"         name="target_id" value="',$row['id'],'">
                                <input type="hidden"         name="number" value="',$row['number'],'">
                                </form>
                             </td>';
                    
                        // echo '<td>',$row['id'],'</td>';
                        echo '<td>',$row['number'],'</td>';
                        echo '<td>', $row['type'], '</td>';
                        echo '<td>', $row['about'], '</td>';
                        echo '<td>', $row['maker'], '</td>';
                        echo '<td>', $row['cost'], '</td>';
                        echo '<td>', $row['selling_price'], '</td>';
                        echo '<td>',$row['stock'],'</td>';
                        echo '<td>',$row['product_status'],'</td>';
                        echo '<td>',$row['color'],'</td>';
                        echo '<td>',$row['size'],'</td>';
                        echo '</tr>';

                        //セッションID設定
                       
                    }
                }
                echo '</table>';




                $db ->close();
            ?>

            </div>
            
         
    </body>

</html>
