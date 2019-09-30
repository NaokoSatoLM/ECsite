
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

                <input type="button" onClick="location.href='http://192.168.24.50:8282/register_item1.php'"  value="新規登録">



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

                //変数を受け取る
                $search = "$_GET[search]";
                 //もし変数$searchに値がなければ一覧を表示、あれば検索結果を表示する
                 if (empty($search)) {
                    $sql =  "select * from items"
                            ." join stocks on items.number=stocks.number"
                            ." order by items.number";
                 } else {
                    $sql =  "select * from items"
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
                        echo '<td><input type="button" 
                                        value="修正"　
                                        onclick="location.href=\'http://192.168.24.50:8282/alter_item.php\'">
                                <input type="button" 
                                            value="削除" 
                                            onclick="location.href=\'http://192.168.24.50:8282/admin.stocks.delete.php\'">
                            </td>';
                        
                        echo '<td>', $row['number'], '</td>';
                        echo '<td>', $row['type'], '</td>';
                        echo '<td>', $row['about'], '</td>';
                        echo '<td>', $row['maker'], '</td>';
                        echo '<td>', $row['cost'], '</td>';
                        echo '<td>', $row['selling_price'], '</td>';
                        echo '<td>', $row['stock'], '</td>';
                        echo '<td>', $row['product_status'], '</td>';
                        echo '<td>', $row['color'], '</td>';
                        echo '<td>', $row['size'], '</td>';
                        echo '</tr>';
                    }
                }
                echo '</table>';

                
                $db ->close();
            ?>
            </div>

    </body>

</html>
