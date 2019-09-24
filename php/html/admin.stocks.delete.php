<HTML>
 <body>
 <h1>PLESER JAPAN　削除画面</h1>
        <?php
        include 'database.php';
        include 'template.php';
       
        $db = dbconnect();
        html_header('Pleaser 削除画面');

        // 最初に、メソッドに応じて、処理を分ける
       
        if($_SERVER["REQUEST_METHOD"]=="GET"){
            // GETパラメータを取得して、クエリを発行する
            $target_id = $_GET['target_id'];

            if($target_id){
                $sql =  "select items.number,type,about,maker,cost,selling_price,stock,stocks.id,stock,product_status,color,size from items join stocks on items.number=stocks.number where stocks.id='$target_id'";

                // echo $sql;
                $result = $db->query($sql);


                // 取得したデータをもとに、HTMLを生成する
                stock_table($result, true);
                echo $row['number'];
                echo '<form action="" method="POST">';
                echo '<input type="hidden" name="target_id" value="', $target_id, '">';
                echo '<input type="hidden" name="number" value="',$row['number'],'">';
                echo '<input type="hidden" name="stock" value="',$row['stock'],'">';
                echo '<input type="hidden" name="product_status" value="',$row['product_status'],'">';
                echo '<input type="hidden" name="color" value="',$row['color'],'">';
                echo '<input type="hidden" name="size" value="',$row['size'],'">';
                echo '<input type="submit" value="削除する">';
                echo '</form>';

                echo 'この　stock, product_status,color,size 情報を削除しますか?';
                exit(0);
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            $target_id = $_POST['target_id'];

            
                $sql = "select * from stocks where id='$target_id'" ;
                $result = $db->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo 'number:', $row["number"],'<br>';
                    echo 'stock: ',$row["stock"],'<br>';
                    echo 'product_status: ', $row["product_status"],'<br>';
                    echo 'color: ', $row["color"],'<br>';
                    echo 'size: ',$row["size"],'<br>';
                }
            // echo 'target_id: ', $target_id, '<br>';
            // echo 'stock: ', $stock,'<br>';
            // echo 'product_status: ', $product_status,'<br>';
            // echo 'color: ', $color,'<br>';
            // echo 'size: ', $size,'<br>';

            $sql = "delete from stocks where id='$target_id'";

            $result = $db->query($sql);

            echo "削除完了しました。<br><br>";
            echo '<input type="button" onClick="location.href=\'http://192.168.24.50:8282/admin.stocks.php\'"     value="一覧に戻る">';

            // 実行結果をもとに、HTMLを生成する

            exit(0);
        } else {
            // 許可されていないメソッド
            echo $_SERVER['REQUEST_METHOD'];
            echo "許可されていないメソッドです。";
            http_response_code(405);
            exit(0);
        }
        ?>
     </body>
</html>
