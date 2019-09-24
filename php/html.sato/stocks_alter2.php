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

                    $id=$_GET['target_id'];
                    $_SESSION['target_id']=$id;
                    
                    echo $id;
                    
                        //変更受け付けました画面作成
                            //GET変数を受け取る
                            $stock_alter=$_GET['stock'];
                            $pro_sta_alter=$_GET['product_status'];
                            $color_alter=$_GET['color'];
                            $size_alter=$_GET['size'];
                            echo $stock_alter ;

                            echo $_SESSION['target_id'];
                            $sql="update stocks set 
                            stock='$stock_alter',product_status='$pro_sta_alter',color='$color_alter',size='$size_alter'
                            where stocks.id='$id'";
                            echo $sql;

                            if($result = $db->query($sql)){
                                while($row_alter=$result->fetch_assoc()) {

                                echo $sql;
                            
                                echo '下記変更を受け付けました<br>';
                                echo 'stock:'.$row_alter['stock'].'<br>';
                                echo 'product_status:'.$row_alter['product_status'].'<br>';
                                echo 'color:'.$row_alter['color'].'<br>';
                                echo 'size:'.$row_alter['size'].'<br>';
                                }
                            }
                            
                    
                    
                
                ?>

            </div>
            <!-- ボタン -->
                <input type="button" onClick="location.href='http://192.168.24.50:8282/admin.stocks.php'"     value="一覧に戻る">
                
         <!-- ボタン終わり -->
         
    </body>

</html>