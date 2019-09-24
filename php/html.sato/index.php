<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>MySQL DB Connect</title>
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
        <meta name="keywords" content="">
        <meta name="description" content="">
    </head>
    <body>

        <header>
        </header>

            <main>

                <div id="main">
                    <?php

                        //データベースに接続
                        $db = new mysqli('mysql','root','root','shoes_db');
                        if ($db->connect_error){
                            echo $db->connect_error;
                            exit();
                        }else{
                            $db->set_charset("utf8");
                        }

                        echo "<table>";
                        //SQL文でデータを取得
                            $sql = "SELECT id, number, type, about,maker,cost,selling_price FROM items";
                            if ($result = $db->query($sql)){
                                //連想配列を取得
                                while ($row = $result->fetch_assoc()){
                                    echo "<tr><td>" . $row["id"] . "</td><td>" .$row["number"]."</td><td>" .$row["type"]."</td><td>" .$row["about"]."</td><td>" .$row["maker"]."</td><td>" .$row["cost"]."</td><td>" .$row["selling_price"]."</td></tr>";
                                }
                            //結果を閉じる
                            $result->close();
                            }
                            echo "</table>";

                        //データベース切断
                        $db->close();

                        phpinfo();
                    ?>
                </div>
    
            </main>

        <footer>
        </footer>
    </body>
</html>

