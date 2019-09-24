<?php
session_start();
$initial_session = $_SESSION ;
session_destroy();
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
        
            <div  id="post page">
            <form method="post" action ="register_item1_mysql.php">
            
                    <?php
                    //表の書式
                    echo '<table border="1" frame ="border" rules="all" style="table-layout:fixed">';
                        echo '<tr valian="top">';
                        echo '<td width=15%>number</td>';
                        echo '<td width=15%>type</td>';
                        echo  '<td width=40%>about</td>';
                        echo  '<td width=10%>maker</td>';
                        echo  '<td width=10%>cost</td>';
                        echo '<td width=10%>selling_price</td>';
                        echo '</tr><tr　>';


                        echo'<form action="" method="post" id="new">';
                            //numbr
                            echo'<td><input type="text" name="number" value="',$initial_session['number'],'"></td>';

                            //type
                            echo'<td><input type="text" name="type" value="',$initial_session['type'],'"></td>';
                            //about
                            echo'<td><textarea name="about" placeholder="商品説明" value="',$initial_session['about'],'"></textarea></td>';
                            //maker
                            echo'<td><input type="text" name="maker" value="',$initial_session['maker'],'">';
                            //cost
                            echo'<td><input type="text" name="cost" placeholder="数字のみ記入" value="',$initial_session['cost'],'"></td>';
                            //selling_price
                            echo'<td><input type="text" name="selling_price"　placeholder="数字のみ記入" value="',$initial_session['selling_price'],'"></td>';
                            echo'</tr>';

                            echo'</form>';
                            echo $_SESSION['message'];
                    echo'</table>';
                    

                    
                    ?>

        
            <input type="submit"  name ="submit" value="確定" class="buttun">
            <input type="reset"   value="クリア">
            <input type="button"   value="一覧に戻る" onclick="location.href='http://192.168.24.50:8282/admin.add.php'">
        </form>

    </body>

</html>