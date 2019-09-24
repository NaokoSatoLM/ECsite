
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

    
    <form action="serch.php" method="post">
        <body>
            <h1>PLESER JAPAN -検索画面-</h1>
                <!-- ボタン -->
                <input type="button" onClick="location.href='http://192.168.24.50:8282/register_item1.php'"  value="新規登録">
                <input type="button" onClick="location.href='http://192.168.24.50:8282/register_item.php'"  value="修正">
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
                
                //変数を受け取る
                $serch = "%$_GET[serch]%";
                echo $serch;
                //検索クエリ
                $sql = "select items.number,type, about,maker,cost,selling_price,stock,product_status,color,size from items inner join stocks on items.number =stocks.number and items.number like '$serch'" ;
                
                echo $sql ;
                if($result = $db->query($sql)){
                    foreach($result as $serch_row){

                        echo '<table border="1" frame ="border" rules="all" style="table-layout:fixed">';

                        echo '<tr valian="top">';
                        // echo '<td width=2%>',$row['id'],'</td>';
                        echo '<td width=10%>',$serch_row['number'],'</td>';
                        echo '<td width=10%>',$serch_row['type'],'</td>';
                        echo '<td width=10%>',$serch_row['about'],'</td>';
                        echo '<td width=5%>',$serch_row['maker'],'</td>';
                        echo '<td width=5%>¥',number_format($serch_row['cost']),'-</td>';
                        echo '<td width=5%>¥',number_format($serch_row['selling_price']),'-</td>';
                        echo '<td width=10%>',$serch_row['stock'],'</td>';
                        echo '<td width=10%>',$serch_row['product_status'],'</td>';
                        echo '<td width=8%>',$serch_row['color'],'</td>';
                        echo '<td width=5%>',$serch_row['size'],'</td>';

                        // echo '<img src="',$row['img'],'"class="heel">';
                        echo'</tr>';

                        echo '</table>';
                    };

                    $result->close();
                }
                echo "</table><br>";
                $db ->close();

            ?>

         


            <!-- <div class="all_items">
            <!--<?php

                    //一覧表示
                    // echo '<table border="1" frame ="border" rules="all" style="table-layout:fixed">';
                    // echo '<tr valian="top">';
                    // // echo '<td width=2%>id</td>';
                    // echo '<td width=10%>number</td>';
                    // echo '<td width=10%>type</td>';
                    // echo  '<td width=10%>about</td>';
                    // echo  '<td width=5%>maker</td>';
                    // echo  '<td width=5%>cost</td>';
                    // echo '<td width=5%>selling_price</td>';
                    // echo '<td width=10%>stock</td>';
                    // echo '<td width=10%>product_status</td>';
                    // echo '<td width=8%>color</td>';
                    // echo '<td width=5%>size</td>';
                    // echo '</tr>';
                    // echo'</table>';

                    // $sql ="select * from items join stocks on items.number=stocks.number order by items.number";
                    
                    // if ($result = $db->query($sql)){
                    //     while( $row = $result->fetch_assoc()){
                    //         echo '<table border="1" frame ="border" rules="all" style="table-layout:fixed">';

                    //         echo '<tr valian="top">';
                            // echo '<td width=2%>',$row['id'],'</td>';
                    //         echo '<td width=10%>',$row['number'],'</td>';
                    //         echo '<td width=10%>',$row['type'],'</td>';
                    //         echo '<td width=10%>',$row['about'],'</td>';
                    //         echo '<td width=5%>',$row['maker'],'</td>';
                    //         echo '<td width=5%>¥',number_format($row['cost']),'-</td>';
                    //         echo '<td width=5%>¥',number_format($row['selling_price']),'-</td>';
                    //         echo '<td width=10%>',$row['stock'],'</td>';
                    //         echo '<td width=10%>',$row['product_status'],'</td>';
                    //         echo '<td width=8%>',$row['color'],'</td>';
                    //         echo '<td width=5%>',$row['size'],'</td>';

                    //         // echo '<img src="',$row['img'],'"class="heel">';
                    //         echo'</tr>';

                    //         echo '</table>';
                    //     }

                    //     $result->close();
                    // }
                    // echo "</table><br>";
                    // $db ->close();

                    // ?>
            </div> -->

    </body>
 </form>
</html>