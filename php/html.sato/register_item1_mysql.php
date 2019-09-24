<?php
session_start();

    //register_item1.phpの値を取得取
    $number=$_POST['number'];
    $type=$_POST['type'];
    $about=$_POST['about'];
    $maker=$_POST['maker'];
    $cost=$_POST['cost'];
    $selling_price=$_POST['selling_price'];


    //セッション変数に代入
    $_SESSION['number'] = $number;
    $_SESSION['type'] = $type;
    $_SESSION['about'] = $about;
    $_SESSION['maker'] = $maker;
    $_SESSION['cost'] = $cost;
    $_SESSION['selling_price'] = $selling_price;
    
    // echo $_SESSION['number'];

    if(empty ($_POST['number'] and $_POST['type'] and $_POST['about'] and $_POST['maker'] and $_POST['cost'] and $_POST['selling_price'] )){
        $_SESSION['message'] = '未入力の項目があります';
        header( 'location:http://192.168.24.50:8282/register_item1.php');
        exit();
    }
?>

<html lang ="ja">
    <head>
        <meta charset="utf-8">
        <mata name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
        <meta http-equiv="content-type" content="text/html";charaser="utf-8">
        <!-- <link rel="stylesheet" href="stylesheet-list.css"
        type="text/css"></link> -->
        <meta name="kyeword" content="">
        <meta name="description" content="">
        <title>管理者用新規追加ページ</title>
    </head>

    <body>
        <h1>PLESER JAPAN</h1>
        <h2>管理者用画面-新規登録-</h2>
        <?php
            //データベース接続
            $db = new mysqli('mysql','root','root','shoes_db');
            if ($db->connect_error){
                echo $db->connect_error;
                exit();
                }else{
                    $db->set_charset("utf8");
                };

            

                //INSERT文を変数に格納、
                $stmt = $db ->prepare("INSERT INTO items (number,type,about,maker,cost,selling_price) VALUES (?,?,?,?,?,?)");
                $stmt->bind_param('ssssii',$number,$type,$about,$maker,$cost,$selling_price);


                $stmt->execute(); //sql実行

                echo "<p>number:",$number,"</p>";
                echo "<p>type:",$type,"</p>";
                echo "<p>about:",$about,"</p>";
                echo "<p>makerr:",$maker,"</p>";
                echo "<p>cost:",$cost,"</p>";
                echo "<p>selling_price:",$selling_price,"</p>";
                echo '<p>で登録完了しました。</p>'; // 登録完了のメッセージ
                echo $_SESSION['number'];
                $db ->close();

        ?>


        <form>
            
            <input type="button"   value="一覧に戻る" OnClick="location.href='http://192.168.24.50:8282/admin.add.php'">
        </form>

    </body>

</html>