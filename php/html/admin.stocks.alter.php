<HTML>
 <body>
 <h1>PLESER JAPAN</h1>
        <?php
        include 'database.php';
        include 'template.php';

        $db = dbconnect();
        html_header('Pleaser 変更画面');

        // 最初に、メソッドに応じて、処理を分ける
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            // GETパラメータを取得して、クエリを発行する
            $target_id = $_GET['target_id'];

            $sql =  "select items.number,type,about,maker,cost,selling_price,stock,stocks.id,stock,product_status,color,size from items join stocks on items.number=stocks.number where stocks.id='$target_id'";

            // echo $sql;
            $result = $db->query($sql);


            // 取得したデータをもとに、HTMLを生成する
            stock_table($result, false);

            exit(0);


        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {

            // POSTパラメータを取得して、クエリを発行する
            $number = $_POST['number'];
            $stock = $_POST['stock'];
            $product_status = $_POST['product_status'];
            $color = $_POST['color'];
            $size = $_POST['size'];

            echo 'number: ', $number, '<br>';
            echo 'stock: ', $stock,'<br>';
            echo 'product_status: ', $product_status,'<br>';
            echo 'color: ', $color,'<br>';
            echo 'size: ', $size,'<br>';

            $sql = "update stocks set stock='$stock', product_status='$product_status', color='$color', size='$size' where stocks.id='$target_id'";

            $result = $db->query($sql);

            echo "更新完了しました。<br><br>";
            echo '<input type="button" onClick="location.href=\'http://192.168.24.50:8282/admin.stocks.php\'"     value="一覧に戻る">';

            // 実行結果をもとに、HTMLを生成する

            exit(0);

        } else {
            // 許可されていないメソッド
            echo "許可されていないメソッドです。";
            http_response_code(405);
            exit(0);
        }
        ?>
     </body>
</html>   
        